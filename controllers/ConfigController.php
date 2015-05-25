<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Cookie;
use app\models\ConfigFile;
use app\models\Slic3rConfig;
use yii\helpers\Html;

class ConfigController extends AppController
{
	public $defaultAction = 'print-setting';
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

	public function initialConfig($initial_ini_name = NULL)
	{
		$ConfigFile = new ConfigFile();
		
		$ConfigFile->initial($initial_ini_name);
		
		$config_file_ini = $ConfigFile->readConfigFile();
		
		$Slic3rConfig = new Slic3rConfig();
		$Slic3rConfig->initialConfig($config_file_ini);
		
		return $Slic3rConfig;
	}
	
	public function actionLoad($config_name = NULL)
	{	
		$Slic3rConfig = $this->initialConfig($config_name);
		
		$this->redirect(['/config/print-setting']);
	}
	
	public function actionPrintSetting()
	{
		$Slic3rConfig = $this->initialConfig();
		
		//echo $Slic3rConfig->nozzle_diameter;
		//exit();
		
		if ($Slic3rConfig->load(Yii::$app->request->post()) && $Slic3rConfig->validate()) {
			Yii::$app->session->addFlash('sucess', '<span class="glyphicon glyphicon-ok"></span> <strong>Sucessful ! </strong> Save Slic3r Configration');
			$Slic3rConfig->save();
            return $this->refresh();
        } else {
			
			
            return $this->render('print_setting', [
                'Slic3rConfig'=>$Slic3rConfig,
            ]);
        }
		//return $this->render('print_setting', ['Slic3rConfig'=>$Slic3rConfig]);
	}
	
	public function actionFilamentSetting()
	{
		$Slic3rConfig = $this->initialConfig();
		
		//echo $Slic3rConfig->nozzle_diameter;
		//exit();
		
		if ($Slic3rConfig->load(Yii::$app->request->post()) && $Slic3rConfig->validate()) {
			Yii::$app->session->addFlash('sucess', '<span class="glyphicon glyphicon-ok"></span> <strong>Sucessful ! </strong> Save Slic3r Configration');
			$Slic3rConfig->save();
            return $this->refresh();
        } else {
			
			
            return $this->render('filament_setting', [
                'Slic3rConfig'=>$Slic3rConfig,
            ]);
        }
	}
	public function actionPrinterSetting()
	{
		$Slic3rConfig = $this->initialConfig();
		
		//echo $Slic3rConfig->nozzle_diameter;
		//exit();
		
		if ($Slic3rConfig->load(Yii::$app->request->post()) && $Slic3rConfig->validate()) {
			Yii::$app->session->addFlash('sucess', '<span class="glyphicon glyphicon-ok"></span> <strong>Sucessful ! </strong> Save Slic3r Configration');
			$Slic3rConfig->save();
            return $this->refresh();
        } else {
			
			
            return $this->render('printer_setting', [
                'Slic3rConfig'=>$Slic3rConfig,
            ]);
        }
	}

    public function actionIndex()
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
		
		/* write new variable/value to configration file
		$config = new \Config_Lite($config_file, LOCK_EX);
		$config->set(null, 'bed_size', '230, 230');
		$config->sync();
		*/
		
		//print_r($config);
		
		
		$config = str_replace('"', ' ', $config);
	
		//echo $config;
		$new_config_file = $cookies['cache_config'].'tial.ini';
		echo $new_config_file;

		if(file_exists($new_config_file))
		{
			unlink($new_config_file);
		}
		
		$write_file = file_put_contents($new_config_file, $config, FILE_APPEND);
		
		//exit();
		
		if($write_file)
		{
			$file = $new_config_file; //file location 
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
			header('Content-Length: ' . filesize($file));
			readfile($file);
		}
		
		/*
		foreach($config as $key => $value)
		{
			//echo '[[';
			echo $key;
			echo '=>';
			echo $value;
			echo '<br/>';
		}
		*/
		exit();
        //return $this->render('index');
    }

	public function actionDownload()
	{
		$cookies = Yii::$app->request->cookies;
		$config_file = $cookies['cache_config'];
		$config_folder = $cookies['cache_config_folder'];

		$config_lite = Yii::getAlias('@config_lite/');
		require_once ($config_lite.'Lite.php');

		$config = new \Config_Lite($config_file);
		
		$config = str_replace('"', ' ', $config);

		$new_config_file = $config_folder.'Slic3-Config.ini';
		
		if(file_exists($new_config_file))
		{
			unlink($new_config_file);
		}
		
		$write_file = file_put_contents($new_config_file, $config, FILE_APPEND);
		
		if($write_file)
		{
			$file = $new_config_file; //file location 
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
			header('Content-Length: ' . filesize($file));
			readfile($file);
		}
	}

	public function create_random_value($length, $type = 'mixed')
	{
		if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;
	
		$rand_value = '';
		while (strlen($rand_value) < $length) {
		  if ($type == 'digits') {
			$char = $this->controller_rand(0,9);
		  } else {
			$char = chr($this->controller_rand(0,255));
		  }
		  if ($type == 'mixed') {
			if (preg_match('/^[a-z0-9]$/i', $char)) $rand_value .= $char;
		  } elseif ($type == 'chars') {
			if (preg_match('/^[a-z]$/i', $char)) $rand_value .= $char;
		  } elseif ($type == 'digits') {
			if (preg_match('/^[0-9]$/', $char)) $rand_value .= $char;
		  }
		}
	
		return $rand_value;
  	}

	public function controller_rand($min = null, $max = null) 
	{
			
			static $seeded;
			if (!isset($seeded)) {
			  mt_srand((double)microtime()*1000000);
			  $seeded = true;
			}

			if (isset($min) && isset($max)) {
			  if ($min >= $max) {
				return $min;
			  } else {
				return mt_rand($min, $max);
			  }
			} else {
			  return mt_rand();
			}
	}
		
}
