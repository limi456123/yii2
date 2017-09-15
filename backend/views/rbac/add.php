<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($auth,'name')->textInput();
echo $form->field($auth,'describe')->textInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();