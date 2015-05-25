<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Sessions;


class AdminController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-sessions' => ['post'],
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
	
	private function sessions_data($in_hour)
	{
		$in_hour = (int)($in_hour);
		$sessions_data = Sessions::find()->where(' DATE_SUB(CURDATE(),INTERVAL '.$in_hour.' HOUR) >= created_date')->all();
		
		if($sessions_data)
			return $sessions_data;
		else
			return false;
	}
	
	private function sessions_add_flash($key, $value)
	{
		$session = Yii::$app->session;
		// void addFlash( $key, $value = true, $removeAfterAccess = true )
		$session->addFlash($key, $value, true);
	}
	
	private function sessions_clear_flashes()
	{
		$session = Yii::$app->session;
		$session->removeAllFlashes();
	}
	
	function recursive_remove_directory($directory)
	{
		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) { 
				recursiveRemoveDirectory($file);
			} else {
				unlink($file);
			}
		}
		rmdir($directory);
	}
	
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionDeleteSessions()
    {
		// clean the sessions greater than 24*30 hours
		$sessions_data = $this->sessions_data(720);
		
		// set default sessions_data to none;
		$size = 0;
		if($sessions_data)
		{
			$default_config_cache_folder = Yii::getAlias('@runtime/config_cache/');
			$size = count($sessions_data);
			foreach($sessions_data as $value)
			{
				//print_r($value);
				//echo $value['session_id'];
				$dir = $default_config_cache_folder.$value['session_id'];
				if(file_exists($dir))
					$this->recursive_remove_directory($dir);
				
				//delete sessions from data table
				
				$sessions_tabel_data = Sessions::findOne($value['id']);
				$sessions_tabel_data->delete();	
					
			}
		}
		
		$this->sessions_add_flash('alert', 'Total '.$size.' sessions folder is removed');
		
        return $this->redirect(['admin/index']);
    }
}
