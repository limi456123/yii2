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

//            name	varchar(50)	����
//intro	text	���
//sort	int(11)	����
//status	int(2)	״̬(-1ɾ�� 0���� 1����)
         'name'=>$this->string(255)->comment('����'),
            'intro'=>$this->string()->comment('���'),
            'sort'=>$this->integer(11)->comment('����'),
            'status'=>$this->smallInteger(2)->comment('״̬-1ɾ�� 0���� 1����')
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
