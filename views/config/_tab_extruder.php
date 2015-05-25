<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-extruder',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

	<fieldset>
    <legend><?= Yii::t('slic3r', 'Size') ?></legend>
    <?= $form->field($Slic3rConfig, 'nozzle_diameter', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.01', 'min'=>'0'])  ?>
    
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Retraction') ?></legend>
    
	<?= $form->field($Slic3rConfig, 'retract_length', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.1', 'min'=>'0'])  ?>
    
    <?= $form->field($Slic3rConfig, 'retract_lift', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.01', 'min'=>'0'])  ?>
    
    <?= $form->field($Slic3rConfig, 'retract_speed', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0'])  ?>
    
        <?= $form->field($Slic3rConfig, 'retract_restart_extra', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.1', 'min'=>'0'])  ?>
    
    <?= $form->field($Slic3rConfig, 'retract_before_travel', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	)->input('number', ['step'=>'0.1', 'min'=>'0'])  ?>
   
    
    <?= $form->field($Slic3rConfig, 'retract_layer_change', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?> 
 
     <?= $form->field($Slic3rConfig, 'wipe', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?> 
        
	</fieldset>
    
 
    
   <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/printer-setting', 'tab'=>'general'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>