<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170907_082351_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),

//            name	varchar(50)	Ãû³Æ
//intro	text	¼ò½é
//sort	int(11)	ÅÅÐò
//status	int(2)	×´Ì¬(-1É¾³ý 0Òþ²Ø 1Õý³£)
         'name'=>$this->string(255)->comment('Ãû³Æ'),
            'intro'=>$this->string()->comment('¼ò½é'),
            'sort'=>$this->integer(11)->comment('ÅÅÐò'),
            'status'=>$this->smallInteger(2)->comment('×´Ì¬-1É¾³ý 0Òþ²Ø 1Õý³£')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
