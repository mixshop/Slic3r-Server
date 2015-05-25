<?php
$this->title = 'Onbook Slicer Configration';

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

$layers = '';
$layers_show = $hidden;
$infill = '';
$infill_show = $hidden;
$speed = '';
$speed_show = $hidden;
$skirt = '';
$skirt_show = $hidden;
$support = '';
$support_show = $hidden;
$advanced = '';
$advanced_show = $hidden;

if($tab == 'layers' or empty($tab)) {
	$layers = 'active';
	$layers_show = $show;
} else if($tab == 'infill') {
	$infill = 'active';
	$infill_show = $show;
} else if($tab == 'speed') {
	$speed = 'active';
	$speed_show = $show;
} else if($tab == 'skirt') {
	$skirt = 'active';
	$skirt_show = $show;
} else if($tab == 'support') {
	$support = 'active';
	$support_show = $show;
} else if($tab == 'advanced') {
	$advanced = 'active';
	$advanced_show = $show;
}
?>

<div class="list-group col-md-3 col-sm-4">

  <a href="<?php echo Url::to(['config/print-setting?tab=layers']); ?>" class="list-group-item <?php echo $layers; ?>">
    <?php echo \Yii::t('app', 'Layers and Permsters'); ?>
  </a>
  <a href="<?php echo Url::to(['config/print-setting?tab=infill']); ?>" class="list-group-item <?php echo $infill; ?>"> <?php echo \Yii::t('app', 'Infill'); ?></a>
  <a href="<?php echo Url::to(['config/print-setting?tab=speed']); ?>" class="list-group-item <?php echo $speed; ?>"> <?php echo \Yii::t('app', 'Speed'); ?></a>
  <a href="<?php echo Url::to(['config/print-setting?tab=skirt']); ?>" class="list-group-item <?php echo $skirt; ?>"> <?php echo \Yii::t('app', 'Skirt and Brim'); ?></a>
  <a href="<?php echo Url::to(['config/print-setting?tab=support']); ?>" class="list-group-item <?php echo $support; ?>"> <?php echo \Yii::t('app', 'Support Material'); ?></a>
  <a href="<?php echo Url::to(['config/print-setting?tab=advanced']); ?>" class="list-group-item <?php echo $advanced; ?>"><?php echo \Yii::t('app', 'Advanced'); ?></a>
</div>


<div class="col-md-9 col-sm-8">




<!-- Tab Layers-->
<div class="" <?php echo $layers_show; ?>>
<?php  echo $this->render('_tab_layers', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>
<!-- Tab Infill-->
<div class="" <?php echo $infill_show; ?>>
<?php echo $this->render('_tab_infill', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>
<!-- Tab Speed-->
<div class="" <?php echo $speed_show; ?>>
<?php echo $this->render('_tab_speed', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>
<!-- Tab Skirt-->
<div class="" <?php echo $skirt_show; ?>>
<?php echo $this->render('_tab_skirt', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>
<!-- Tab Support-->
<div class="" <?php echo $support_show; ?>>
<?php echo $this->render('_tab_support', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>
<!-- Tab Advanced-->
<div class="" <?php echo $advanced_show; ?>>
<?php echo $this->render('_tab_advanced', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>


</div>
<!--end of "col-md-9 col-sm-8"-->