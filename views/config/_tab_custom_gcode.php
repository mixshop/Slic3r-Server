<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'slic3r-config-form-custom-gcode',
    'options' => ['class' => 'form-horizontal'],
	'fieldConfig' => [
            'template' => "<div class=\"col-lg-12 col-md-12 col-sm-12 \">{input}</div>\n<div class=\"col-lg-12 col-md-12 col-sm-12\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-3 col-md-3 col-sm-4 control-label'],
     ],
		
]) ?>

	<fieldset>
    <legend><?= Yii::t('slic3r', 'Start G-Code') ?></legend>
   <div class="form-group <?php echo 'field-'.Html::getInputId($Slic3rConfig, 'start_gcode') ?>">
   <div class="col-lg-12 col-md-12 col-sm-12 ">
   <textarea rows="6" id="<?php echo Html::getInputId($Slic3rConfig, 'start_gcode') ?>" name="<?php echo Html::getInputName($Slic3rConfig, 'start_gcode'); ?>" class="form-control"><?= Html::decode(Html::getAttributeValue($Slic3rConfig, 'start_gcode')); ?></textarea>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12"><p class="help-block help-block-error"></p></div>
</div>
 	<div style="display:none;">   <?= $form->field($Slic3rConfig, 'start_gcode')->textarea(['name'=>'hidden-start_gcode']) ?></div>
	</fieldset>
    
	<fieldset>
    <legend><?= Yii::t('slic3r', 'End G-Code') ?></legend>
   <div class="form-group <?php echo 'field-'.Html::getInputId($Slic3rConfig, 'end_gcode') ?>">
   <div class="col-lg-12 col-md-12 col-sm-12 ">
   <textarea rows="6" id="<?php echo Html::getInputId($Slic3rConfig, 'end_gcode') ?>" name="<?php echo Html::getInputName($Slic3rConfig, 'end_gcode'); ?>" class="form-control"><?= Html::decode(Html::getAttributeValue($Slic3rConfig, 'end_gcode')); ?></textarea>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12"><p class="help-block help-block-error"></p></div>
</div>
 	<div style="display:none;">   <?= $form->field($Slic3rConfig, 'end_gcode')->textarea(['name'=>'hidden-end_gcode']) ?></div>
	</fieldset>
 
 	<fieldset>
    <legend><?= Yii::t('slic3r', 'Layer Change G-Code') ?></legend>
   <div class="form-group <?php echo 'field-'.Html::getInputId($Slic3rConfig, 'layer_gcode') ?>">
   <div class="col-lg-12 col-md-12 col-sm-12 ">
   <textarea rows="3" id="<?php echo Html::getInputId($Slic3rConfig, 'layer_gcode') ?>" name="<?php echo Html::getInputName($Slic3rConfig, 'layer_gcode'); ?>" class="form-control"><?= Html::decode(Html::getAttributeValue($Slic3rConfig, 'layer_gcode')); ?></textarea>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12"><p class="help-block help-block-error"></p></div>
</div>
 	<div style="display:none;">   <?= $form->field($Slic3rConfig, 'layer_gcode')->textarea(['name'=>'hidden-layer_gcode']) ?></div>
	</fieldset>
    
    
 	<fieldset>
    <legend><?= Yii::t('slic3r', 'Tool Change G-Code') ?></legend>
   <div class="form-group <?php echo 'field-'.Html::getInputId($Slic3rConfig, 'toolchange_gcode') ?>">
   <div class="col-lg-12 col-md-12 col-sm-12 ">
   <textarea rows="3" id="<?php echo Html::getInputId($Slic3rConfig, 'toolchange_gcode') ?>" name="<?php echo Html::getInputName($Slic3rConfig, 'toolchange_gcode'); ?>" class="form-control"><?= Html::decode(Html::getAttributeValue($Slic3rConfig, 'toolchange_gcode')); ?></textarea>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12"><p class="help-block help-block-error"></p></div>
</div>

 	<div style="display:none;">   <?= $form->field($Slic3rConfig, 'layer_gcode')->textarea(['name'=>'hidden-toolchange_gcode']) ?></div>
    
	</fieldset>
    
   <hr/>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Save Configration', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel',['/config/printer-setting', 'tab'=>'custom_gcode'] ,['class' => 'btn btn-default pull-right ']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>