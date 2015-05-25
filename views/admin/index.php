<?php
use yii\helpers\Html;
?>

<?php
$close = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
foreach(Yii::$app->session->getAllFlashes() as $message) {
	if(is_array($message))
	{
		foreach($message as $m)
			echo '<div class="alert alert-info">';
			echo $close;
			echo $m;
			echo '</div>';
	}
	else
	{
		echo '<div class="alert alert-info">';
		echo $close;
		echo $message;
		echo '</div>';
	}
} ?>

<p>
<h3>Are you sure you want to clear past 30 days sessions folders?</h3>
<p>
<?php echo Html::a('Delete Config Cache Folers',['delete-sessions'] ,['class'=>'btn btn-danger','data-method' => 'post','data-confirm' =>'Are You Sure?']); ?>
</p>
</p>

