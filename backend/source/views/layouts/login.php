
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->renderPartial("/layouts/public/header"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/login.css"/>
</head>
<body>
<div class="container login-wrapper">
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
        <center><img class="size-full aligncenter" src="http://friilance.com/wp-content/uploads/2015/05/friiWEB_clients_yummy.png" alt="friiWEB_clients_yummy" width="250" height="191" /></center>
            <?php echo $content; ?>
        </div>
    </div>

    <div id="footer" class="row">
        <div class="container">

        </div>
    </div>
</div>
<?php $this->renderPartial("/layouts/public/footer"); ?>
</body>
</html>