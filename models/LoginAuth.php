<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Users;


// FACEBOOK: https://developers.facebook.com/apps/826395650708525/dashboard/
// GOOGLE: https://console.developers.google.com/

class LoginAuth
{
	public $rememberMe = true;
	
	private $auth_id;
	private $auth_name;
	
	public function facebook($attributes)
	{
		$this->auth_id = 'facebook_id';
		$this->auth_name = 'facebook';
		
		$array = array();
		
		$a = $attributes;
		$facebook_id = $a['id'];
		$default_pw_token= "onbook_facebook";
		$default_pw = $default_pw_token.$facebook_id;
		$password_hash = MD5($default_pw);
		
		$array['facebook_id'] = $facebook_id;
		$array['username'] = $a['username'];
		$array['lastname'] = $a['last_name'];
		$array['firstname'] = $a['first_name'];
		$array['email'] = $a['email']; 
		$array['password'] = $password_hash;
		
		$user = Users::findOne(['facebook_id'=>$array['facebook_id']]);
		
		if($user != NULL)
		{
			$old_pw = $user->password; // read the old pw
			$user->attributes = $array;
			
			if($old_pw != $array['password'])
				$user->password = $old_pw; // if the password is change by user, keep it

			$user->update();
		} else {
			$user = new Users();
			$user->attributes = $array;
			$user->save();
		}
		
		$this->login($user);

	}
	

	public function google($attributes)
	{
		$this->auth_id = 'google_id';
		$this->auth_name = 'google';
		
		$array = array();
		
		$id = $attributes['id'];
		$username = $attributes['displayName'];
		$emails = $attributes['emails']; // It return an array from Google
		$name = $attributes['name']; //Array
		
		$default_pw_token= "onbook_google";
		$default_pw = $default_pw_token.$id;
		$password_hash = MD5($default_pw);
		
		foreach($emails as $e)
			$email_value = $e['value'];
		
		$first_name = $name['givenName'];
		$last_name = $name['familyName'];
		
		$array['google_id'] = $id;
		$array['username'] = $username;
		$array['email']= $email_value;
		$array['firstname'] = $first_name;
		$array['lastname'] = $last_name;
		$array['password'] = $password_hash;
		
		$user = Users::findOne(['google_id'=>$array['google_id']]);
		
		if($user != NULL)
		{
			$old_pw = $user->password; // read the old pw
			$user->attributes = $array;
			
			if($old_pw != $array['password'])
				$user->password = $old_pw; // if the password is change by user, keep it

			$user->update();
		} else {
			$user = new Users();
			$user->attributes = $array;
			$user->save();
		}
		
		$this->login($user);
		
	}
	
	public function Login($user)
	{
		return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
		
	}
	
}
