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
            'password_reset_token'=>$this->string()->comment('ȷ������'),
            'email'=>$this->string()->comment('����'),
            'status'=>$this->smallInteger(6)->comment('״̬'),
            'created_at'=>$this->integer()->comment('����ʱ��'),
            'updated_at'=>$this->integer()->comment('����ʱ��'),
             'last_login_time'=>$this->integer()->comment('����¼ʱ��'),
             'last_login_ip'=>$this->integer()->comment('����¼ip')
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
