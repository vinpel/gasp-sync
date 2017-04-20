<?php

use yii\db\Migration;
/**
* @inheritdoc
*/
class m170418_191248_log_request extends Migration
{
  /**
  * @inheritdoc
  */
  public function up() {
    $this->createTable('log_request',[
      'id'            =>$this->primaryKey(),
      'url'           =>$this->string()->notNull(),
      'method'        =>$this->string(6)->notNull(),
      'headers_json'  =>$this->text(),
      'raw_body'      =>$this->text(),
      'body_params'   =>$this->text(),
      'response_code' =>$this->text(3),
      'created_at'    =>$this->integer(11)->notNull()
    ]);

  }
  /**
  * @inheritdoc
  */
  public function down() {
    $this->dropTable('log_request');
  }
}
