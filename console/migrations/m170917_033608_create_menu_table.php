<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170917_033608_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->comment('����'),
            'parent_id'=>$this->integer()->comment('�ϼ��˵�'),
            'route'=>$this->string()->comment('��ַ'),
            'sort'=>$this->integer()->comment('����'),
            'status'=>$this->integer()->defaultValue(1)->comment('״̬')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
