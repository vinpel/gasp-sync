<?php
namespace servertoken\migrations;
use yii\db\Schema;
use yii\db\Migration;
/**
* @inheritdoc
*/
class m141231_154819_account_tables extends Migration{
  /**
  * @inheritdoc
  */
  public function up(){
    $this->createTable(
      'acc_accounts', [
        'id'              =>  $this->primaryKey(),
        'uid'             =>  $this->string()->notNull(),
        'normalizedEmail' =>  $this->string()->notNull(),
        'email'           =>  $this->string()->notNull(),
        'emailCode'       =>  $this->string(),
        'emailVerified'   =>  $this->boolean()->defaultValue(false),
        'kA'              =>  $this->string()->notNull(),
        'wrapWrapKb'      =>  $this->string()->notNull(),
        'authSalt'        =>  $this->string()->notNull(),
        'verifyHash'      =>  $this->string()->notNull(),
        'verifierVersion' =>  $this->bigInteger(),
        'verifierSetAt'   =>  $this->bigInteger()->notNull(),
        'INDEX `INDX_acc_accounts` (`uid`)',
      ]
    );
    $this->createTable(
      'acc_keyfetchtokens', [
        'id' =>         $this->primaryKey(),
        'uid'     =>    $this->string()->notNull(),
        'tokenId'=>     $this->string()->notNull(),
        'authKey'=>     $this->string()->notNull(),
        'uid'=>         $this->string()->notNull(),
        'keyBundle'=>   $this->string()->notNull(),
        'createdAt'=>   $this->string()->notNull(),
        'INDEX `FK_acc_keyfetchtokens_acc_accounts` (`uid`),
        CONSTRAINT `FK_acc_keyfetchtokens_acc_accounts` FOREIGN KEY (`uid`) REFERENCES `acc_accounts` (`uid`)'
      ]
    );
    $this->createTable(
      'acc_sessionTokens', [
        'id' => 'pk',
        'uid'      =>$this->string()->notNull(),
        'tokenId'  =>$this->string()->notNull(),
        'tokenData'=>$this->string()->notNull(),
        'createdAt'=>$this->string()->notNull(),
        'INDEX `FK_acc_sessionTokens_acc_accounts` (`uid`),
        CONSTRAINT `FK_acc_sessionTokens_acc_accounts` FOREIGN KEY (`uid`) REFERENCES `acc_accounts` (`uid`)'
      ]
    );
  }
  /**
  * @inheritdoc
  */
  public function down(){
    $this->dropTable('acc_keyfetchtokens');
    $this->dropTable('acc_sessionTokens');
    $this->dropTable('acc_accounts');
  }
}
