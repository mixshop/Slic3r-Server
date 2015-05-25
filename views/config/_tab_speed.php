<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-speed',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>
	<fieldset>
    <legend><?= Yii::t('slic3r', 'Speed For Print Moves') ?></legend>
    <?= $form->field($Slic3rConfig, 'perimeter_speed', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']) ?>
    <?= $form->field($Slic3rConfig, 'small_perimeter_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
   
    <?= $form->field($Slic3rConfig, 'external_perimeter_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    
    <?= $form->field($Slic3rConfig, 'infill_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']) ?>
    
	<?= $form->field($Slic3rConfig, 'solid_infill_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    <?= $form->field($Slic3rConfig, 'top_solid_infill_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    
    <?= $form->field($Slic3rConfig, 'support_material_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']) ?>
    
    <?= $form->field($Slic3rConfig, 'support_material_interface_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    
    <?= $form->field($Slic3rConfig, 'bridge_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']) ?>
    
    <?= $form->field($Slic3rConfig, 'gap_fill_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']) ?>
   
    
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Speed For Non-print Moves') ?></legend>
    <?= $form->field($Slic3rConfig, 'travel_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']) ?>
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Modifiers') ?></legend>
    <?= $form->field($Slic3rConfig, 'first_layer_speed',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
	</fieldset>
    
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Acceleration Control (Advanced)') ?></legend>
    <?= $form->field($Slic3rConfig, 'perimeter_acceleration',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s&sup2;</span></div>',
	 	]
	)->input('number') ?>
    <?= $form->field($Slic3rConfig, 'infill_acceleration',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s&sup2;</span></div>',
	 	]
	)->input('number') ?>
    <?= $form->field($Slic3rConfig, 'bridge_acceleration',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s&sup2;</span></div>',
	 	]
	)->input('number') ?>
    <?= $form->field($Slic3rConfig, 'first_layer_acceleration',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s&sup2;</span></div>',
	 	]
	)->input('number') ?>
    <?= $form->field($Slic3rConfig, 'default_acceleration',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s&sup2;</span></div>',
	 	]
	)->input('number') ?>
   
	</fieldset>
    

    
    <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/print-setting', 'tab'=>'speed'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>