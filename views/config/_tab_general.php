<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-general',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

	<fieldset>
    <legend><?= Yii::t('slic3r', 'Size And Coordinates') ?></legend>
    <?= $form->field($Slic3rConfig, 'bed_size_x', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0'])  ?>
    
    <?= $form->field($Slic3rConfig, 'bed_size_y',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0'])  ?>
   
    <?= $form->field($Slic3rConfig, 'print_center_x',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0'])  ?>
<?= $form->field($Slic3rConfig, 'print_center_y',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0'])  ?>
    
    <?= $form->field($Slic3rConfig, 'z_offset',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.01'])  ?>
    
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Firmware') ?></legend>
    
	
    <?= $form->field($Slic3rConfig, 'gcode_flavor')->dropDownList(['reprap'=>'RepRap (Marlin/Sprinter/Repetier)', 'teacup'=>'Teacup', 'makerware'=>'MakerWare', 'sailfish'=>'Sailfish', 'mach3'=>'Mach3/LinuxCNC', 'no-extrusion'=>'No Extrusion']) ?>
    
    <?= $form->field($Slic3rConfig, 'use_relative_e_distances', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?> 
    
	</fieldset>
    
    
        <fieldset>
    <legend><?= Yii::t('slic3r', 'Advanced') ?></legend>
    

    
    <?= $form->field($Slic3rConfig, 'vibration_limit',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Hz</span></div>',
	 	]
	)->input('number', ['step'=>'1'])  ?>
    
        <?= $form->field($Slic3rConfig, 'use_firmware_retraction', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?> 
    
    
	</fieldset>
    
   <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/printer-setting', 'tab'=>'general'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>