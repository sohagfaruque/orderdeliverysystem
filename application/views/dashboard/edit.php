<?php foreach($result as $data){ }?>
<div id="content" class="span10">
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Forms</a>
					</li>
				</ul>
			</div>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Edit Data of <i><?php echo $data->fullName;?></i></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                                            <form class="form-horizontal" action="<?php echo base_url().'userlist/edit_data/'.$data->id;?>" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">User Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="username" id="username" type="text" value="<?php echo $data->username;?>">
                                                                  <?php echo form_error('username', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Full Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="fullName" id="fullName" type="text" value="<?php echo $data->fullName;?>">
                                                                  <?php echo form_error('fullName', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
                                                             <div class="control-group">
								<label class="control-label" for="focusedInput">Country</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="country" id="country" type="text" value="<?php echo $data->country;?>">
                                                                  <?php echo form_error('country', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
                                                             <div class="control-group">
								<label class="control-label" for="focusedInput">Mobile</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="mobile" id="mobile" type="text" value="<?php echo $data->mobile;?>">
                                                                  <?php echo form_error('mobile', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
                                                            
                                                          <div class="control-group">
								<label class="control-label" for="focusedInput">Email</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="email" id="email" type="text" value="<?php echo $data->email;?>">
                                                                  <?php echo form_error('email', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
                                                             <div class="control-group">
								<label class="control-label" for="focusedInput">Activation Code</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="activecode" id="activecode" type="text" value="<?php echo $data->activecode;?>">
                                                                  <?php echo form_error('activecode', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
                                                            <div class="control-group">
								<label class="control-label" for="focusedInput">Expire Date</label>
								<div class="controls">
                                                                    <!--<input type="text" class="input-xlarge datepicker" id="date01" value="02/16/12">-->
                                                                    <input class="input-xlarge datepicker" name ="expire_date" id="datepicker" type="text" value="<?php echo  date_format(date_create($data->expire_date),"d-m-Y");?>">
                                                                  <?php echo form_error('expire_date', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
                                                            <div class="control-group">
								<label class="control-label" for="selectError3">Service</label>
								<div class="controls">
								  <select id="selectError3" name="service">
									<option value="">Please Slelect:</option>
                                                                        <option value="1" <?php if ($data->service==1) echo 'selected="selected"';?>>Free Trial </options>
                                                                        <option value="2" <?php if ($data->service==2) echo 'selected="selected"';?>>1 Month</options>
                                                                        <option value="3" <?php if ($data->service==3) echo 'selected="selected"';?>>3 Months</options>
                                                                        
                                                                  </select>
                                                                    <?php echo form_error('service', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="selectError3">Active Status</label>
								<div class="controls">
								  <select id="selectError3" name="status">
									<option value="">Please Slelect:</option>
                                                                        <option value="1" <?php if ($data->status==1) echo 'selected="selected"';?>>Active</options>
                                                                        <option value="0" <?php if ($data->status==0) echo 'selected="selected"';?>>Inactive</options>
                                                                        
                                                                  </select>
                                                                    <?php echo form_error('status', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
						
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button class="btn">Cancel</button>
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