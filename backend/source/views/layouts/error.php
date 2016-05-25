<?php
/**
 * Created by Lorge 
 *
 * User: Only Love.
 * Date: 12/15/13 - 9:15 AM
 */
/* @var Controller $this */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->renderPartial("/layouts/public/header"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/error.css"/>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <?php echo $content; ?>
        </div>
    </div>

    <!--div id="footer" class="row">
        <div class="container">
            &copy;  2015 Projectemplate - All rights reserved<br/>
            Powered by <a href="http://projectemplate.com">Projectemplate</a> (Web & App Development).
        </div>
    </div-->
</div>
<?php $this->renderPartial("/layouts/public/footer"); ?>
</body>
</html>