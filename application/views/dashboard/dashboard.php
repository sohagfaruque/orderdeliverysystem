<div class="right_countainer">
    <div class="statsnew">
        <div class="log_capture_left">
            <p><span class="ip_left">Last Login Date:</span> 
                <span class="ip_right">
                    <?php echo date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($this->session->userdata('last_logged_time'))); ?>
                </span> </p>
            <p><span class="ip_left">Last Login IP:</span><?php echo $this->session->userdata('logged_ip'); ?></p>
        </div>
        <div class="log_capture_right">
            <p><span class="ip_left_ct">Current Date:</span> <span class="ip_right"><?php echo date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime(date('Y-m-d H:i:s'))) ?></span> </p>
            <p><span class="ip_left_ct">Current IP:</span><span class="ip_right"><?php echo $_SERVER['REMOTE_ADDR']; ?></span></p>
        </div>
    </div>
    <hr class="whiter m-t-10">
    <div class="stats">		
        <ul>
            <li>
                <div class="bx">
                    <div class="icon orange"><img src="<?php echo base_url('assets/images') ?>/package.png" /></div>
                    <div class="hedingbx">Total Cities: <?php echo count($cityValue);?></div>
                </div>
            </li>
            <li>
                <div class="bx">
                    <div class="icon yellow"><img src="<?php echo base_url('assets/images') ?>/package.png" /></div>
                    <div class="hedingbx">Total Areas: <?php echo count($areaValue);?></div>
                </div>
            </li>
            <li>
                <div class="bx">
                    <div class="icon yellow"><img src="<?php echo base_url('assets/images') ?>/products.png" /></div>
                    <div class="hedingbx">Total Distributors: <?php echo count($distributortValue);?></div>
                </div>
            </li>
            <li>
                <div class="bx">
                    <div class="icon orange"><img src="<?php echo base_url('assets/images') ?>/1boxicon.png" /></div>
                    <div class="hedingbx">Total Users: <?php echo count($userValue);?></div>
                </div>
            </li>
            <li>
                <div class="bx">
                    <div class="icon orange"><img src="<?php echo base_url('assets/images') ?>/products.png" /></div>
                    <div class="hedingbx">Total Products: <?php echo count($productValue);?></div>
                </div>
            </li>
            <li>
                <div class="bx">
                    <div class="icon yellow"><img src="<?php echo base_url('assets/images') ?>/1boxicon.png" /></div>
                    <div class="hedingbx">Total Orders: <?php echo count($orderValue);?></div>
                </div>
            </li>
        </ul>
    </div>
</div>