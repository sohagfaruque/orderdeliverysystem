<script>
function newDoc()
  {
  window.location.assign("<?php echo base_url()."home";?>")
  }
</script>
<?php foreach($result as $data){ }?>
<div id="content" class="span10">
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">User Profile</a>
					</li>
				</ul>
			</div>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Details <i><?php echo $data->name;?></i></h2>
					</div>
					<div class="box-content">
                                            <form class="form-horizontal" action="<?php echo base_url().'home/profile_edit/'.$data->id;?>" method="post">
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="name" id="name" type="text" value="<?php echo $data->name;?>">
                                                                  <?php echo form_error('name', '<p class="error-mas">', '</p>'); ?>
								</div>
							  </div>
							        
                                                          <div class="control-group">
								<label class="control-label" for="focusedInput">Email</label>
								<div class="controls">
								  <input class="input-xlarge focused" name ="email" id="email" type="text" value="<?php echo $data->email;?>">
                                                                  <?php echo form_error('email', '<p class="error-mas">', '</p>'); ?>
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