<?php 

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ConfigFile;

class AppController extends Controller
{
	public function beforeAction($action)
	{
		if(parent::beforeAction($action)) {
			/*
			$ConfigFile = new ConfigFile();
			$ConfigFile->initial();
			*/
			return true;
		} else {
			return false;
		}
	}
}