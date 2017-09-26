<?php
namespace backend\controllers;
use yii\web\Controller;

class SysController extends Controller{
    public function actionIndex(){
        $data=$this->renderPartial('@frontend/views/index/index.php');
        file_put_contents(\Yii::getAlias('@frontend/web/index.html'),$data);
        echo '生成首页成功';
    }
}