<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170907_093838_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
//            name	varchar(50)	����
//intro	text	���
//article_category_id	int()	���·���id
//sort	int(11)	����
//status	int(2)	״̬(-1ɾ�� 0���� 1����)
//create_time	int(11)	����ʱ��

        'name'=>$this->string(50)->comment('����'),
            'intro'=>$this->string()->comment('���'),
            'article_category_id'=>$this->integer()->comment('���·���id'),
            'sort'=>$this->integer(11)->comment('����'),
            'status'=>$this->integer(2)->comment('״̬(-1ɾ�� 0���� 1����)'),
            'create_time'=>$this->integer(11)->comment('����ʱ��')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
