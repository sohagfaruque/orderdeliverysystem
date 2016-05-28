<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
    
    function __construct() {
        $this->load->database();
    }
	function fetch_check_email($email,$col,$tblName) {
        $this->db->where($col,$email);
		$query = $this->db->get($tblName);
		$result = $query->num_rows();
        return $result;
    }
	function update_temp_pass($email,$wherecol,$tmp_pass,$tblName) {
		$this->db->where($wherecol, $email);
		$result = $this->db->update($tblName, $tmp_pass);
		return $result;
       
    }
	function change_final_pass($tmp_pass,$id,$col,$tblName) {
		$this->db->where($col, $id);
		$result = $this->db->update($tblName, $tmp_pass);
		return $result;
    }
	function get_pass_id($email,$col,$wherecol,$tblName) {
		$this->db->select($col);
		$this->db->where($wherecol,$email);
		$query = $this->db->get($tblName);
        $result = $query->result();
        return $result;
    }
	function is_temp_pass_valid($tmp_pass,$id,$tblName) {
        $this->db->where('vPassword', $tmp_pass);
		$this->db->where('iAdminId', $id);
		$query = $this->db->get($tblName);
		$result = $query->num_rows();
        return $result;
    }
 //////////////////////////////////////////////////////////               
    function get_user($email,$password,$fcol,$scol,$tblName){
        
		$this->db->where($fcol,$email);
		$this->db->where($scol,$password);
        $query = $this->db->get($tblName);
        $result = $query->result();
		return $result;
    }
     function user_list($active_user,$pending_user_list){
		if(empty($active_user) && empty($pending_user_list)){
			$sql = "SELECT * FROM user_list";
		}elseif(!empty($active_user) && empty($pending_user_list)){
			 $sql = "SELECT count(*) as activeUser FROM user_list WHERE status='1'";
		}elseif(empty($active_user) && !empty($pending_user_list)){
			 $sql = "SELECT count(*) as pendingUser FROM user_list WHERE status='0'";
		}
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	function set_user($insert_ARR){
        $result = $this->db->insert('user_list', $insert_ARR);
		return $result;
	}
	
	function record_count_user() {
        return $this->db->count_all("user_list");
    }
	function record_count_search_user($email) {
        $this->db->like('email', $email);
		$query = $this->db->get("user_list");
		$result = $query->num_rows();
        return $result;
    }
	function record_count_search_icon($title) {
        $this->db->like('title', $title);
		$query = $this->db->get("icon");
		$result = $query->num_rows();
        return $result;
    }
	function record_count_search_news($title) {
        $this->db->like('title', $title);
		$query = $this->db->get("news");
		$result = $query->num_rows();
        return $result;
    }
	function record_count_search_faqs($title) {
        $this->db->like('question', $title);
		$query = $this->db->get("faq");
		$result = $query->num_rows();
        return $result;
    }

    function fetch_data_user($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
        $query = $this->db->get("user_list");
		$result = $query->result();
        return $result;
   }
   function fetch_search_data_user($limit, $start,$email) {
        $mail = $email;
		//print_r($mail); exit;
		$this->db->limit($limit, $start);
        $this->db->like('email', $mail);
		$query = $this->db->get("user_list");
		$result = $query->result();
        return $result;
   }
   function fetch_search_data_icon($limit, $start,$title) {
		$this->db->limit($limit, $start);
        $this->db->like('title', $title);
		$query = $this->db->get("icon");
		$result = $query->result();
        return $result;
   }
   function fetch_search_data_news($limit, $start,$title) {
		$this->db->limit($limit, $start);
        $this->db->like('title', $title);
		$query = $this->db->get("news");
		$result = $query->result();
        return $result;
   }
    function fetch_search_data_faq($limit, $start,$title) {
		$this->db->limit($limit, $start);
        $this->db->like('question', $title);
		$query = $this->db->get("faq");
		$result = $query->result();
        return $result;
   }
   function userinfo($id){
		$sql = "SELECT * FROM user_list WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
		
   }
    function update_user($insert_ARR,$id){
        //print_r($insert_ARR); exit;
		$this->db->where('id', $id);
		$result = $this->db->update('user_list', $insert_ARR);
		return $result;
	}
	
	function delete_user($id){
        //print_r($insert_ARR); exit;
		$this->db->where('id', $id);
		$result = $this->db->delete('user_list');
		
		return $result;
	}
	
/*   * Ennd User Part *  * Ennd User Part *  * Ennd User Part *  * Ennd User Part *  * Ennd User Part *  * Ennd User Part *  * Ennd User Part **/

	function news_list($published_news,$unpublished_news){
		if(empty($published_news) && empty($unpublished_news)){
			$sql = "SELECT * FROM news";
		}elseif(!empty($published_news) && empty($unpublished_news)){
			 $sql = "SELECT count(*) as publishednews FROM news WHERE publishstatus=1";
		}elseif(empty($published_news) && !empty($unpublished_news)){
			 $sql = "SELECT count(*) as unpublishednews FROM news WHERE publishstatus!=1";
		}
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	function icon_list($published_icon,$unpublished_icon){
		if(empty($published_icon) && empty($unpublished_icon)){
			$sql = "SELECT * FROM icon";
		}elseif(!empty($published_icon) && empty($unpublished_icon)){
			 $sql = "SELECT count(*) as publishedicon FROM icon WHERE publishstatus=1";
		}elseif(empty($published_icon) && !empty($unpublished_icon)){
			 $sql = "SELECT count(*) as unpublishedicon FROM icon WHERE publishstatus!=1";
		}
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	function faq_list($published_faqs,$unpublished_faqs){
		if(empty($published_faqs) && empty($unpublished_faqs)){
			$sql = "SELECT * FROM faq";
		}elseif(!empty($published_faqs) && empty($unpublished_faqs)){
			 $sql = "SELECT count(*) as publishedfaq FROM faq WHERE publishstatus=1";
		}elseif(empty($published_faqs) && !empty($unpublished_faqs)){
			 $sql = "SELECT count(*) as unpublishedfaq FROM faq WHERE publishstatus!=1";
		}
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	 function fetch_data_news($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
        $query = $this->db->get("news");
		$result = $query->result();
        return $result;
	}
	 function fetch_data_icon($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
        $query = $this->db->get("icon");
		$result = $query->result();
        return $result;
	}
    function fetch_data_faqs($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
        $query = $this->db->get("faq");
		$result = $query->result();
        return $result;
   }
    function record_count_icon() {
        return $this->db->count_all("icon");
    }
	function record_count_news() {
        return $this->db->count_all("news");
    }
	function record_count_faqs() {
        return $this->db->count_all("faq");
    }
	
	function set_news($insert_news){
        $result = $this->db->insert('news', $insert_news);
		return $result;
	}
	function set_icon($insert_icon){
        $result = $this->db->insert('icon', $insert_icon);
		return $result;
	}
	function set_faq($insert_faq){
        $result = $this->db->insert('faq', $insert_faq);
		return $result;
	}
	function delete_icon($id){
		$this->db->where('id', $id);
		$result = $this->db->delete('icon');
		return $result;
	}
	function delete_news($id){
		$this->db->where('id', $id);
		$result = $this->db->delete('news');
		return $result;
	}
	function delete_faq($id){
		$this->db->where('id', $id);
		$result = $this->db->delete('faq');
		return $result;
	}
		
	function update_icon($update_icon,$id){
       
		$this->db->where('id', $id);
		$result = $this->db->update('icon', $update_icon);
		return $result;
	}
	function update_news($update_news,$id){
       
		$this->db->where('id', $id);
		$result = $this->db->update('news', $update_news);
		return $result;
	}
	function update_faq($update_faq,$id){
       
		$this->db->where('id', $id);
		$result = $this->db->update('faq', $update_faq);
		return $result;
	}
	 function iconinfo($id){
		$sql = "SELECT * FROM icon WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
	function newsinfo($id){
		$sql = "SELECT * FROM news WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
   function faqinfo($id){
		$sql = "SELECT * FROM faq WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
		
   }
   /*asdfasdasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd */
   function record_count_cat() {
        return $this->db->count_all("category");
    }
	function cat_list($active_cat,$pending_cat){
		if(empty($active_cat) && empty($pending_cat)){
			$sql = "SELECT * FROM category";
		}elseif(!empty($active_cat) && empty($pending_cat)){
			 $sql = "SELECT count(*) as activeCat FROM category WHERE pstatus='1'";
		}elseif(empty($active_cat) && !empty($pending_cat)){
			 $sql = "SELECT count(*) as pendingCat FROM category WHERE pstatus='0'";
		}
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	function fetch_data_cat($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
        $query = $this->db->get("category");
		$result = $query->result();
        return $result;
   }
   function set_cat($insert_cat){
        $result = $this->db->insert('category', $insert_cat);
		return $result;
	}
	function record_count_search_cat($title) {
        $this->db->like('title', $title);
		$query = $this->db->get("category");
		$result = $query->num_rows();
        return $result;
    }
	function fetch_search_data_cat($limit, $start,$title) {
        
		
		$this->db->limit($limit, $start);
        $this->db->like('title', $title);
		$query = $this->db->get("category");
		
		$result = $query->result();
        return $result;
   }
   function delete_cat($id){
        //print_r($insert_ARR); exit;
		$this->db->where('id', $id);
		$result = $this->db->delete('category');
		
		return $result;
	}
	function update_cat($update_cat,$id){
       
		$this->db->where('id', $id);
		$result = $this->db->update('category', $update_cat);
		return $result;
	}
	 function catinfo($id){
		$sql = "SELECT * FROM category WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
		
   }
   function check_cat($title,$id){
		$sql = "SELECT title FROM category WHERE title='$title' AND id!='$id'";
		$query = $this->db->query($sql);
        $result = $query->num_rows();
		return $result;
		
   }
    function check_availcat($title){
		$sql = "SELECT title FROM category WHERE title='$title'";
		$query = $this->db->query($sql);
        $result = $query->num_rows();
		return $result;
		
   }
   /*asdfasdasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd */
	function record_count_album() {
        return $this->db->count_all("album");
    }
	function fetch_data_album($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get("album");
		$result = $query->result();
        return $result;
   }
   function album_list($active_album,$pending_album){
		if(empty($active_album) && empty($pending_album)){
			$sql = "SELECT * FROM album";
		}elseif(!empty($active_album) && empty($pending_album)){
			 $sql = "SELECT count(*) as activeCat FROM album WHERE status='1'";
		}elseif(empty($active_album) && !empty($pending_album)){
			 $sql = "SELECT count(*) as pendingCat FROM album WHERE status!='1'";
		}
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	function get_catlist(){
		$sql="SELECT title,id from category";
		$query = $this->db->query($sql);
		$result = $query->result();
        return $result;
	
	}
	function delete_album($id){
        //print_r($insert_ARR); exit;
		$this->db->where('id', $id);
		$result = $this->db->delete('album');
		
		return $result;
	}
	function set_album($insert_albm){
        $result = $this->db->insert('album', $insert_albm);
		return $result;
	}
	function record_count_search_album($title) {
        $this->db->like('title', $title);
		$query = $this->db->get("album");
		$result = $query->num_rows();
        return $result;
    }
	function fetch_search_data_album($limit, $start,$title) {

		
		$this->db->limit($limit, $start);
        $this->db->like('title', $title);
		$query = $this->db->get("album");
		$result = $query->result();
        return $result;
   }
   function get_albm($id){
		$sql="SELECT id,title from album WHERE id='$id'";
		$query = $this->db->query($sql);
		$result = $query->result();
        return $result;
	
	}
	function set_song($insert_song){
        $result = $this->db->insert('song', $insert_song);
		return $result;
	}
	function update_album($update_albm,$id){
       
		$this->db->where('id', $id);
		$result = $this->db->update('album', $update_albm);
		return $result;
	}
	 function albuminfo($id){
		$sql = "SELECT * FROM album WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
		
   }
   function album_prev_thumbnail($id){
		$sql = "SELECT thumbnail FROM album WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
		
   }
   function song_avality($id){
       
		$sql = "SELECT album FROM song WHERE album ='$id'";
		$query = $this->db->query($sql);
        $result = $query->num_rows();
        return $result;
	}
	function song_total(){
       
		$sql = "SELECT count(song.id) as totalSong,album.id FROM song INNER JOIN album on song.album=album.id group by album.id;";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
	}
	function record_count_song($id) {
        $this->db->where('album', $id);
		$query = $this->db->get("song");
		$result = $query->num_rows();
        return $result;
    }
	function fetch_data_song($limit,$start,$id) {
		
		$this->db->limit($limit, $start);
		$this->db->where('album', $id);
		$this->db->order_by("id","DESC");
		$query = $this->db->get("song");
		$result = $query->result();
		
        return $result;
   }
	
   function get_albuminfo($id) {

		$this->db->where('id', $id);
		$query = $this->db->get("album");
		$result = $query->result();
        return $result;
   }
   function get_category_name($id){
		$sql="SELECT category.title, category.id FROM category LEFT JOIN album ON category.id = album.category WHERE album.id='$id'";
		$query = $this->db->query($sql);
		$result = $query->result();
        return $result;
	
	}
	function record_count_search_song($title,$id) {
        $this->db->like('title', $title);
		$this->db->where('album', $id);
		$query = $this->db->get("song");
		$result = $query->num_rows();
        return $result;
    }
	function fetch_search_data_song($limit, $start,$id,$title) {

		$this->db->where('album', $id);
		$this->db->limit($limit, $start);
        $this->db->like('title', $title);
		$query = $this->db->get("song");
		$result = $query->result();
		//print_r(count($result)); exit;
        return $result;
   }
   function delete_song($id){

		$this->db->where('id', $id);
		$result = $this->db->delete('song');
		
		return $result;
	}
	 function songsinfo($id){
		$sql = "SELECT * FROM song WHERE id='$id'";
		$query = $this->db->query($sql);
        $result = $query->result();
        return $result;
		
   }
   function update_song($update_song,$id){
       
		$this->db->where('id', $id);
		$result = $this->db->update('song', $update_song);
		return $result;
	}
}