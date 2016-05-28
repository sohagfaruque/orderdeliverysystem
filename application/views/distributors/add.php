<!--multiselect-->
<!--<script type="text/javascript" src="<?php echo base_url('assets/customjs') ?>/jquery.multi-select.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/customjs') ?>/multi-select.css">-->
<div class="right_countainer">
    <div class="title">Add Distributor</div>
    <div class="impbutton">
        <a href="<?php echo base_url('distributors') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('distributors/add'); ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Contact Number<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="contact_number" value="<?php echo set_value('contact_number') ?>">
                    <?php echo form_error('contact_number', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Address<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="distributor_address" value="<?php echo set_value('distributor_address') ?>">
                    <?php echo form_error('distributor_address', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Password</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="password" value="<?php echo set_value('password') ?>">
                    <?php echo form_error('password', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Email</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="email" value="<?php echo set_value('email') ?>">
                    <?php echo form_error('email', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Cities<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="city_id" onchange="getAvailabeAreas(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($cityValue as $cityVal) { ?>
                            <option value="<?php echo $cityVal->id; ?>"><?php echo $cityVal->city_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('product_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Area<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select name="area[]" multiple class="form-control" id="my-select">
                    </select>
                    <?php echo form_error('area', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont"></div>
                <div class="tab col-lg-6">
                    <button class="btn-primary btn" id="submit">Add</button>
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
                    $("#my-select").find('option').empty();
                    $("#my-select").html(result);
                }
            });
        } else {
            $("#my-select").find('option').empty();
        }
    }
</script>
<?php if (isset($successMsg)) { ?>
    <script>
        jSuccess('<?php echo $successMsg; ?>');
        window.location.replace("<?php echo base_url('distributors'); ?>");

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>