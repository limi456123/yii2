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
            'username'=>$this->string()->comment('用户名'),
            'auth_key'=>$this->string()->comment('口令'),
             'password_hash'=>$this->string()->comment('密码'),
            'password_reset_token'=>$this->string()->comment('确认密码'),
            'email'=>$this->string()->comment('邮箱'),
            'status'=>$this->smallInteger(6)->comment('状态'),
            'created_at'=>$this->integer()->comment('创建时间'),
            'updated_at'=>$this->integer()->comment('跟新时间'),
             'last_login_time'=>$this->integer()->comment('最后登录时间'),
             'last_login_ip'=>$this->integer()->comment('最后登录ip')
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
