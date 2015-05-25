<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{
    public $authKey; // I don't use it now, but I still need to define it here
    public $accessToken; // same above

	public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'created_date',
      	 	    'updatedAtAttribute' => 'updated_date',
				'value' => function ($event) {
					return date("Y-m-d H:i:s", time()); //PHP TIME save to MySQL
				},
            ],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['created_date', 'updated_date', 'last_login_date'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['default_address_book_id'], 'integer'],
            [['mixshop_id', 'google_id', 'facebook_id'], 'string', 'max' => 30],
            [['email', 'username', 'last_login_ip', 'previous_login_ip'], 'string', 'max' => 96],
            [['password'], 'string', 'max' => 60],
			[['email'],'email'],
			['email', 'unique', 'on'=>'create_account'],
            [['firstname', 'lastname', 'telephone'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mixshop_id' => Yii::t('app', 'Mixshop ID'),
            'facebook_id' => Yii::t('app', 'Facebook ID'),
            'google_id' => Yii::t('app', 'Google ID'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'username' => Yii::t('app', 'Username'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'telephone' => Yii::t('app', 'Telephone'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'last_login_ip' => Yii::t('app', 'Last Login Ip'),
            'previous_login_ip' => Yii::t('app', 'Previous Login Ip'),
            'default_address_book_id' => Yii::t('app', 'Default Address Book ID'),
        ];
    }
	
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			
			$ip = $_SERVER['REMOTE_ADDR'];
			
			if($this->isNewRecord) {
				$this->previous_login_ip = $ip;
				$this->last_login_ip = $ip;
			}
			else {
				$this->previous_login_ip = $this->last_login_ip;
				$this->last_login_ip = $ip;
			}
				
			return true;
		} else {
			return false;
		}
	}
	
    public static function findIdentity($id)
    {
        return static::findOne($id);
		//return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
	
	public static function findByEmail($email)
    {
			
		if(static::findOne(['email' => $email]))
			return static::findOne(['email' => $email]);
		else 
			return NULL;
    }	
	
	public function validatePassword($password)
    {
        return $this->password === MD5($password);
    }
}