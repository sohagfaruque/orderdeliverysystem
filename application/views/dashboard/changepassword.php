<script>
    function newDoc()
    {
        window.location.assign("<?php echo base_url('news'); ?>")
    }
</script>
<div id="content" class="span10">
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="#">Home</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Change Password</a>
            </li>
        </ul>
    </div>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-edit"></i> Change Password</i></h2>
            </div>
            <div class="box-content">
                <form class="form-horizontal" action="<?php echo base_url('home/changepassword'); ?>" method="post">
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Current Password</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name ="cpass" id="username" type="password" value="<?php echo set_value('cpass') ?>">
                                <?php echo form_error('cpass', '<p class="error-mas">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">New Password</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name ="pass" id="fullName" type="text" value="">
                                <?php echo form_error('pass', '<p class="error-mas">', '</p>'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Re-Type Password</label>
                            <div class="controls">
                                <input class="input-xlarge focused" name ="passconf" id="country" type="text" value="">
                                <?php echo form_error('passconf', '<p class="error-mas">', '</p>'); ?>
                            </div>
                        </div>


                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <a class="btn" href="#" onclick="newDoc()">Cancel</a>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div><!--/span-->

    </div><!--/row-->



    <!-- content ends -->
</div><!--/#content.span10-->
<!--                        <script type="text/javascript">
$(function () {


$( "#datepicker" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );


});
</script>-->