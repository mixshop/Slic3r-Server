<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-infill',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5 col-md-5 col-sm-5 \">{input}</div>\n<div class=\"col-lg-4 col-md-4 col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

<fieldset>
<legend><?= Yii::t('slic3r', 'Infill') ?></legend>
<?= $form->field($Slic3rConfig, 'fill_density', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">%</span></div>',
		 //'inputOptions'=>['value'=>$Slic3rConfig->fill_density*100],
	 	]
	) ?>
    
<?= $form->field($Slic3rConfig, 'fill_pattern')->dropDownList(['rectilinear'=>'Rectilinear', 'line'=>'Line', 'concentric'=>'Concentric', 'honeycomb'=>'Honeycomb']) ?>
<?= $form->field($Slic3rConfig, 'solid_fill_pattern')->dropDownList(['rectilinear'=>'Rectilinear', 'concentric'=>'Concentric']) ?>
</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Reducing Printing Time') ?></legend>
<?= $form->field($Slic3rConfig, 'infill_every_layers', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layers</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'1']); ?>
    
<?= $form->field($Slic3rConfig, 'infill_only_where_needed', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox() ?>
</fieldset>

<fieldset>
<legend><?= Yii::t('slic3r', 'Advanced') ?></legend>
<?= $form->field($Slic3rConfig, 'solid_infill_every_layers', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">Layers</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
<?= $form->field($Slic3rConfig, 'fill_angle', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">&deg;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0', 'max'=>'360']); ?>

<?= $form->field($Slic3rConfig, 'solid_infill_below_area', 
		[
		 'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">mm&sup2;</span></div>',
	 	]
	)->input('number', ['step'=>'1', 'min'=>'0']); ?>
    
    
<?= $form->field($Slic3rConfig, 'only_retract_when_crossing_perimeters', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox() ?>
<?= $form->field($Slic3rConfig, 'infill_first', ['options'=>['class'=>'col-lg-offset-3 col-md-offset-3 col-sm-offset-3']])->checkbox() ?>


</fieldset>

<hr/>
<div class="form-group">
    <div class="col-lg-12">
        <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancel',['/config/print-setting', 'tab'=>'infill'] ,['class' => 'btn btn-default pull-right ']) ?>
    </div>
</div>
    
<?php ActiveForm::end() ?>