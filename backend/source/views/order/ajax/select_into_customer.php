<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ManXanh
 * Date: 4/12/14
 * Time: 9:19 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<span href="javascript:;" class="btn btn-success customer-button">
    <input type="hidden" name="OrderForm[orderAccount]" value="<?php echo $model->id?>">
    <?php echo $model->full_name?> - Phone: <?php echo $model->phone?> - <?php echo $model->email?> | <a onclick="removeCustomer('<?php echo $model->id?>')" href="javascript:;">X</a></span>
