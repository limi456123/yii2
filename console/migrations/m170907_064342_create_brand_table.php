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
            'name'=>$this->string(50)->comment('����'),
            'intro'=>$this->string()->comment('���'),
            'logo'=>$this->string(255)->comment('logoͼƬ'),
            'sort'=>$this->integer(11)->comment('����'),
            'status'=>$this->smallInteger(2)->comment('-1ɾ��,0����,1����')
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
