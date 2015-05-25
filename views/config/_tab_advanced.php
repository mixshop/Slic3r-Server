<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-advanced',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

<div class="alert alert-info" role="alert">
<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<?= Yii::t('slic3r', 'Leave <strong>[ 0 ]</strong> For Default or Auto Calculation') ?>
</div>

	<fieldset>
    <legend><?= Yii::t('slic3r', 'Extrusion Width') ?></legend>
    <?= $form->field($Slic3rConfig, 'extrusion_width', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	)?>
    <?= $form->field($Slic3rConfig, 'first_layer_extrusion_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
   
    <?= $form->field($Slic3rConfig, 'perimeter_extrusion_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
<?= $form->field($Slic3rConfig, 'infill_extrusion_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    
    <?= $form->field($Slic3rConfig, 'solid_infill_extrusion_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    
	<?= $form->field($Slic3rConfig, 'top_infill_extrusion_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>
    <?= $form->field($Slic3rConfig, 'support_material_extrusion_width',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm/s or %</span></div>',
	 	]
	) ?>

    
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Flow') ?></legend>
    <?= $form->field($Slic3rConfig, 'bridge_flow_ratio')->input('number', ['step'=>'1', 'min'=>'0']) ?>
	</fieldset>
    
    <fieldset>
    <legend><?= Yii::t('slic3r', 'Other') ?></legend>
    <?= $form->field($Slic3rConfig, 'threads',
		[
		 //'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"></span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0', 'max'=>'10']) ?>
    
    
   <?= $form->field($Slic3rConfig, 'resolution',
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm</span></div>',
	 	]
	) ?>
    
	</fieldset>
   
    
    <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/print-setting', 'tab'=>'advanced'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>