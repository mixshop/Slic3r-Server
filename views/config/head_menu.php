<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
$cookies = Yii::$app->response->cookies;
$config_file = $cookies['cache_config'];
NavBar::begin([
				'brandLabel' => Html::img(['../../images/slic3r.png']).' Configration',
				'brandUrl' => ['config/print-setting'] ,
				'options' => [
                    'class' => 'navbar navbar-inverse',
                ],
				'innerContainerOptions'=>['class'=>'container-fluid'],
			]);
echo Nav::widget([
    'items' => [
        [
            'label' => \Yii::t('app', 'Print Setting'),
            'url' => ['config/print-setting'],
        ],
		[
            'label' => \Yii::t('app', 'Filament Setting'),
            'url' => ['config/filament-setting'],
        ],
		[
            'label' => \Yii::t('app', 'Printer Setting'),
            'url' => ['config/printer-setting'],
        ],
    ],
	'options'=>['class'=>'navbar-nav nav'],
]);

$load_confirm = \Yii::t('app', 'Your current slic3r configration will be overwrite. Please Download your current configuration first if you want to keep it.');

echo Nav::widget([
	'items' => [
		[
            'label' => \Yii::t('app', 'Load Config'),
            'items' => [
				 
				 '<li class="dropdown-header" >
				 Mixshop
				 <span class="badge alert-success pull-right">3</span>
				 </li>',
				 //'<li class="divider"></li>',
                 [	'label' => 'Prusa i3', 
				 	'url' => ['config/load', 'config_name'=>'mixshop_prusa_i3.ini'],
					//'linkOptions' => ['data-confirm' =>$load_confirm],
				 ],
				 [
				 	'label' => 'Mix G1', 
					'url' => ['config/load', 'config_name'=>'mixshop_mix_g1.ini'],
					//'linkOptions' => ['data-confirm' =>$load_confirm],
				 ],
				 [
				 	'label' => 'Kossel', 
					'url' => ['config/load', 'config_name'=>'mixshop_kossel.ini'],
					//'linkOptions' => ['data-confirm' =>$load_confirm],	
				 ],
				 //'<li class="divider"></li>',
				 '<li class="dropdown-header">
				 Others
				 <span class="badge alert-info pull-right">1</span>
				 </li>',
				 
				 [
				 	'label' => 'Poieo 3D', 
				 	'url' => ['config/load', 'config_name'=>'poieo3d_mini.ini'],
					//'linkOptions' => ['data-confirm' =>$load_confirm],
				],
            ],
        ],
		
		[
            'label' => \Yii::t('app', 'Download'),
            'items' => [
                 ['label' => 'Current Configration', 'url' => ['config/download']],
            ],
        ],
    ],
	'options'=>['class'=>'navbar-nav nav navbar-right'],
]);


NavBar::end();
?>

<?php
$close = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';

foreach(Yii::$app->session->getAllFlashes() as $key => $message) {
	
	if($key == 'sucess')
		$class = 'alert-success';
	else if($key == 'info')
		$class = 'alert-info';
	else if($key == 'warning')
		$class = 'alert-warning';
	else if($key == 'danger')
		$class = 'alert-danger';
	else
		$class = 'error';

		
	if(is_array($message))
	{
		
		foreach($message as $m) {
			echo '<div class="alert '.$class.'">';
			echo $close;
			echo $m;
			echo '</div>';
		}
	}
	else
	{
		echo '<div class="alert '.$class.'">';
		echo $close;
		echo $message;
		echo '</div>';
	}

} ?>