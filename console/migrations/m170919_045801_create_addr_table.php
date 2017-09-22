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
            'name'=>$this->string()->comment('�û���'),
            'shen'=>$this->integer()->comment('ʡ'),
            'city'=>$this->integer()->comment('��'),
            'qu'=>$this->integer()->comment('��/��'),
            'addr'=>$this->string()->comment('��ϸ��ַ'),
            'del'=>$this->string()->comment('�绰'),
            'sname'=>$this->string()->comment('�ջ���')
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
