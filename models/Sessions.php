<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sessions".
 *
 * @property integer $id
 * @property string $session_id
 * @property string $created_date
 */
class Sessions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sessions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['session_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session ID',
            'created_date' => 'Created Date',
        ];
    }
}