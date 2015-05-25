<?php
/* @var $this yii\web\View */
$this->title = 'Onbook Slicer Application';
?>
<div class="site-index">

<?php
$cookies = Yii::$app->request->cookies;

// get the "language" cookie value. If the cookie does not exist, return "en" as the default value.
echo  $cookies['config_cache'];
echo '<br/>';

$session = Yii::$app->session;
//$session->open();
echo $session->id;
?>



    <div class="jumbotron">
      <p>GCode Generator - Slic3r Online<br/><br/></p>
        <p><a class="btn btn-success" href="#">Slice Your STL File</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>About Us</h2>

                <p>Onbook Slicer is powered by Slic3r - Slic3r is the tool you need to convert a digital 3D model into printing instructions for your 3D printer. It cuts the model into horizontal slices (layers), generates toolpaths to fill them and calculates the amount of material to be extruded.</p>

                
            </div>
            
            
        </div>

    </div>
</div>
