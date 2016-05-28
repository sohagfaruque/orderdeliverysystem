<link href="<?php echo base_url('assets/customjs/datetimepicker') ?>/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url('assets/customjs/datetimepicker') ?>/moment-with-locales.js"></script>
<script src="<?php echo base_url('assets/customjs/datetimepicker') ?>/bootstrap-datetimepicker.js"></script>
<style>
    .bootstrap-datetimepicker-widget{
        z-index: 100;
        border: 1px solid;
        height: 300px;
    }
</style>
<div class="right_countainer">
    <div class="title">Add Order</div>
    <div class="impbutton">
        <a href="<?php echo base_url('orders') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('orders/add'); ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Cities<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="city_id" onchange="getAvailabeAreas(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($cityValue as $cityVal) { ?>
                            <option value="<?php echo $cityVal->id; ?>"><?php echo $cityVal->city_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('city_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Area<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" id="select_area" name="area" onchange="getUserByArea(this.value);">
                        <option value="">Please select</option>
                    </select>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">User<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" id="select_user" name="user_id" onchange="getDistributor(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($userValue as $userVal) { ?>
                            <option value="<?php echo $userVal->id; ?>"><?php echo $userVal->name; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('user_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Distributor<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="distributor_id" id="dist_opt">
                        <option value="">Please Select</option>
                    </select>
                    <?php echo form_error('distributor_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Product<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="product_id" onchange="getAvailabeAmount(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($productValue as $productVal) { ?>
                            <option value="<?php echo $productVal->id; ?>"><?php echo $productVal->name; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('product_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Amount<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="product_amount" id="amount_opt">
                        <option value="">Please Select</option>
                    </select>
                    <?php echo form_error('product_amount', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Status<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="status">
                        <option value="">Please Select</option>
                        <option value="0">Available</option>
                        <option value="1">Confirmed</option>
                        <option value="2">Delivered</option>
                        <option value="3">Canceled</option>
                    </select>
                    <?php echo form_error('status', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Shipping Address<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" id="" name="shipping_address" value="">
                    <?php echo form_error('shipping_address', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Preferred date<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" id="datetimepicker2" name="preferred_date" value="<?php echo set_value('preferred_date') ?>">
                    <?php echo form_error('preferred_date', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Delivery date<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" id="datetimepicker1" name="delivery_date" value="<?php echo set_value('delivery_date') ?>">
                    <?php echo form_error('delivery_date', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont"></div>
                <div class="tab col-lg-6">
                    <button class="btn-primary btn" id="submit">Add</button>
                </div>
            </div>

    </div>


</form>
</div>
</div>
<script>
    function getAvailabeAreas(id)
    {
        var id = id;
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('distributors/getAreaByCityId') ?>",
                data: {postID: id},
                success: function (result) {
                    $("#select_area").find('option').empty();
                    $("#select_area").html(result);
                    $("#dist_opt").find('option').empty();
                    $("#select_user").find('option').empty();
                }
            });
        } else {
            $("#select_area").find('option').empty();
            $("#dist_opt").find('option').empty();
            $("#select_user").find('option').empty();
        }
    }
</script>
<script>
    function getUserByArea(id)
    {
        var id = id;
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('orders/getUsersByAreaId') ?>",
                data: {postID: id},
                success: function (result) {
                    $("#select_user").find('option').empty();
                    $("#select_user").html(result);
                }
            });
        } else {
            $("#select_user").find('option').empty();
            $("#dist_opt").find('option').empty();
        }
    }
</script>
<script>
    function getDistributor(id)
    {
        var id = id;
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('orders/getDistributorByUserId') ?>",
                data: {postID: id},
                success: function (result) {
                    $("#dist_opt").find('option').empty();
                    $("#dist_opt").html(result);
                }
            });
        } else {
            $("#dist_opt").find('option').empty();
            $("#dist_opt").html("<option value=''>Please Select</option>");
        }
    }
</script>
<script>
    function getAvailabeAmount(id)
    {
        var id = id;
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('orders/getAmountByProductId') ?>",
                data: {postID: id},
                success: function (result) {
                    $("#amount_opt").find('option').empty();
                    $("#amount_opt").html(result);
                }
            });
        } else {
            $("#amount_opt").find('option').empty();
            $("#amount_opt").html("<option value=''>Please Select</option>");
        }
    }
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({format: "YYYY/MM/DD h:ssa"});
        $('#datetimepicker2').datetimepicker({format: "YYYY/MM/DD h:ssa"});
    });
</script>
<?php if (isset($successMsg)) { ?>
    <script>
        jSuccess('<?php echo $successMsg; ?>');
        window.location.replace("<?php echo base_url('orders'); ?>");

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>