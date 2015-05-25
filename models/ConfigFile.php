<?php
/**
*	Slic3r Config execution class for PHP
*	Creation Date: November 2014
*	@author Jing Guo
*	@version 1.0
*/		

namespace app\models;

use yii;
use yii\caching\FileCache;
use yii\helpers\FileHelper;
use yii\web\Cookie;

class ConfigFile
{
	
	public function initial($initial_ini_file = NULL)
	{
		$session = Yii::$app->session;
		$session->open();
		$session_id = $session->id;
		
		$sessions_data = Sessions::findOne(['session_id'=>$session_id]);
		
		if($sessions_data == NULL) {
			$sessions_data = new Sessions();
			$sessions_data->session_id = $session_id;
			$sessions_data->created_date = date("Y-m-d H:i:s");
			// 2001-03-10 17:16:18 (the MySQL DATETIME format)
			$sessions_data->save();
		} else {
			$sessions_data->updateAttributes(['created_date' => date("Y-m-d H:i:s")]); 
		}
		
		$default_config_name = 'mix_mini.ini';
		$default_config_path = Yii::getAlias('@app/data').'/';
		$default_config = $default_config_path.$default_config_name;
		
		$initial_config_name = $initial_ini_file;
		$initial_config = $default_config_path.$initial_config_name;
		$copy_new_initial_config = false;
		
		if($initial_config_name != NULL and !empty($initial_config_name) and file_exists($initial_config))
		{
			$default_config = $initial_config;
			Yii::$app->session->addFlash('sucess', '<span class="glyphicon glyphicon-info-sign"></span> Sucessfully find the configration <strong>'.$initial_config_name.'</strong>');
			$copy_new_initial_config = true;
			
		} else if($initial_config_name != NULL and !empty($initial_config_name))
		{
			Yii::$app->session->addFlash('danger', '<span class="glyphicon glyphicon-info-sign"></span> <strong> Error !</strong> Unable to load <strong>'.$initial_config_name.'</strong>');
		}
		
		$cache_config_name = 'slic3r_config.ini';
		$default_config_cache_folder = Yii::getAlias('@runtime/config_cache/');
		$cache_path = $default_config_cache_folder.$session_id.'/';

		if (!is_dir($cache_path)) {
			// create the config cache for new session
            FileHelper::createDirectory($cache_path, 0775, true);
        }
		
		$cache_config = $cache_path.$cache_config_name;
		
		if(!file_exists($cache_config) or $copy_new_initial_config == true)
		{
			$copy = copy($default_config, $cache_config);
			
			if($copy_new_initial_config == true and $copy == true)
			{
				Yii::$app->session->addFlash('sucess', '<span class="glyphicon glyphicon-ok"></span> load the configration Sucessfully.');
			}
		}
		
		
		$cookies = Yii::$app->response->cookies;
		
		// add a cache_configration location to the cookie for easy use
		// the location should be: @runtime/config_cache/session_id/
		$cookies->add(new \yii\web\Cookie([
			'name' => 'cache_config',
			'value' => $cache_config,
		]));
		
		$cookies->add(new \yii\web\Cookie([
			'name' => 'cache_config_folder',
			'value' => $cache_path,
		]));

	}

	public function readConfigFile()
	{
		$cookies = Yii::$app->response->cookies;
		$config_file = $cookies['cache_config'];

		/*
		$default_config_name = 'mix_mini.ini';
		$default_config_path = Yii::getAlias('@app/data').'/';
		$default_config = $default_config_path.$default_config_name;
		*/
		
		// Loading extension
		$config_lite = Yii::getAlias('@config_lite/');
		require_once ($config_lite.'Lite.php');
		
		//echo $config_file;
		
	
		$config = new \Config_Lite($config_file);
		
		return $config;
	}


}