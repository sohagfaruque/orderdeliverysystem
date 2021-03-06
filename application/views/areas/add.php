<div class="right_countainer">
    <div class="title">Add Area</div>
    <div class="impbutton">
        <a href="<?php echo base_url('dashboard') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('areas/add'); ?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Area English Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="area_name_english" value="<?php echo set_value('area_name_english') ?>">
                    <?php echo form_error('area_name_english', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Area Arabic Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="area_name_arabic" value="<?php echo set_value('area_name_arabic') ?>">
                    <?php echo form_error('area_name_arabic', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">City<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="city_id">
                        <option value="">Please Select</option>
                        <?php foreach ($cityValue as $cityVal) { ?>
                            <option value="<?php echo $cityVal->id; ?>"><?php echo $cityVal->city_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('city_id', '<p class="alert alert-danger">', '</p>'); ?>
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
<?php if (isset($successMsg)) { ?>
    <script>
        jSuccess('<?php echo $successMsg; ?>');
        window.location.replace("<?php echo base_url('areas'); ?>");

    </script>
<?php } ?>
<?php if (isset($errorMsg)) { ?>
    <script>
        jError('<?php echo $errorMsg; ?>');

    </script>
<?php } ?>