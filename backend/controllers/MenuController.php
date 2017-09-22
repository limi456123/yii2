<?php
namespace backend\controllers;
use backend\models\Menu;
use yii\web\Controller;
use backend\filters\RbacFiler;

class MenuController extends Controller{
    public function actionAdd(){
        $menu=new Menu();
        $menu->scenario=Menu::SCENARIO_ADD;
//       var_dump(Menu::find()->where(['parent_id'=>0])->all());exit;
        $request=\Yii::$app->request;
        if($request->isPost){
            $menu->load($request->post());
//            var_dump($menu);exit;
            if($menu->validate()){
                $menu->save();
                return $this->redirect(['menu/index']);
            }
        }
        return $this->render('add',['menu'=>$menu]);
    }
    public function actionIndex(){
        $menus=Menu::find()->where(['parent_id'=>0])->asArray()->all();
        $menusArr=[];
        foreach($menus as $menu){
            $menusArr[] = $menu;
            $children=Menu::find()->where(['parent_id'=>$menu['id']])->asArray()->all();
            if(!empty($children)){
                foreach ($children as $child) {
                    $child['name'] = '----'.$child['name'];
                    array_push($menusArr,$child);
                }
            }
        }
           $menus= $menusArr;
        return $this->render('index',['menus'=>$menus]);
    }

    public function actionDelete($id){
        $menu=Menu::findOne(['id'=>$id]);
        if($menu->parent_id){
        $menu->delete();
        return $this->redirect(['menu/index']);
        }else{
            \Yii::$app->session->setFlash('success','不能删除该项');
            return $this->redirect(['menu/index']);
        }
    }

    public function actionEdit($id){
        $menu=Menu::findOne(['id'=>$id]);
        $menu->scenario=Menu::SCENARIO_EDIT;
        $request=\Yii::$app->request;
        if($request->isPost){
            $menu->load($request->post());
            if($menu->validate()){
                $menu->save();
                return $this->redirect(['menu/index']);
            }
        }
        return $this->render('add',['menu'=>$menu]);
    }
    public function behaviors(){

        return [
            'rbac'=>[
                'class'=>RbacFiler::className(),
                'except'=>['login','logout','captcha','error']
            ]
        ];
    }
}