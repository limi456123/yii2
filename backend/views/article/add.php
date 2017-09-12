<?php
use \kucha\ueditor\UEditor;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($article,'name')->textInput();
echo $form->field($article,'intro')->textarea();
echo $form->field($article,'article_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($articlecategory,'id','name'));
echo $form->field($article,'sort')->textInput(['type'=>'number']);
echo $form->field($article,'status',['inline'=>true])->radioList(['隐藏','正常']);
//echo $form->field( $articledetail,'content')->textarea();

echo $form->field($articledetail,'content')->widget('kucha\ueditor\UEditor',[]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
?>

