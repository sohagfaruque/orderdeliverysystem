<?php
class Lib {

	function __construct() {
            //$this->load->library('session');
	}

	public function send_email($m){
		$CI = & get_instance();
		$from = $m['from_email'];
		$from_name = $m['from_name'];
		if ( $_SERVER['HTTP_HOST']=='localhost' ) {
			$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						'smtp_port' => 465,
						'smtp_user' => 'weddingportalit@gmail.com',
						'smtp_pass' => 'wedd1ngP',
						'mailtype' => 'html',
						'charset'   => 'UTF-8'
						);

			$CI->load->library('email', $config);
			$CI->email->set_newline("\r\n");
			$CI->email->from($from, $from_name);
			$CI->email->to($m['to']);
			$CI->email->subject($m['subject']);
			$CI->email->message($m['message']);
			if (isset ($m['cc']))
				$CI->email->cc($m['cc']);
			if (isset ($m['bcc']))
				$CI->email->bcc($m['bcc']);

			if ($CI->email->send()) {
				return TRUE;
			}
			else {
				show_error($CI->email->print_debugger());
				return FALSE;
			}
		}
		else {

			$headers = 'MIME-Version: 1.0'."\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
			$headers .= 'To: '.$m['to']."\r\n";
			$headers .= 'From: '.$from_name.' <'.$from.'>'."\r\n";
			if (isset ($m['cc']))
				$headers .= 'Cc: '.$m['cc']."\r\n";
			if (isset ($m['bcc']))
				$headers .= 'Bcc: '.$m['bcc']."\r\n";

			$err = mail($m['to'], $m['subject'], $m['message'], $headers);
			return $err;
		}
		
	}
	
	public function now(){
		return date('Y-m-d H:i:s');
	}
	
	public function date_format($date){
		return date('d M, Y @ h:iA');
	}
	
	public function upload_file($source,$destination){
		return move_uploaded_file($source,$destination);;
	}
	
	public function image_resize($data){
		$CI = & get_instance();
		$config['image_library'] = 'gd2';
		$config['source_image']	= $data['source_image'];
		$config['new_image'] = $data['new_image'];
		$config['create_thumb'] = $data['create_thumb'];
		$config['maintain_ratio'] = $data['maintain_ratio'];
		$config['width'] = $data['width'];
		$config['height'] = $data['height'];
		
		$CI->load->library('image_lib');
		$CI->image_lib->initialize($config);			
		return $CI->image_lib->resize();
	}
	public function convert_time($sec){
	
		$hours = floor($sec / 3600);
		$mins = floor(($sec - ($hours*3600)) / 60);
		$secs = floor($sec % 60);
		$time = $hours.':'.$mins.':'.$secs;
		return $time;
	}
        public function auth_check(){
                $CI =& get_instance();
		if($CI->session->userdata('authenkey')==FALSE)
                    {
                        $redirecturl = base_url();
                        redirect($redirecturl,'refresh');
                    }else{
                         return true;
                }
	}
}
?>