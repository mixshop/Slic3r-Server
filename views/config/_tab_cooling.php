<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-cooling',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>


<div class="alert alert-info" role="alert">
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<?= Yii::t('slic3r', '
If estimated layer time is below 30s, fan will run at 100% and print speed will be reduced so that no less than 30s are spent on that layer (however, speed wil never be reduced below 10mm/s).<br/>
If estimated layer time is greater, but still below 60s, fan will run at 1 proportionally decreasing speed between 35% and 100%. During the othere layers, fan will be turned off.

') ?>
</div> 


<fieldset>
<legend><?= Yii::t('slic3r', 'Enable') ?></legend>

<?= $form->field($Slic3rConfig, 'fan_always_on', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?> 
    
<?= $form->field($Slic3rConfig, 'cooling', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox(); ?>       
    
    
</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Fan Setting') ?></legend>
    
<?= $form->field($Slic3rConfig, 'min_fan_speed', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">%</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'max'=>'100', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'max_fan_speed', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">%</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'max'=>'100', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'bridge_fan_speed', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">%</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'max'=>'100', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'disable_fan_first_layers', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layers</span></div>',
	 	]
	)->input('number', ['step'=>'1']); ?>



</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Cooling Thresholds') ?></legend>

    
<?= $form->field($Slic3rConfig, 'fan_below_layer_time', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Second</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'slowdown_below_layer_time', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Second</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'min_print_speed', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>

</fieldset>

<hr/>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancel',['/config/filament-setting', 'tab'=>'cooling'] ,['class' => 'btn btn-default pull-right ']) ?>
    </div>
</div>
    
<?php ActiveForm::end() ?>