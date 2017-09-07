<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/7
 * Time: 15:19
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,'name')->textInput();
echo $form->field($brand,'intro')->textarea();
echo $form->field($brand,'file')->fileInput();
echo $form->field($brand,'sort')->textInput(['type'=>'number']);
echo $form->field($brand,'status',['inline'=>true])->radioList(['隐藏','正常']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
