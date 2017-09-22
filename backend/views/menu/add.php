<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($menu,'name')->textInput();
echo $form->field($menu,'parent_id')->dropDownList(\backend\models\Menu::getPamrent());
echo $form->field($menu,'route')->dropDownList(\backend\models\Menu::getParm());
echo $form->field($menu,'sort')->textInput();
echo $form->field($menu,'status')->radioList(['隐藏','显示']);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();