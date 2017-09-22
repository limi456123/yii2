<?php

use yii\db\Migration;

/**
 * Handles the creation of table `addr`.
 */
class m170919_045801_create_addr_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('addr', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->comment('用户名'),
            'shen'=>$this->integer()->comment('省'),
            'city'=>$this->integer()->comment('市'),
            'qu'=>$this->integer()->comment('区/县'),
            'addr'=>$this->string()->comment('详细地址'),
            'del'=>$this->string()->comment('电话'),
            'sname'=>$this->string()->comment('收货人')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('addr');
    }
}
