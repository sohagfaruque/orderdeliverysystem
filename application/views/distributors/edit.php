<?php foreach($dataValue as $data){
    
}?>
<!--multiselect-->
<div class="right_countainer">
    <div class="title">Edit Distributor</div>
    <div class="impbutton">
        <a href="<?php echo base_url('distributors') ?>" title="Cancel" class="btn btn-danger btn-sm"><i class="icon-search icon-white"></i>Cancel</a>
    </div>
    <div class="center_box">
        <form method="post" action="<?php echo base_url('distributors/edit').'/'.$data->id;?>"name="register_form" id="register_form" enctype="multipart/form-data">
            <div class="edit_box">
                <div class="cont">Name<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $data->name?>">
                    <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Contact Number<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="contact_number" value="<?php echo $data->contact_number?>">
                    <?php echo form_error('contact_number', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Address<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="distributor_address" value="<?php echo $data->distributor_address?>">
                    <?php echo form_error('distributor_address', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Password</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" placeholder="Keep Blank if you don't want to change" name="password" value="">
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Email</div>
                <div class="tab col-lg-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $data->email?>">
                    <?php echo form_error('email', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Status<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="status">
                        <option value="">Please Select</option>
                        <option value="1"<?php echo $data->status==1?'selected':'';?>>Active</option>
                        <option value="0"<?php echo $data->status==0?'selected':'';?>>In active</option>
                        
                        <?php echo form_error('status', '<p class="alert alert-danger">', '</p>'); ?>
                    </select>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Cities<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select class="form-control" name="city_id" onchange="getAvailabeAreas(this.value);">
                        <option value="">Please Select</option>
                        <?php foreach ($cityValue as $cityVal) { ?>
                            <option value="<?php echo $cityVal->id; ?>"<?php echo $cityVal->id == $data->city_id?'selected':'';?>><?php echo $cityVal->city_name_english; ?></option>
                        <?php } ?>
                    </select>
                    <?php echo form_error('city_id', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>
            <div class="edit_box">
                <div class="cont">Area<font color="red">*</font></div>
                <div class="tab col-lg-6">
                    <select name="area[]" multiple class="form-control" id="my-select">
                    <?php foreach($areaValue as $areVal){
                        $i=0;
                        if(in_array($areVal->id, json_decode($data->area))){
                           $i=1; 
                        }?>
                        <option value="<?php echo $areVal->id?>"<?php echo $i==1?'selected':'';?>><?php echo $areVal->area_name_english;?></option>
                   <?php }?>
                    </select>
                    <?php echo form_error('area', '<p class="alert alert-danger">', '</p>'); ?>
                </div>
            </div>

            <div class="edit_box">
                <div class="cont"></div>
                <div class="tab col-lg-6">
                    <button class="btn-primary btn" id="submit">Update</button>
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