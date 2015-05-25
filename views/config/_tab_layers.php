<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-layer',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>
	<fieldset>
    <legend><?= Yii::t('slic3r', 'Layer Height') ?></legend>
    <?= $form->field($Slic3rConfig, 'layer_height', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.01', 'min'=>'0']) ?>
    <?= $form->field($Slic3rConfig, 'first_layer_height',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.01', 'min'=>'0']) ?>
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Vertical Shells') ?></legend>
    <?= $form->field($Slic3rConfig, 'perimeters')->input('number') ?>
    <?= $form->field($Slic3rConfig, 'spiral_vase', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox() ?>
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Horizontal Shells') ?></legend>
    <?= $form->field($Slic3rConfig, 'top_solid_layers')->input('number') ?>
    <?= $form->field($Slic3rConfig, 'bottom_solid_layers')->input('number'); ?>
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Quality (Slower Slicing)') ?></legend>
    <?= $form->field($Slic3rConfig, 'extra_perimeters', ['options'=>['class'=>'col-md-12 col-sm-12']])->checkbox() ?>
    <?= $form->field($Slic3rConfig, 'avoid_crossing_perimeters', ['options'=>['class'=>'col-md-12 col-sm-12']])->checkbox() ?>
    <?= $form->field($Slic3rConfig, 'thin_walls', ['options'=>['class'=>'col-md-12 col-sm-12']])->checkbox() ?>
    <?= $form->field($Slic3rConfig, 'overhangs', ['options'=>['class'=>'col-md-12 col-sm-12']])->checkbox() ?>
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Advanced') ?></legend>
    <?= $form->field($Slic3rConfig, 'seam_position')->dropDownList(['aligned'=>'Aligned', 'random'=>'Random', 'nenarest'=>'Nearest']) ?>
    <?= $form->field($Slic3rConfig, 'external_perimeters_first', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox() ?>
	</fieldset>
    
    <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/print-setting', 'tab'=>'layers'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>