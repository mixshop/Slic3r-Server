<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-support',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

<fieldset>
<legend><?= Yii::t('slic3r', 'Support Material') ?></legend>
<?= $form->field($Slic3rConfig, 'support_material', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?>

<hr/>

<?= $form->field($Slic3rConfig, 'support_material_threshold', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?> 
    
<?= $form->field($Slic3rConfig, 'support_material_enforce_layers', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layers</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>    
    
</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Raft') ?></legend>
<?= $form->field($Slic3rConfig, 'raft_layers', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layers</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>

</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Options For Support Material and Raft') ?></legend>

<?= $form->field($Slic3rConfig, 'support_material_pattern')->dropDownList(['rectilinear'=>'Rectilinear', 'rectilinear grid'=>'Rectilinear Grid', 'honeycomb'=>'Honeycomb', 'pillars'=>'Pillars']) ?>

<?= $form->field($Slic3rConfig, 'support_material_spacing', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'support_material_angle', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0', 'max'=>'360']); ?>

<?= $form->field($Slic3rConfig, 'support_material_interface_layers', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layer</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
    <?= $form->field($Slic3rConfig, 'support_material_interface_spacing', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layer</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
    
<?= $form->field($Slic3rConfig, 'dont_support_bridges', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox() ?>



</fieldset>

<hr/>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancel',['/config/print-setting', 'tab'=>'support'] ,['class' => 'btn btn-default pull-right ']) ?>
    </div>
</div>
    
<?php ActiveForm::end() ?>