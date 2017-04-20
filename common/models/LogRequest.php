<?php

namespace common\models;

use yii;
use yii\behaviors\TimestampBehavior;

/**
* This is the model class for table "log_request".
*
* @property integer $id
* @property string $url
* @property string $method
* @property string $headers_json
* @property string $raw_body
* @property string $body_params
* @property string $response_code
* @property integer $created_at
*/
class LogRequest extends \yii\db\ActiveRecord
{
  /**
  * @inheritdoc
  */
  public static function tableName(){
    return 'log_request';
  }
  /**
  * @inheritdoc
  */
  public function behaviors(){
    return [
      'timestamp' => [
        'class'=>TimestampBehavior::className(),
        'createdAtAttribute' => 'created_at',
        'updatedAtAttribute' => false,
      ]
    ];
  }


  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [
      [['url', 'method'], 'required'],
      [['headers_json', 'raw_body', 'body_params', 'response_code'], 'string'],

      [['url'], 'string', 'max' => 255],
      [['method'], 'string', 'max' => 6],
    ];
  }

  /**
  * @inheritdoc
  */
  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'url' => 'Url',
      'method' => 'Method',
      'headers_json' => 'Headers Json',
      'raw_body' => 'Raw Body',
      'body_params' => 'Body Params',
      'response_code' => 'Response Code',
      'created_at' => 'Created At',
    ];
  }
}
