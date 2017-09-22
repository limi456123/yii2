<?php
namespace frontend\controllers;
use backend\models\Goods;
use frontend\models\Addr;
use frontend\models\Cart;
use frontend\models\Locations;
use frontend\models\Order;
use yii\web\Controller;

class OrderController extends Controller{
    public function actionIndex(){
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
//            $price=0;
//            foreach($goodsbox as $good){
//                $price+=($cartbox[$good->id]*$good->shop_price);
//            }
            
        }else{
            var_dump($order->getErrors());exit;
        }
    }
}