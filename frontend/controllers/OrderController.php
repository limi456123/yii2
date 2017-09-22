<?php
namespace frontend\controllers;
use backend\models\Goods;
use frontend\models\Addr;
use frontend\models\Cart;
use frontend\models\Locations;
use frontend\models\Order;
use yii\web\Controller;

class OrderController extends Controller{
    public function actionAdd(){
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
       return $this->renderPartial('flow2',['addrs'=>$addrs,'goodsbox'=>$goodsbox,'cartbox'=> $cartbox,'delivery'=>$delivery]);
    }
}