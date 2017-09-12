<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170911_022312_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->comment('��Ʒ����'),
            'sn'=>$this->string(20)->comment('����'),
            'logo'=>$this->string(255)->comment('logoͼƬ'),
            'goods_category_id'=>$this->integer()->comment('��Ʒ����id'),
            'brand_id'=>$this->integer()->comment('Ʒ�Ʒ���'),
            'market_price'=>$this->decimal(10,2)->comment('�г��۸�'),
            'shop_price'=>$this->decimal(10,2)->comment('��Ʒ�۸�'),
            'stock'=>$this->integer()->comment('���'),
            'is_on_sale'=>$this->smallInteger(1)->comment('�Ƿ�����(1���� 0�¼�)'),
            'status'=>$this->smallInteger(1)->comment('״̬(1���� 0����վ)'),
            'sort'=>$this->integer()->comment('����'),
            'create_time'=>$this->integer()->comment('���ʱ��'),
            'view_times'=>$this->integer()->comment('�������')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
