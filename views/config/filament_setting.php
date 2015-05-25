<?php
$this->title = 'Slicer Configration - Filament Setting';

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

$filament = '';
$filament_show = $hidden;
$cooling = '';
$cooling_show = $hidden;

if($tab == 'filament' or empty($tab)) {
	$filament = 'active';
	$filament_show = $show;
} else if($tab == 'cooling') {
	$cooling = 'active';
	$cooling_show = $show;
}
?>

<div class="list-group col-md-3 col-sm-4">

  <a href="<?php echo Url::to(['config/filament-setting?tab=filament']); ?>" class="list-group-item <?php echo $filament; ?>">
    <?php echo \Yii::t('app', 'Filament'); ?>
  </a>
  <a href="<?php echo Url::to(['config/filament-setting?tab=cooling']); ?>" class="list-group-item <?php echo $cooling; ?>"> <?php echo \Yii::t('app', 'Cooling'); ?></a>

</div>


<div class="col-md-9 col-sm-8">




<!-- Tab Layers-->
<div class="" <?php echo $filament_show; ?>>
<?php  echo $this->render('_tab_filament', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>
<!-- Tab Infill-->
<div class="" <?php echo $cooling_show; ?>>
<?php  echo $this->render('_tab_cooling', ['Slic3rConfig'=>$Slic3rConfig]); ?>
</div>

</div>
<!--end of "col-md-9 col-sm-8"-->