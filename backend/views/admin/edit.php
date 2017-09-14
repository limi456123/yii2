<?php

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'username')->textInput();
echo $form->field($admin,'password')->textInput();
echo $form->field($admin,'newpass')->textInput();
echo $form->field($admin,'vpass')->textInput();
echo $form->field($admin,'email')->textInput();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();