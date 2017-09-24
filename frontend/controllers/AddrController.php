<?php
namespace frontend\controllers;
use frontend\models\Addr;
use frontend\models\Locations;
use yii\web\Controller;

class AddrController extends Controller{
    public function actionIndex(){
       $users=\Yii::$app->user->identity;
        $addrs=Addr::find()->where(['name'=>$users->username])->asArray()->all();
        foreach($addrs as &$addr){
         $addr['shen']=Locations::find()->where(['id'=>$addr['shen']])->one()->name;
         $addr['city']=Locations::find()->where(['id'=>$addr['city']])->one()->name;
         $addr['qu']=Locations::find()->where(['id'=>$addr['qu']])->one()->name;
        }

       return $this->render('address',['addrs'=>$addrs]);

    }
    public function actionGetshen(){
        $model=Locations::find()->where(['parent_id'=>0])->asArray()->all();
        echo json_encode($model);
    }
    public function actionGetcity($city){
        $model=Locations::find()->where(['parent_id'=>$city])->asArray()->all();
        echo json_encode($model);
    }
    public function actionGetqu($qu){
        $model=Locations::find()->where(['parent_id'=>$qu])->asArray()->all();
        echo json_encode($model);
    }
    public function actionAdd(){
            $request=\Yii::$app->request;
            $rst=$request->post();
            $model=new Addr();
        if($rst['add']){
            $model->load($request->post(),'');
            if($model->validate()){
                $model->name=\Yii::$app->user->identity->username;
                $model->save(false);
                return $this->redirect(['addr/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }else{
              $model->load($request->post());
               if($model->validate()){
                   $model->name=\Yii::$app->user->identity->username;
                   $model->updated_at=time();
                   $model->save(false);
                   return $this->redirect(['addr/index']);
               }
           }
    }
    public function actionDelete($id){
        $model=Addr::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['addr/index']);
    }
    public function actionGetall($id){
        $addr=Addr::find()->where(['id'=>$id])->asArray()->one();
        echo json_encode( $addr);
    }

}