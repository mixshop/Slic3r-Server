<?php
$this->title = 'Slicer Configration - Printer Setting';

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

echo $this->render('head_menu');

$request = Yii::$app->request;
$tab = $request->get('tab'); 
//print_r($tab);

$hidden = 'style = "display:none"';
$show = 'style = "dispay: block"';

$general = '';
$general_show = $hidden;
$custom_gcode = '';
$custom_gcode_show = $hidden;
$extruder = '';
$extruder_show = $hidden;

if($tab == 'general' or empty($tab)) {
	$general = 'active';
	$general_show = $show;
} else if($tab == 'custom_gcode') {
	$custom_gcode = 'active';
	$custom_gcode_show = $show;
} else if($tab == 'extruder') {
	$extruder = 'active';
	$extruder_show = $show;
}
?>

<div class="list-group col-md-3 col-sm-4">

  <a href="<?php echo Url::to(['config/printer-setting?tab=general']); ?>" class="list-group-item <?php echo $general; ?>">
    <?php echo \Yii::t('app', 'General'); ?>
  </a> 
  
  <a href="<?php echo Url::to(['config/printer-setting?tab=extruder']); ?>" class="list-group-item <?php echo $extruder; ?>"> <?php echo \Yii::t('app', 'Extruder'); ?></a>
  
  <a href="<?php echo Url::to(['config/printer-setting?tab=custom_gcode']); ?>" class="list-group-item <?php echo $custom_gcode; ?>"> <?php echo \Yii::t('app', 'Custom G-Code'); ?></a>
 

</div>


<div class="col-md-9 col-sm-8">




<!-- Tab-->
<div class="" <?php echo $general_show; ?>>
<?php  echo $this->render('_tab_general', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>

<!-- Tab-->
<div class="" <?php echo $extruder_show; ?>>
<?php  echo $this->render('_tab_extruder', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>

<!-- Ta-->
<div class="" <?php echo $custom_gcode_show; ?>>
<?php  echo $this->render('_tab_custom_gcode', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>


</div>
<!--end of "col-md-9 col-sm-8"-->