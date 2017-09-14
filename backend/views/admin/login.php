<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($login,'name')->textInput();
echo $form->field($login,'password')->textInput();

echo $form->field($login,'code')->widget(yii\captcha\Captcha::className(),[
    'captchaAction'=>'admin/captcha',
    'template'=>'<div class="row">
                    <div class="col-lg-1">{image}</div>
                    <div class="col-lg-2">{input}</div>
                   </div>'
]);
echo $form->field($login,'num')->checkbox();
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();