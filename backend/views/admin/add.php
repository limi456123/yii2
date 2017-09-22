<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'username')->textInput();
echo $form->field($admin,'password')->passwordInput();
echo $form->field($admin,'email')->textInput(['type'=>'email']);
echo $form->field($admin,'roles')->checkboxList(\backend\models\Admin::getRoles());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();