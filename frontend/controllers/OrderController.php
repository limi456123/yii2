<?php
namespace frontend\controllers;
use backend\models\Goods;
use frontend\models\Addr;
use frontend\models\Cart;
use frontend\models\Locations;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\db\Exception;
use yii\web\ConflictHttpException;
use yii\web\Controller;

class OrderController extends Controller{
    public function actionIndex(){
            if(\Yii::$app->user->identity){
                $user_name=\Yii::$app->user->identity->username;
                $member_id=\Yii::$app->user->identity->id;
        //地址
                $addrs=Addr::find()->where(['name'=>$user_name])->asArray()->all();
                foreach($addrs as &$addr){
                    $addr['shen']=Locations::find()->where(['id'=>$addr['shen']])->one()->name;
                    $addr['city']=Locations::find()->where(['id'=>$addr['city']])->one()->name;
                    $addr['qu']=Locations::find()->where(['id'=>$addr['qu']])->one()->name;
                }
        //购物车
                $carts=Cart::find()->where(['member_id'=>$member_id])->all();
                $goodsbox=[];
                $cartbox=[];
                foreach($carts as $cart){
                    $goodsbox[]=Goods::find()->where(['id'=>$cart->goods_id])->one();
                    $cartbox[$cart->goods_id]=$cart->amount;
                }
        //配送方法
               $delivery=Order::$delivery;
          //支付方式
                $payment=Order::$payment;
               return $this->renderPartial('flow2',['addrs'=>$addrs,
                   'goodsbox'=>$goodsbox,'cartbox'=> $cartbox,'delivery'=>$delivery,'payment'=>$payment]);
            }else{
                return $this->redirect(['member/login']);
            }
    }
    public function actionAdd(){

       $request=\Yii::$app->request;
        $order=new Order();
        $order->load($request->post(),'');
        if($order->validate()){
          $order->member_id=\Yii::$app->user->id;
            $addr_id=$order->address_id;
            $addr=Addr::findOne(['id'=>$addr_id]);
            $order->name=$addr->sname;
//            var_dump($order->name);exit;
            //地址
            $shenname=$addr->getAddrname($addr->shen);
            $cityname=$addr->getAddrname($addr->city);
            $quname=$addr->getAddrname($addr->qu);
            $order->province=$shenname;
            $order->city=$cityname;
            $order->area=$quname;
            $order->address=$addr->addr;
            $order->tel=$addr->del;
          //配送方式
          $num= $order->delivery_id;
           $delivery=Order::$delivery;
            $order->delivery_id= $num;
            $order->delivery_name=$delivery[$num][0] ;
            $order->delivery_price=$delivery[$num][1] ;
          //支付方式
            $paynum=$order->payment_id;
            $order->payment_id=$paynum;
            $payment=$order::$payment;
            $order->payment_name=$payment[$paynum][0];
            //订单总金额
            $carts=Cart::find()->where(['member_id'=>\Yii::$app->user->identity->id])->all();
                $price=0;
                foreach($carts as $cart){
                    $goodone=Goods::find()->where(['id'=>$cart->goods_id])->one();
                    $price += ($goodone->shop_price)*($cart->amount);
                }
             $priceall=$price+$delivery[$num][1];
//            var_dump($priceall);exit;
             $order->total=$priceall;
            $order->status=0;
            $order->create_time=time();
  //判断商品库存
          $transaction=  \Yii::$app->db->beginTransaction();
            try{
               $order->save(false);
                $carts=Cart::find()->where(['member_id'=>\Yii::$app->user->id])->all();
                foreach($carts as $cart){
                    $goods=Goods::find()->where(['id'=>$cart->goods_id])->one();
                    if($cart->amount > $goods->stock){
                        throw new Exception( $goods->stock,'库存不足,不能下单');
                    }
    //保存订单详情

                    $ordergoods=new OrderGoods();
                    $ordergoods->order_id=$order->id;
                    $ordergoods->goods_id=$goods->id;
                    $ordergoods->goods_name=$goods->name;
                    $ordergoods->price=$goods->shop_price;
                    $ordergoods->logo=$goods->logo;
                    $ordergoods->amount=$cart->amount;
                    $goods->stock -= $cart->amount;
                    $goods->save();
                    $ordergoods->total=($goods->shop_price)*($cart->amount);
                    $ordergoods->save(false);
                    $cart->delete();
                }
                $transaction->commit();
               $orders=OrderGoods::find()->all();
           return     $this->renderPartial('flow3',['orders'=>$orders]);
            }catch (Exception $e){
                $transaction->rollBack();
            }
        }else{
            var_dump($order->getErrors());
        }

    }

}