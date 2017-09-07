<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 16:44
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($articlecategory,'name')->textInput();
echo $form->field($articlecategory,'intro')->textarea();
echo $form->field($articlecategory,'sort')->textInput(['type'=>'number']);
echo $form->field($articlecategory,'status',['inline'=>true])->radioList(['隐藏','正常']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();