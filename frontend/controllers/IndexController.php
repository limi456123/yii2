<?php
namespace frontend\controllers;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use frontend\models\Cart;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Cookie;

class IndexController extends Controller{

    public function actionIndex(){
       $model=GoodsCategory::find()->all();

        return $this->render('index',['model'=>$model]);
    }

    public function actionList($id){


        $good=GoodsCategory::find()->where(['id'=>$id])->one();
        $rst=GoodsCategory::find()->where(['tree'=>$good->tree])->andWhere(['>=','lft',$good->lft])->andWhere(['<=','rgt',$good->rgt])->andWhere(['depth'=>2])->asArray()->all();

        foreach($rst as $v){
            $childen=Goods::find()->where(['goods_category_id'=>$v['id']])->asArray()->all();
        }

     return   $this->render('list',['childen'=>$childen]);
    }
    public function actionGoods($id){
        $good=Goods::find()->where(['id'=>$id])->one();
        $photo=GoodsGallery::find()->where(['goods_id'=>$id])->all();

        return $this->renderPartial('goods',['goods'=>$good,'photo'=>$photo]);
    }

    public function actionShop(){

        $goods_id=\Yii::$app->request->get('goods_id');
        $amount=\Yii::$app->request->get('amount');
//        var_dump($amount, $goods_id);exit;
        if(\Yii::$app->user->isGuest){
          $cooke=\Yii::$app->request->cookies;
         $value=$cooke->getValue('carts');
            if($value){
                $carts=unserialize($value);
            }else{
                $carts=[];
            }

            if(array_key_exists($goods_id,$carts)){
                  $carts[$goods_id] += $amount;
            }else{
                $carts[$goods_id]=$amount;
            }

            $cookeis=\Yii::$app->response->cookies;
            $cooke=new Cookie();
            $cooke->name='carts';
            $cooke->value=serialize($carts);
            $cooke->expire=time()+7*24*3600;
            $cookeis->add($cooke);
        }else{
 //登录用户
            $user=\Yii::$app->user->identity;
            $cart=new Cart();
            $cart->goods_id= $goods_id;
            $cart->amount=$amount;
            $cart->member_id=$user->id;
            $cart->save(false);

        }

        return $this->redirect(['index/cart']);
    }
    public function actionCart(){
        if(\Yii::$app->user->isGuest){
           $cookie=\Yii::$app->request->cookies;
            $value=$cookie->getValue('carts');
            if($value){
                $carts=unserialize($value);
            }else{
                $carts=[];
            }
            $goods=Goods::find()->where(['in','id',array_keys($carts)])->all();
        }else{
//登录用户
            $member=\Yii::$app->user->identity->id;
       //同步cookie到数据库
            $cooke=\Yii::$app->request->cookies;
            $value=$cooke->getValue('carts');
            if($value){
                $carts=unserialize($value);
                foreach($carts as $k=>$v){
                    $cart=Cart::find()->where(['goods_id'=>$k])->andWhere(['member_id'=>$member])->one();

                if($cart){
                    $cart->amount=$cart->amount+$v;
                    $cart->save(false);

                }else{
                $cart=new Cart();
                $cart->goods_id=$k;
                $cart->amount=$v;
                $cart->member_id=$member;
                $cart->save(false);

                }
               }
                $cookie=\Yii::$app->request->cookies;
                $cooke=$cookie->get('carts');
                $cookies=\Yii::$app->response->cookies;
                $cookies->remove($cooke);
            }

            $cartes=Cart::find()->where(['member_id'=> $member])->asArray()->all();
           $goodbox=[];
            $carts=[];
           foreach($cartes as $cart){
               $goodbox[]=$cart['goods_id'];
               $carts[$cart['goods_id']]=$cart['amount'];
           }
            $goods=Goods::find()->where(['in','id',array_values($goodbox)])->all();
        }

        return $this->renderPartial('flow1',['goods'=>$goods,'carts'=>$carts]);
    }


    public function actionAjax(){
       $goods_id= \Yii::$app->request->post('goods_id');
       $amount= \Yii::$app->request->post('amount');

        if(\Yii::$app->user->isGuest){
            $cooke=\Yii::$app->request->cookies;
            $value=$cooke->getValue('carts');

                $carts=unserialize($value);
   if($amount==0){
          unset($carts[$goods_id]);
   }else{
           $carts[$goods_id]=$amount;
   }
            $cookeis=\Yii::$app->response->cookies;
            $cooke=new Cookie();
            $cooke->name='carts';
            $cooke->value=serialize($carts);
            $cooke->expire=time()+7*24*3600;
            $cookeis->add($cooke);

        }else{
 //登录用户
            $member_id=\Yii::$app->user->identity->id;

        $cart=Cart::find()->where(['goods_id'=>$goods_id])->andWhere(['member_id'=>$member_id])->one();

            if($amount==0){
                $cart->delete();
            }else{
                $cart->amount=$amount;
                $cart->save(false);
            }
        }
    }
}