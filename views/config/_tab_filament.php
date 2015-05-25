<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-filament',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

<fieldset>
<legend><?= Yii::t('slic3r', 'Filament') ?></legend>

<?= $form->field($Slic3rConfig, 'filament_diameter', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.01', 'min'=>'0']); ?> 
    
<?= $form->field($Slic3rConfig, 'extrusion_multiplier')->input('number', ['step'=>'0.01', 'min'=>'0.8', 'max'=>'2']); ?>    
    
</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Extruder Temperature (&deg;C)') ?></legend>

<?= $form->field($Slic3rConfig, 'first_layer_temperature', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'temperature', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>


</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Bed Temperature (&deg;C)') ?></legend>

    
<?= $form->field($Slic3rConfig, 'first_layer_bed_temperature', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'bed_temperature', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>

</fieldset>

<hr/>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancel',['/config/filament-setting', 'tab'=>'filament'] ,['class' => 'btn btn-default pull-right ']) ?>
    </div>
</div>
    
<?php ActiveForm::end() ?>