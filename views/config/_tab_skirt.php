<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-skirt',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>
	<fieldset>
    <legend><?= Yii::t('slic3r', 'Skirt') ?></legend>
    <?= $form->field($Slic3rConfig, 'skirts')->input('number', ['step'=>'1', 'min'=>'0']) ?>
    <?= $form->field($Slic3rConfig, 'skirt_distance',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']) ?>
    <?= $form->field($Slic3rConfig, 'skirt_height',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']) ?>
    <?= $form->field($Slic3rConfig, 'min_skirt_length',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']) ?>
	</fieldset>
    
   
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Brim') ?></legend>
    
    <?= $form->field($Slic3rConfig, 'brim_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']) ?>
    
	</fieldset>
  
   
    <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/print-setting', 'tab'=>'skirt'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>