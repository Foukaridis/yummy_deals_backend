<?php
/**
 *
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <section class="panel">
                    <header class="panel-heading text-center"
                            style="font-weight: bold; font-size: 20px"><?php echo Yii::t('login', 'label.forgotpass'); ?></header>
                    <form action="<?php echo Yii::app()->createUrl('site/forgot'); ?>" class="panel-body">
                        <p><?php echo Yii::t('login', 'label.reminder_enter_pass'); ?></p>

                        <div class="form-group"><label
                                class="control-label"><?php echo Yii::t('login', 'label.email'); ?></label>
                            <input id="p-email" type="email" placeholder="test@example.com" class="form-control">
                        </div>
                        <div id="form-over" style="color: #F00; margin-bottom: 10px;"></div>
                        <a href="<?php echo Yii::app()->createUrl('site/login'); ?>"
                           class="btn btn-info"><?php echo Yii::t('common', 'btn.back'); ?></a>
                        <button type="button" onclick="resetPassword();"
                                class="btn btn-info"><?php echo Yii::t('common', 'btn.submit'); ?></button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
<div id="congden"></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    function loading() {
        try {
            $("#congden").fakeLoader({
                timeToHide: 3000,
                bgColor: "#1abc9c",
                spinner: "spinner6"
            });
        } catch (ex) {
            alert(ex);
        }
    }
    function resetPassword() {
        if ($("#p-email").val() != '') {
            loading();
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("site/resetPassword"); ?>',
                type: 'POST',
                data: {"email": $("#p-email").val()},
                success: function (data) {
                    var json = $.parseJSON(data);
                    if (json.status == 'SUCCESS') {
                        $("#form-over").html(json.message);
                    } else {
                        $("#form-over").html(json.message);
                    }
                },
                error: function (data) {
                    $("#form-over").html($("#p-email").val());
                }
            });
        }
    }
</script>