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
            'name'=>$this->string()->comment('名称'),
            'parent_id'=>$this->integer()->comment('上级菜单'),
            'route'=>$this->string()->comment('地址'),
            'sort'=>$this->integer()->comment('排序'),
            'status'=>$this->integer()->defaultValue(1)->comment('状态')
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
