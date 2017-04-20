<?php
namespace servertoken\migrations;
use yii\db\Schema;
use yii\db\Migration;
/**
*@inheritdoc
*/
class m141026_154425_initial extends Migration
{
  private $bsoList;
  /**
  *@inheritdoc
  */
  public function init(){
    $par=include(\Yii::getAlias('@servertoken/config/params.php'));
    $this->bsoList=$par['bsoList'];
  }
  /**
  *@inheritdoc
  */
  public function up()
  {

    //List of collections
    $this->createTable(
      'sync_collections',[
        'id' => 'pk',
        'name'=>$this->string()->notNull()
      ]
    );
    foreach ($this->bsoList as $oneBso){
      $this->db->createCommand("insert into sync_collections values (0,'".$oneBso."')")->execute();
    }
    //List of user collections
    $this->createTable(
      'sync_user_collections', [
        'id'        =>    $this->primaryKey(),
        'user_id'   =>    $this->integer()->notNull(),
        'collection'=>    $this->string()->notNull(),
        'nb_records'=>    $this->integer(),
        'lastUpdate'=>    $this->string()->notNull(),
        'lastAccess'=>    $this->string()->notNull(),
      ]
    );
    foreach ($this->bsoList as $oneBso){
      $this->createTAble(
        'storage_'.$oneBso,[
          'id'     =>     $this->primaryKey(),
          'user_id'=>     $this->integer()->notNull(),
          'bso_id'=>      $this->string()->notNull(),
          'sortindex'=>   $this->decimal(19,4)->notNull(),
          'modified'=>    $this->string()->notNull(),
          'payload'=>     $this->string()->notNull(),
          'payload_size'=>$this->decimal(19,4)->notNull(),
          'ttl'=>         $this->integer()->notNull(),
          'updated_at'=>  $this->integer()->notNull(),
          'created_at'=>  $this->integer()->notNull(),
        ]
      );
    }
    //list of users
    $this->createTable(
      'sync_user',[
        'id'=>            $this->primaryKey(),
        'user_id'=>       $this->integer()->notNull(),
        'email'=>         $this->string()->notNull(),
        'created_at'=>    $this->integer()->unsigned()->notNull(),
        'updated_at'=>    $this->integer()->unsigned()->notNull(),
      ]
    );
    //List of devices
    $this->createTable(
      'sync_device',[
        'id'=>            $this->primaryKey(),
        'user_id'=>       $this->integer()->notnull(),
        'deviceid'=>      $this->string()->notNull(),
      ]
    );
  }
  /**
  * @inheritdoc
  */
  public function down(){
    $this->dropTable('sync_device');
    $this->dropTable('sync_user');
    $this->dropTable('sync_user_collections');
    $this->dropTable('sync_collections');
    foreach ($this->bsoList as $oneBso){
      $this->dropTable('storage_'.$oneBso);
    }
  }
}
