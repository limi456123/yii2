<?php
namespace backend\filters;
use Symfony\Component\CssSelector\Exception\ExpressionErrorException;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class RbacFiler extends ActionFilter{
    public function beforeAction($action){

       if( !\Yii::$app->user->can($action->uniqueId)){
           if(\Yii::$app->user->isGuest){
               return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
           }
           throw new ForbiddenHttpException('对不起,您没有该操作权限');
       };
        return parent::beforeAction($action);
    }
}