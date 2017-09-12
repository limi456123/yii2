comp<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170910_031033_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),

//            tree	int()	��id
//lft	int()	��ֵ
//rgt	int()	��ֵ
//depth	int()	�㼶
//name	varchar(50)	����
//parent_id	int()	�ϼ�����id
//intro	text()	���
        'tree'=>$this->integer()->comment('��id'),
            'lft'=>$this->integer()->comment('��ֵ'),
            'rgt'=>$this->integer()->comment('��ֵ'),
            'depth'=>$this->integer()->comment('�㼶'),
            'name'=>$this->string(50)->comment('����'),
            'parent_id'=>$this->integer()->comment('�ϼ�����id'),
            'intro'=>$this->text()->comment('���')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
