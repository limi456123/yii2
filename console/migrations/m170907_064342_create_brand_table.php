<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170907_064342_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('Ãû³Æ'),
            'intro'=>$this->string()->comment('¼ò½é'),
            'logo'=>$this->string(255)->comment('logoÍ¼Æ¬'),
            'sort'=>$this->integer(11)->comment('ÅÅÐò'),
            'status'=>$this->smallInteger(2)->comment('-1É¾³ý,0Òþ²Ø,1Õý³£')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
