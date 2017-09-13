<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m170913_023133_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->comment('�û���'),
            'auth_key'=>$this->string()->comment('����'),
             'password_hash'=>$this->string()->comment('����'),
            'password_reset_token'=>$this->string()->comment('ȷ������')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
