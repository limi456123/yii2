<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'oldpass')->passwordInput();
echo $form->field($model,'newpass')->passwordInput();
echo $form->field($model,'repass')->passwordInput();
echo \yii\bootstrap\Html::submitButton('确认',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();