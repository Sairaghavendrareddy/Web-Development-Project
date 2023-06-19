<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('checklogin_admin_helper');
		$this->load->model('loginmodel');
		$this->load->model('common_model');
	}
	public function dashboard(){
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['today_orders']=$this->db->query("SELECT * FROM orders WHERE order_date > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY order_id DESC")->result_array();
		$data['week_orders']=$this->db->query("SELECT * FROM orders WHERE order_date > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY order_id DESC")->result_array();
		$data['month_orders']=$this->db->query("SELECT * FROM orders WHERE order_date > DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY order_id DESC")->result_array();
		$data['total_orders']=$this->db->get_where('orders')->num_rows();
		$data['total_sales']=$this->db->query("Select SUM(order_amount) as total_sales FROM orders")->result_array();
		$data['total_users']=$this->db->get_where('users')->num_rows();
		$data['sold_out']=$this->db->query("SELECT prod_available_qty as sold_out FROM `product_mesurments` WHERE `prod_available_qty`=0")->num_rows();
		$data['last_month']=$this->db->query("SELECT * FROM orders WHERE month(order_date)=month(now())-1")->num_rows();
		$data['orders_failed']=$this->db->query("SELECT `order_status` FROM `orders` WHERE `order_status`='Failed'")->num_rows();
		$data['orders_cancelled']=$this->db->query("SELECT `order_status` FROM `orders` WHERE `order_status`='Cancelled'")->num_rows();
		$data['orders_delivered']=$this->db->query("SELECT `order_status` FROM `orders` WHERE `order_status`='Delivered'")->num_rows();
		// print_r($data['orders_failed']);exit;
		$data['active_menu']='dashboard';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}
	public function data_table()
	{
		$data['active_menu']='dashboard';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/data_table');
		$this->load->view('admin/footer');
	}
	public function logout(){
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('login_type');
        redirect('master');
    }
	public function category()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['category']=$this->db->query("SELECT * FROM `categories`")->result_array();
		$data['active_menu']='category';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/category');
		$this->load->view('admin/footer');
	}
	public function change_category_status($catid='', $sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('cat_id',$catid);
		$res=$this->db->update('categories',$data);
		if ($res==1)
					{
						$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Category status updated successfully.</strong></div>');
						 redirect('admin/category');
					}
					else
					{
					$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Category status update failed!</strong></div>');
						 redirect('admin/category');
					}
	}
	public function edit_category($catid='')
	{
		checklogin_admin();
		$table_id=$this->session->userdata('table_id');
		$data['active_menu']='category';
        $data['category']=$this->db->get_where('categories',array('cat_id'=>$catid))->result_array();		
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_category');
		$this->load->view('admin/footer');
	}
	public function update_category()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$category_name=$this->input->post('category_name');
		$oldpic=$this->input->post('oldpic');
		$catid=$this->input->post('category_id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/category';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']=true;
				$this->upload->initialize($config);

				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
						 redirect('admin/category');
					}
					else
					{
						
							$imagename=$imagename;
					}
			}
			else{
				$imagename=$oldpic;
			}
			$cat_id=$this->input->post('category_id');
		$check=$this->db->get_where('categories',array('title'=>trim($this->input->post('title')),'cat_id!='=>$cat_id))->num_rows();
		  if($check==0){
			$this->db->update('categories',array('title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date),array('cat_id'=>$cat_id));
			###########===================#############
			$br=$this->common_model->commonGet('category_brands','`brand_id`,`cat_id`,sub_cat_id,`brand_title`',array('cat_id'=>$cat_id,'status'=>1),'all');
			$brands=json_encode($br);
			$brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('cat_id'=>$cat_id,'status'=>1));
			$this->common_model->commonUpdate('categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('cat_id'=>$cat_id));
			###########===================#############
			$this->session->set_flashdata('success','Category Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','This Category already added !..');
		  }
		redirect('admin/category/');
		
	}
	public function add_category()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='category';
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_category');
		$this->load->view('admin/footer');
	}
	public function save_category()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/category')) {
			mkdir('assets/category', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/category';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = '*';
				$config['overwrite']=true;
				$this->upload->initialize($config);
				 if(!$this->upload->do_upload('simage'))
					{
						//print_r($this->upload->display_errors()); exit;
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
						 redirect('admin/category');
					}
					else
					{
						$imagename=$imagename;
					}
			}
			else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image!</strong></div>');
						 redirect('admin/category');
			}
			$check=$this->db->get_where('categories',array('title'=>trim($this->input->post('title'))))->num_rows();
			if($check==0){
				$data=array('title'=>$title,'icon'=>$imagename,'status'=>1,'created_date'=>$created_date);
				$this->db->insert('categories',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Category Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Category already added !..</strong></div>');
			}
			redirect('admin/category/');
	}
	public function subcategory()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['category']=$this->db->query("SELECT * FROM `sub_categories`")->result_array();
		$data['active_menu']='subcategory';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/subcategory');
		$this->load->view('admin/footer');
	}
	public function change_subcategory_status($catid='', $sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('sub_cat_id',$catid);
		$res=$this->db->update('sub_categories',$data);
		if ($res==1){
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Category status updated successfully.</strong></div>');
			redirect('admin/subcategory');
		}else{
			$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Category status update failed!</strong></div>');
			redirect('admin/subcategory');
		}
	}
	public function edit_subcategory($catid='')
	{
		checklogin_admin();
		$table_id=$this->session->userdata('table_id');
		$data['active_menu']='subcategory';
		$data['maincategory']=$this->db->query("SELECT * FROM `categories` WHERE status=1 ORDER BY `title` ASC")->result_array();
        $data['category']=$this->db->get_where('sub_categories',array('sub_cat_id'=>$catid))->result_array();
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_subcategory');
		$this->load->view('admin/footer');
	}
	public function update_subcategory()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$category_name=$this->input->post('category_name');
		$oldpic=$this->input->post('oldpic');
		$catid=$this->input->post('cat_id');
		$sub_cat_id=$this->input->post('sub_cat_id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/category';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']=true;
				$this->upload->initialize($config);

				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
						 redirect('admin/subcategory');
					}
					else
					{
						
							$imagename=$imagename;
					}
			}
			else{
				$imagename=$oldpic;
			}
		  $check=$this->db->get_where('sub_categories',array('title'=>trim($this->input->post('title')),'cat_id'=>$catid,'sub_cat_id!='=>$sub_cat_id))->num_rows();
		  if($check==0){
			$this->db->update('sub_categories',array('title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date,'cat_id'=>$catid),array('sub_cat_id'=>$sub_cat_id));
			$this->Add_SubCats_To_Main_Cat($catid);
			###########===================#############
			$br=$this->common_model->commonGet('category_brands','`brand_id`, `cat_id`,sub_cat_id,`brand_title`',array('sub_cat_id'=>$sub_cat_id,'status'=>1),'all');
			$brands=json_encode($br);
			$brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('sub_cat_id'=>$sub_cat_id,'status'=>1));
			$this->common_model->commonUpdate('sub_categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('sub_cat_id'=>$sub_cat_id));
			###########===================#############
			$this->session->set_flashdata('success','SubCategory Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','This SubCategory already added !..');
		  }
		redirect('admin/subcategory/');
		
	}
	public function add_subcategory()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='subcategory';
		$data['category']=$this->db->query("SELECT * FROM `categories` WHERE status=1 ORDER BY `title` ASC")->result_array();
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_subcategory');
		$this->load->view('admin/footer');
	}
	public function save_subcategory()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$cat_id=$this->input->post('cat_id');
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/category')) {
			mkdir('assets/category', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
		{
			$file=str_replace(" ","_",$_FILES['simage']['name']);
			$imagename=time().$file;
			$this->load->library('upload');
			$config['upload_path'] = 'assets/category';
			$config['file_name'] = $imagename;
			$config['allowed_types'] = '*';
			$config['overwrite']=true;
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('simage')){
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
				redirect('admin/subcategory');
			}else{
				$imagename=$imagename;
			}
		}else{
			$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image!</strong></div>');
			redirect('admin/subcategory');
		}
		$check=$this->db->get_where('sub_categories',array('title'=>trim($this->input->post('title')),'cat_id'=>$cat_id))->num_rows();
		if($check==0){
			$this->Add_SubCats_To_Main_Cat($cat_id);
			$data=array('title'=>$title,'icon'=>$imagename,'status'=>1,'created_date'=>$created_date,'cat_id'=>$cat_id);
			$this->db->insert('sub_categories',$data);
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Subcategory Added successfully</strong></div>');
		}else{
			$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Category already added !..</strong></div>');
		}
		redirect('admin/subcategory/');
	}
	public function add_brand()
	{
		checklogin_admin();
		//'sub_cat_id' => $post['sub_cat_id'],
		if($this->input->post()){
			$post = $this->input->post();
			$wHArray=array(
				'cat_id'=>$post['category_id'],
				'LOWER(brand_title)'=>strtolower(trim($post['title'])),
			);
			$Check=$this->common_model->commonCheck('category_brands','brand_id',$wHArray);
			if($Check==0){
				$Array=array(
					'cat_id'=>$post['category_id'],
					'brand_title'=>trim($post['title']),
				);
				$brand_id = $this->common_model->commonInsert('category_brands',$Array);
				$this->db->update('categories',array('title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date),array('cat_id'=>$cat_id));
				###########===================#############
				$cat_id = $post['category_id'];
				$br=$this->common_model->commonGet('category_brands','`brand_id`, `cat_id`, sub_cat_id,`brand_title`',array('cat_id'=>$cat_id,'status'=>1),'all');
				$brands=json_encode($br);
				$brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('cat_id'=>$cat_id,'status'=>1));
				$this->common_model->commonUpdate('categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('cat_id'=>$cat_id));
				// $sub_cat_id = $post['sub_cat_id'];
				// $br=$this->common_model->commonGet('category_brands','`brand_id`, `cat_id`, sub_cat_id,`brand_title`',array('sub_cat_id'=>$sub_cat_id,'status'=>1),'all');
				// $brands=json_encode($br);
				// $brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('sub_cat_id'=>$sub_cat_id,'status'=>1));
				// $this->common_model->commonUpdate('sub_categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('sub_cat_id'=>$sub_cat_id));
				###########===================#############
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Brand added successfully.</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Brand already added to selected catgeory!</strong></div>');
			}
			redirect('/admin/brands');
		}
		$data = array();
		$data['active_menu']='category';
		$admin_id=$this->session->userdata('admin_id');
		$data['category']=$this->db->query("SELECT * FROM `categories` ORDER BY `title` ASC")->result_array();
		$data['sub_cat_id'] = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1")->result_array();
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_brand');
		$this->load->view('admin/footer');
	}
	public function brands()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['brands']=$this->db->query("SELECT a.sub_cat_id,a.brand_id,b.`title`,a.`status`, a.`created_date`, a.`updated_date`,a.brand_title,c.title as subtitle FROM `category_brands` a LEFT JOIN categories b ON a.`cat_id`=b.`cat_id` LEFT JOIN sub_categories  c ON c.sub_cat_id=a.sub_cat_id")->result_array();
		$data['active_menu']='brands';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/brands');
		$this->load->view('admin/footer');
	}
	public function change_brand_status($brand_id='',$cat_id='', $sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('brand_id',$brand_id);
		$res=$this->db->update('category_brands',$data);
		if ($res==1){
			###########===================#############
			$br=$this->common_model->commonGet('category_brands','`brand_id`, `cat_id`, `brand_title`',array('cat_id'=>$cat_id,'status'=>1),'all');
			$brands=json_encode($br);
			$brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('cat_id'=>$cat_id,'status'=>1));
			$this->common_model->commonUpdate('categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('cat_id'=>$cat_id));
			###########===================#############
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Brand status changed successfully.</strong></div>');
		}else{
			$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Brand status update failed!</strong></div>');
		}
		redirect('admin/brands');
		
	}
	public function edit_brand($brand_id='')
	{
		checklogin_admin();
		$table_id=$this->session->userdata('table_id');
        $data['brand']=$this->db->query("SELECT `brand_id`, `cat_id`, `sub_cat_id`, `brand_title`, `icon`, `status`, `created_date`, `updated_date` FROM `category_brands` WHERE `brand_id`=$brand_id")->row_array();
		$catid = $data['brand']['cat_id'];
		$data['category']=$this->db->order_by('title', 'ASC')->get_where('categories',array('cat_id>'=>0))->result_array();		
		$data['sub_cat_id'] = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1 AND cat_id=$catid")->result_array();
		$data['active_menu']='brands';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_brand');
		$this->load->view('admin/footer');
	}
	public function update_brand($brand_id=0)
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$category_name=$this->input->post('category_name');
		$oldpic=$this->input->post('oldpic');
		$catid=$this->input->post('category_id');
		$sub_cat_id=@$this->input->post('sub_cat_id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/category';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']=true;
				$this->upload->initialize($config);

				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
						 redirect('admin/category');
					}else{
						
							$imagename=$imagename;
					}
			}else{
				$imagename=$oldpic;
			}
			$cat_id=$this->input->post('category_id');
		    $check=$this->db->get_where('category_brands',array('brand_title'=>trim($this->input->post('title')),'cat_id'=>$cat_id,'brand_id!='=>$brand_id))->num_rows();
		    if($check==0){
				$this->db->update('category_brands',array('brand_title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date,'cat_id'=>$cat_id),array('brand_id'=>$brand_id));
				###########===================#############
					$br=$this->common_model->commonGet('category_brands','`brand_id`, `cat_id`, `brand_title`',array('cat_id'=>$cat_id,'status'=>1),'all');
					$brands=json_encode($br);
					$brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('cat_id'=>$cat_id,'status'=>1));
					$this->common_model->commonUpdate('categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('cat_id'=>$cat_id));
				// 	$sub_cat_id = $this->input->post('sub_cat_id');
				// 	$br=$this->common_model->commonGet('category_brands','`brand_id`, `cat_id`, sub_cat_id,`brand_title`',array('sub_cat_id'=>$sub_cat_id,'status'=>1),'all');
				// 	$brands=json_encode($br);
				// 	$brand_count=$this->common_model->commonCheck('category_brands','brand_id',array('sub_cat_id'=>$sub_cat_id,'status'=>1));
				// 	$this->common_model->commonUpdate('sub_categories',array('brands'=>$brands,'is_brands_available'=>$brand_count),array('sub_cat_id'=>$sub_cat_id));
				###########===================#############	
				$this->session->set_flashdata('success','Brand Updated successfully..');
		    }else{
				$this->session->set_flashdata('failed','This Brand already added !..');
		   	}
		   redirect('admin/brands/');
		
	}
	public function product_measurement($pid='')
	{
		$prod_id=$this->input->post('prod_id');
		$data['mes']=$this->db->query("SELECT a.`id` as prod_mes_id, a.`prod_id`, a.`mes_id`, a.`prod_image`, a.`prod_image_name`, a.`prod_org_price`, a.`prod_offered_price`, a.`prod_available_qty`,b.title,prod.prod_title FROM `product_mesurments` a LEFT JOIN mesurements b ON a.`mes_id`=b.mes_id LEFT JOIN products prod ON a.prod_id=prod.prod_id WHERE a.`prod_id`=$prod_id")->result_array();
		$data['combos']=$this->db->query("SELECT `prod_id`, `combo_products` FROM `products` WHERE `prod_id`=$prod_id")->row_array();
// 		echo "<pre>";print_r($data['combos']);exit;
		$pg='No Measurements found';
		$tit='';
		if(count($data['mes'])>0){
			$pg=$this->load->view('admin/product_measurement',$data,TRUE);
			$tit='Product : '.$data['mes'][0]['prod_title'];
		}
		$dt = array('tit'=>$tit,'pg'=>$pg);
		echo json_encode($dt);
	}
	public function combo_product($pid='')
	{
		$prod_id=$this->input->post('prod_id');
		$data['mes']=$this->db->query("SELECT `prod_id`, `prod_title`,`combo_products` FROM `products` WHERE `prod_id`=$prod_id")->row_array();
		// echo "<pre>";print_r($data['mes']);exit;
		$pg='No Data Found';
		$tit='';
		if(count($data['mes'])>0){
			$pg=$this->load->view('admin/combo_product',$data,TRUE);
			$tit='Product : '.$data['mes']['prod_title'];
		}
		$dt = array('tit'=>$tit,'pg'=>$pg);
		echo json_encode($dt);
	}
	public function products()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='products';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/products');
		$this->load->view('admin/footer');
	}
	public function get_products(){
	    $ispopsubtype=$this->input->get('ispopsubtype')?intval( $this->input->get('ispopsubtype') ) :0;
		$start=$this->input->get('start')?intval( $this->input->get('start') ) :0;
		$length=$this->input->get('length')?intval( $this->input->get('length') ) :0;
		$search=$this->input->get('search')?$this->input->get('search'):array('value'=>'');
		$order=$this->input->get('order')?$this->input->get('order') :array(array('column'=>'','dir'=>'DESC')); 
		$column=$order[0]['column'];
		$dir=$order[0]['dir'];
		$records=array();
		$returndata=array();
		$totalcount=$this->loginmodel->search_product_Details($ispopsubtype,1,$start,$length,$search['value'],$column,$dir);
		$returndata['recordsTotal']=0;
		$returndata['recordsFiltered']=0;
		$returndata['recordsTotal']+=$totalcount;
		if($search['value']!=''){
			$returndata['recordsFiltered']+=$totalcount;
		}else{
			$returndata['recordsFiltered']=$returndata['recordsTotal'];
		}
		$stu['output'] = $this->loginmodel->search_product_Details($ispopsubtype,2,$start,$length,$search['value'],$column,$dir);
		$stu['returndata']=$returndata;
		$returndata['draw']=$this->input->get('draw') ?intval( $this->input->get('draw')):0;
		echo $this->load->view('admin/get_all_products',$stu,TRUE);
	}
	public function combos()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='combos';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/combos');
		$this->load->view('admin/footer');
	}
	public function get_combos(){
	    $ispopsubtype=$this->input->get('ispopsubtype')?intval( $this->input->get('ispopsubtype') ) :0;
		$start=$this->input->get('start')?intval( $this->input->get('start') ) :0;
		$length=$this->input->get('length')?intval( $this->input->get('length') ) :0;
		$search=$this->input->get('search')?$this->input->get('search'):array('value'=>'');
		$order=$this->input->get('order')?$this->input->get('order') :array(array('column'=>'','dir'=>'DESC')); 
		$column=$order[0]['column'];
		$dir=$order[0]['dir'];
		$records=array();
		$returndata=array();
		$totalcount=$this->loginmodel->search_product_Details($ispopsubtype,1,$start,$length,$search['value'],$column,$dir);
		$returndata['recordsTotal']=0;
		$returndata['recordsFiltered']=0;
		$returndata['recordsTotal']+=$totalcount;
		if($search['value']!=''){
			$returndata['recordsFiltered']+=$totalcount;
		}else{
			$returndata['recordsFiltered']=$returndata['recordsTotal'];
		}
		$stu['output'] = $this->loginmodel->search_product_Details($ispopsubtype,2,$start,$length,$search['value'],$column,$dir);
		// echo "<pre>";print_r($stu['output']);exit;
		$stu['returndata']=$returndata;
		$returndata['draw']=$this->input->get('draw') ?intval( $this->input->get('draw')):0;
		echo $this->load->view('admin/get_all_combos',$stu,TRUE);
	}
	public function edit_location($loc_id='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
        $data['location']=$this->db->get_where('locations',array('loc_id'=>$loc_id))->result_array();		
		$data['active_menu']='locations';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_location');
		$this->load->view('admin/footer');
	}
	public function edit_measurements($mes_id='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
        $data['measurements']=$this->db->get_where('mesurements',array('mes_id'=>$mes_id))->result_array();
        $data['category']=$this->db->order_by('title', 'ASC')->get_where('categories',array('status'=>'1'))->result_array();
        $data['active_menu']='measurements';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_measurements');
		$this->load->view('admin/footer');
	}
	public function update_location()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$oldpic=$this->input->post('oldpic');
		$loc_id=$this->input->post('loc_id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/location';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']=true;
				$this->upload->initialize($config);

				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
						 redirect('admin/locations');
					}
					else
					{
						
							$imagename=$imagename;
					}
			}
			else{
				$imagename=$oldpic;
			}
			$loc_id=$this->input->post('loc_id');
		$check=$this->db->get_where('locations',array('title'=>trim($this->input->post('title')),'loc_id!='=>$loc_id))->num_rows();
		  if($check==0){
			$this->db->update('locations',array('title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date),array('loc_id'=>$loc_id));
			$this->session->set_flashdata('success','Location Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','Location Updating failed...');
		  }
		redirect('admin/locations/');
		
	}
	public function update_measurements()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$cat_id=$this->input->post('cat_id');
		$title=$this->input->post('title');
		$mes_id=$this->input->post('mes_id');
		$updated_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('mesurements',array('title'=>trim($this->input->post('title')),'cat_id'=>$cat_id,'mes_id!='=>$mes_id))->num_rows();
		  if($check==0){
			$this->db->update('mesurements',array('title'=>trim($this->input->post('title')),'cat_id'=>$cat_id,'updated_date'=>$updated_date),array('mes_id'=>$mes_id));
			$this->session->set_flashdata('success','Measurements Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','This Title already existed...');
		  }
		redirect('admin/measurements/');
		
	}
	public function change_password()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='dashboard';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/change_password');
		$this->load->view('admin/footer');
	}
	public function check_admin_password()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$output = 'false';
		$old_password = md5($this->input->get("old_password"));	
        $res=$this->db->get_where('admin_login',array('admin_id'=>$admin_id,'password'=>$old_password))->result_array();	
		if(count($res)>0){
			$output = 'true';
		}		
			echo $output;
	}
	public function update_password()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$old_password=md5($this->input->post('old_password'));
		$new_password=md5($this->input->post('new_password'));
		$confirm_password=md5($this->input->post('confirm_password'));
		if($new_password==$confirm_password){
			$res=$this->db->get_where('admin_login',array('admin_id'=>$admin_id,'password'=>$old_password))->result_array();
			// echo $this->db->last_query();exit;
			if(count($res)>0){
				$data=array('password'=>$new_password);
				$this->db->where('admin_id',$admin_id);
				$this->db->update('admin_login',$data);
				$this->session->set_flashdata('success','Password updated successfully...</strong></div>');
			}else{
				$this->session->set_flashdata('failed','Old Password incorrect Please try again...');
			}
		}else{
			$this->session->set_flashdata('failed','New Password and Confirm Password do not match');
		}
		redirect('admin/change_password');
	}
	public function offer_banners()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['offer_banners']=$this->db->query("SELECT * FROM `prod_offer_banners`")->result_array();
		$data['active_menu']='offer_banners';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/offer_banners');
		$this->load->view('admin/footer');
	}
	public function change_offer_banner_status($bannerid='', $sta='')
	{
		$data = array('is_active'=>$sta);
		$this->db->where('id',$bannerid);
		$res=$this->db->update('prod_offer_banners',$data);
		if ($res==1)
		{
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Banner status updated successfully.</strong></div>');
			redirect('/admin/offer_banners');
		}else
		{
			$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Banner status update failed!</strong></div>');
			redirect('/admin/offer_banners');
		}
	}
	public function add_offer_banners()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='offer_banners';
		$admin_id=$this->session->userdata('admin_id');
		$data['products']=$this->db->query("SELECT `prod_id`, `prod_title` FROM `products`")->result_array();
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_offer_banners');
		$this->load->view('admin/footer');
	}
	public function save_offer_banners()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$page=$this->input->post('page');
		$module=$this->input->post('module');
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		$prods_implode=$this->input->post('prods[]');
		$prods ='[' . implode(',', $prods_implode) . ']';
		// print_r($prods);exit;
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/banners')) {
			mkdir('assets/banners', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
		{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/banners';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = '*';
				$config['overwrite']=true;
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('simage'))
				{
					$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
						redirect('admin/offer_banners');
				}
				else
				{
					$imagename=$imagename;
				}
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image!</strong></div>');
						 redirect('admin/offer_banners');
			}
			// $check=$this->db->get_where('sliders',array('title'=>trim($this->input->post('title'))))->num_rows();
				$data=array('page'=>$page,'module'=>$module,'title'=>$title,'image'=>$imagename,'description'=>$description,'prods'=>$prods,'is_active'=>1,'created_at'=>$created_date);
				$res =$this->db->insert('prod_offer_banners',$data);
				if($res==1){
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Banner Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Banner already added !..</strong></div>');
			}
			redirect('/admin/offer_banners/');
	}
	public function edit_offer_banners($bannerid='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['products']=$this->db->query("SELECT * FROM `products`")->result_array();
		$data['category']=$this->db->get_where('categories',array('status'=>'1'))->result_array();
        $data['offer_banners']=$this->db->get_where('prod_offer_banners',array('id'=>$bannerid))->row_array();
        $data['active_menu']='offer_banners';
        $prodids =str_replace(array( '[', ']' ), '', $data['offer_banners']['prods']);
        $data['arr_prods']=explode(",",$prodids);
        // echo "<pre>";print_r($data['arr_prods']);exit;
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_offer_banners');
		$this->load->view('admin/footer');
	}
	public function update_offer_banners()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$page=$this->input->post('page');
		$module=$this->input->post('module');
		$title=$this->input->post('title');
		$description=$this->input->post('description');
		$prods_implode=$this->input->post('prods[]');
		$prods ='[' . implode(',', $prods_implode) . ']';
		//print_r($prods);exit;
		$oldpic=$this->input->post('oldpic');
		$id=$this->input->post('id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if($_FILES['simage']['name'] !='')
		{
			$file=str_replace(" ","_",$_FILES['simage']['name']);
			$imagename=time().$file;
			$this->load->library('upload');
			$config['upload_path'] = 'assets/banners';
			$config['file_name'] = $imagename;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite']=true;
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('simage'))
			{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
					redirect('/admin/offer_banners');
			}else{
				$imagename=$imagename;
			}
		}else{
			$imagename=$oldpic;
		}
			$res =$this->db->update('prod_offer_banners',array('page'=>trim($this->input->post('page')),'image'=>$imagename,'module'=>$module,'title'=>$title,'description'=>$description,'prods'=>$prods,'updated_date'=>$updated_date),array('id'=>$id));
			if($res==1){
				$this->session->set_flashdata('success','Banner Updated successfully..');
			}else{
				$this->session->set_flashdata('failed','Banner Updating failed...');
			}
			redirect('/admin/offer_banners/');
	}
	public function view_offer_products()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$id =$this->input->post('id');
        $data['offer_products']=$this->db->get_where('prod_offer_banners',array('id'=>$id))->row_array();
        $data['active_menu']='offer_banners';
		echo $this->load->view('admin/view_offer_banner_products',$data,TRUE);
	}
	public function sliders()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['banners']=$this->db->query("SELECT * FROM `sliders`")->result_array();
		$data['active_menu']='slider';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/sliders');
		$this->load->view('admin/footer');
	}
	public function save_slider()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/banners')) {
			mkdir('assets/banners', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
		{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/banners';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = '*';
				$config['overwrite']=true;
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('simage'))
				{
					$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
						redirect('admin/sliders');
				}
				else
				{
					$imagename=$imagename;
				}
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image!</strong></div>');
						 redirect('admin/sliders');
			}
			$check=$this->db->get_where('sliders',array('title'=>trim($this->input->post('title'))))->num_rows();
			if($check==0){
				$data=array('title'=>$title,'icon'=>$imagename,'status'=>1,'created_date'=>$created_date);
				$this->db->insert('sliders',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Banner Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Banner already added !..</strong></div>');
			}
			redirect('/admin/sliders/');
	}
	public function add_slider()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='slider';
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_slider');
		$this->load->view('admin/footer');
	}
	public function edit_slider($bannerid='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
        $data['banner']=$this->db->get_where('sliders',array('slider_id'=>$bannerid))->result_array();		
		$data['active_menu']='slider';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_slider');
		$this->load->view('admin/footer');
	}
	public function change_slider_status($bannerid='', $sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('slider_id',$bannerid);
		$res=$this->db->update('sliders',$data);
		if ($res==1)
		{
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Slider status updated successfully.</strong></div>');
			redirect('/admin/sliders');
		}else
		{
			$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Slider status update failed!</strong></div>');
			redirect('/admin/sliders');
		}
	}
	public function update_slider()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$oldpic=$this->input->post('oldpic');
		$slider_id=$this->input->post('slider_id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if($_FILES['simage']['name'] !='')
		{
			$file=str_replace(" ","_",$_FILES['simage']['name']);
			$imagename=time().$file;
			$this->load->library('upload');
			$config['upload_path'] = 'assets/banners';
			$config['file_name'] = $imagename;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite']=true;
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('simage'))
			{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
					redirect('/admin/sliders');
			}else{
				$imagename=$imagename;
			}
		}else{
			$imagename=$oldpic;
		}
		$check=$this->db->get_where('sliders',array('title'=>trim($this->input->post('title')),'slider_id!='=>$slider_id))->num_rows();
		if($check==0){
			$this->db->update('sliders',array('title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date),array('slider_id'=>$slider_id));
			$this->session->set_flashdata('success','Slider Updated successfully..');
		}else{
			$this->session->set_flashdata('failed','Slider Updating failed...');
		}
		redirect('/admin/sliders/');
	}
	public function banners()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['banners']=$this->db->query("SELECT * FROM `banners`")->result_array();
		$data['active_menu']='banner';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/banners');
		$this->load->view('admin/footer');
	}
	public function save_banner()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/banners')) {
			mkdir('assets/banners', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
		{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/banners';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = '*';
				$config['overwrite']=true;
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('simage'))
				{
					$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
						redirect('admin/banners');
				}
				else
				{
					$imagename=$imagename;
				}
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image!</strong></div>');
						 redirect('admin/banners');
			}
			$check=$this->db->get_where('banners',array('title'=>trim($this->input->post('title'))))->num_rows();
			if($check==0){
				$data=array('title'=>$title,'icon'=>$imagename,'status'=>1,'created_date'=>$created_date);
				$this->db->insert('banners',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Banner Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Banner already added !..</strong></div>');
			}
			redirect('admin/banners/');
	}
	public function add_banner()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='banner';
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_banner');
		$this->load->view('admin/footer');
	}
	public function edit_banner($bannerid='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
        $data['banner']=$this->db->get_where('banners',array('banner_id'=>$bannerid))->result_array();		
		$data['active_menu']='banner';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_banner');
		$this->load->view('admin/footer');
	}
	public function change_banner_status($bannerid='', $sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('banner_id',$bannerid);
		$res=$this->db->update('banners',$data);
		if ($res==1)
		{
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Banner status updated successfully.</strong></div>');
			redirect('admin/banners');
		}else
		{
			$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Banner status update failed!</strong></div>');
			redirect('admin/banners');
		}
	}
	public function update_banner()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$oldpic=$this->input->post('oldpic');
		$banner_id=$this->input->post('banner_id');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/banners';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']=true;
				$this->upload->initialize($config);

				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
						 redirect('admin/banners');
					}
					else
					{
						
							$imagename=$imagename;
					}
			}
			else{
				$imagename=$oldpic;
			}
			
		$check=$this->db->get_where('banners',array('title'=>trim($this->input->post('title')),'banner_id!='=>$banner_id))->num_rows();
		  if($check==0){
			$this->db->update('banners',array('title'=>trim($this->input->post('title')),'icon'=>$imagename,'updated_date'=>$updated_date),array('banner_id'=>$banner_id));
			$this->session->set_flashdata('success','Banner Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','Banner Updating failed...');
		  }
		redirect('admin/banners/');
		
	}
	public function orders($user_id=0)
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['user_id'] = $user_id;
		$data['active_menu']='orders';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/orders');
		$this->load->view('admin/footer');
	}
	public function get_orders(){
	    $user_id=$this->input->get('user_id');
		$start=$this->input->get('start')?intval( $this->input->get('start') ) :0;
		$length=$this->input->get('length')?intval( $this->input->get('length') ) :0;
		$search=$this->input->get('search')?$this->input->get('search'):array('value'=>'');
		$order=$this->input->get('order')?$this->input->get('order') :array(array('column'=>'','dir'=>'DESC')); 
		$column=$order[0]['column'];
		$dir=$order[0]['dir'];
		$records=array();
		$returndata=array();
		$totalcount=$this->loginmodel->search_ord_Details(1,$start,$length,$search['value'],$column,$dir,$user_id);
		$returndata['recordsTotal']=0;
		$returndata['recordsFiltered']=0;
		$returndata['recordsTotal']+=$totalcount;
		if($search['value']!=''){
			$returndata['recordsFiltered']+=$totalcount;
		}else{
			$returndata['recordsFiltered']=$returndata['recordsTotal'];
		}
		$stu['output'] = $this->loginmodel->search_ord_Details(2,$start,$length,$search['value'],$column,$dir,$user_id);
		$stu['returndata']=$returndata;
		$returndata['draw']=$this->input->get('draw') ?intval( $this->input->get('draw')):0;
		echo $this->load->view('admin/get_all_orders',$stu,TRUE);
	}
	public function users()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='users';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/users');
		$this->load->view('admin/footer');
	}
	public function get_users(){
		$start=$this->input->get('start')?intval( $this->input->get('start') ) :0;
		$length=$this->input->get('length')?intval( $this->input->get('length') ) :0;
		$search=$this->input->get('search')?$this->input->get('search'):array('value'=>'');
		$order=$this->input->get('order')?$this->input->get('order') :array(array('column'=>'','dir'=>'DESC')); 
		$column=$order[0]['column'];
		$dir=$order[0]['dir'];
		$records=array();
		$returndata=array();
		$totalcount=$this->loginmodel->search_user_Details(1,$start,$length,$search['value'],$column,$dir);
		$returndata['recordsTotal']=0;
		$returndata['recordsFiltered']=0;
		$returndata['recordsTotal']+=$totalcount;
		if($search['value']!=''){
			$returndata['recordsFiltered']+=$totalcount;
		}else{
			$returndata['recordsFiltered']=$returndata['recordsTotal'];
		}
		$stu['userdetails'] = $this->loginmodel->search_user_Details(2,$start,$length,$search['value'],$column,$dir);
		$stu['returndata']=$returndata;
		$returndata['draw']=$this->input->get('draw') ?intval( $this->input->get('draw')):0;
		echo $this->load->view('admin/get_users',$stu,TRUE);
	}
	public function locations()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['locations']=$this->db->query("SELECT * FROM `locations`")->result_array();
		$data['active_menu']='locations';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/locations');
		$this->load->view('admin/footer');
	}
	public function measurements()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['measurements']=$this->db->query("SELECT a.`mes_id`, a.`cat_id`, a.`title`, a.`status`, a.`created_date`, a.`updated_date`,b.title as cat_title FROM `mesurements` a LEFT JOIN categories b ON a.`cat_id`=b.cat_id")->result_array();
		$data['active_menu']='measurements';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/measurements');
		$this->load->view('admin/footer');
	}

	public function change_measurements_status($docid='',$sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('mes_id',$docid);
		$res=$this->db->update('mesurements',$data);
		if ($res==1)
					{
						$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Measurements status updated successfully.</strong></div>');
						  redirect('admin/measurements');
					}
					else
					{
					$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Measurements status update failed!</strong></div>');
						  redirect('admin/measurements');
					}
	}
	
	public function change_product_status($aid='', $sta='')
	{
		$data = array('prod_status'=>$sta);
		$this->db->where('prod_id',$aid);
		$res=$this->db->update('products',$data);
		if ($res==1)
					{
						$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Product status updated successfully.</strong></div>');
						  redirect('admin/products/');
					}
					else
					{
					$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Product status update failed!</strong></div>');
						  redirect('admin/products/');
					}
	}
	public function save_product()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$prod_id=@$this->input->post('prod_id');
		$title=$this->input->post('title');
		$category_id=$this->input->post('category_id');
		$sub_cat_id=$this->input->post('sub_cat_id');
		$prod_brand = @$this->input->post('prod_brand');
		$about = @$this->input->post('about');
		$created_date =date("Y-m-d H:i:s");
		if (!file_exists('assets/products')) {
			mkdir('assets/products', 0777, true);
		}
		$is_popular = @$this->input->post('is_popular');
		$is_popular = ($is_popular=='')?0:1;
		$available_subscraibe = @$this->input->post('available_subscraibe');
		$available_subscraibe = ($available_subscraibe=='')?0:1;
		$data=array(
			'prod_sub_category'=>$sub_cat_id,
			'prod_description'=>$about,
			'prod_title'=>$title,
			'prod_category'=>$category_id,
			'prod_brand'=>$prod_brand,
			'prod_mesurements'=>'',
			'prod_status'=>1,
			'prod_created_date'=>$created_date,
			'is_popular'=>$is_popular,
			'available_subscraibe'=>$available_subscraibe,
			//'prod_slug' => $this->common_model->slug_gen($title,'prod_slug','products','prod_id',0),
		);
		$org_price=$this->input->post('org_price');
		$offered_price=$this->input->post('offered_price');
		$available_qty=$this->input->post('available_qty');
		$prod_mesur =$this->input->post('mesurement_id');
		$prod_mes_id_s =$this->input->post('prod_mes_id');
		$simages = $_FILES["simage"];
		if($prod_id!='' || $prod_id>0){
			$this->common_model->commonUpdate('products',$data,array('prod_id'=>$prod_id));
			$imgcnt = 1;
		}else{
			$imgcnt = count($simages);
		}
		$sample=array();
		if($imgcnt>0){
			if(count($org_price)>0){
				if($prod_id =='' || $prod_id==0){
					$prod_id=$this->common_model->commonInsert('products',$data);
				}
				foreach($prod_mesur as $k=>$prod_mesurement){
					$p_name = @$simages['name'][$k];
					$p_tmp_name = @$simages['tmp_name'][$k];
					$sample[$k][]=0;
					if(count($p_name)>0){
						foreach($p_name as $kk=>$name){
							$img_name 		= $name;
							if($img_name!=''){
								$img_tmp_name   = $p_tmp_name[$kk];
								$md5		= $k.$kk.date('Ymd').time().'.jpg';
								$targetFile = 'assets/products/'.$md5;
								$name = $img_name;
								$tmp_name = $img_tmp_name;
								move_uploaded_file($tmp_name,$targetFile);
								$imagename[$k][]=$md5;
								$img[$k][]=$name;
								$sample[$k][]=1;
							}
						}
					}
					if(array_sum($sample[$k])>0){
						$prod_image      = json_encode($imagename[$k]);
						$prod_image_name = json_encode($img[$k]);
					}else{
						$prod_image='';
						$prod_image_name='';
					}
					$offered_rs = $offered_price[$k];
					$available_qt = $available_qty[$k];
					$org_rs = $org_price[$k];
					$prod_mes_id = $prod_mes_id_s[$k];
					$mes =array(
						'prod_id'=>$prod_id,
						'mes_id'=>$prod_mesurement,
						'prod_org_price'=>$org_rs,
						'prod_offered_price'=>$offered_rs,
						'prod_available_qty'=>$available_qt
					);
					if($prod_image!=''){
						$mes_imgs =array(
							'prod_image'=>$prod_image,
							'prod_image_name'=>$prod_image_name
						);
						$mes =array_merge($mes,$mes_imgs);
					}
					if($prod_mes_id!='' && $prod_mes_id>0){
						$mes_id=$prod_mes_id;
						$this->common_model->commonUpdate('product_mesurments',$mes,array('id'=>$prod_mes_id));
					}else{
						$mes_id=$this->common_model->commonInsert('product_mesurments',$mes);
					}
				}
				$ms = $this->common_model->GetProdMes($prod_id);
				if(count($ms)>0){
					$prod_mesurements = json_encode($ms);
					$up = array('prod_mesurements'=>$prod_mesurements);
					$this->common_model->commonUpdate('products',$up,array('prod_id'=>$prod_id));
				}
				//echo'<pre>';print_r($mes);exit;
			}else{
				if($prod_id =='' || $prod_id==0){
					$this->session->set_flashdata('error','<div class="alert alert-danger msgfade"><strong>Product adding failed try again</strong></div>');
					redirect('admin/add_product');
				}else{
					$this->session->set_flashdata('error','<div class="alert alert-danger msgfade"><strong>Product updating failed try again</strong></div>');
					redirect('admin/edit_product/'.$prod_id);
				}
			}
		}else{
			if($prod_id =='' || $prod_id==0){
				$this->session->set_flashdata('error','<div class="alert alert-danger msgfade"><strong>Please upload images for all the mesurments</strong></div>');
				redirect('admin/add_product');
			}else{
				$this->session->set_flashdata('error','<div class="alert alert-danger msgfade"><strong>Please upload images for all the mesurments</strong></div>');
				redirect('admin/edit_product/'.$prod_id);
			}
		}
		if($prod_id =='' || $prod_id==0){
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Product added successfully</strong></div>');
		}else{
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Product updated successfully</strong></div>');
		}
		$cat = $this->db->select('title')->get_where('categories',array('cat_id'=>$category_id))->row_array();
		if(!empty($cat)){
			$title = strtolower($cat['title']);
			$defined = combo();
			if($title==$defined['ct']){
				$combo_prod_id = $prod_id;
				if(!empty($this->input->post('combo_prod_mes_id'))){
					$prod_mes_ids = implode(',',$this->input->post('combo_prod_mes_id'));
				}
				$dt=$this->db->query("SELECT c.prod_title,b.title as mesurment,a.`prod_id`,a.`mes_id`,a.id as prod_mes_id,a.`prod_image`,a.`prod_org_price`,a.`prod_offered_price`,a.`prod_available_qty` FROM `product_mesurments` a JOIN mesurements b ON a.`mes_id`=b.mes_id JOIN products c ON a.prod_id=c.prod_id WHERE a.id IN ($prod_mes_ids)")->result_array();
				$arr=array();
				foreach($dt as $v){
				$prod=json_decode($v['prod_image'],TRUE);
				if(isset($prod[0])){
				$v['prod_image'] = $prod[0];
				}else{
				$v['prod_image'] ='';
				}
				$arr[]=$v;
				}
				$prods = json_encode($arr);
				$this->db->query("UPDATE `products` SET `combo_products`='$prods' WHERE `prod_id`=$combo_prod_id");
			}
		}
		redirect('admin/products');
	}
	public function delete_prod_mess(){
		$existed_prod_id	=	 $this->input->post('existed_prod_id');
		$prod_id			=	 $this->input->post('prod_id');
		if($existed_prod_id>0){
			$wharr=array('prod_id'=>$existed_prod_id);
			$product = $this->db->select('combo_products')->get_where('products',$wharr)->row_array();
			$decode = json_decode($product['combo_products'],true);
			$dec=array();
			foreach($decode as $decp){
				if($prod_id!=$decp['prod_id']){
					$dec[]=$decp['prod_mes_id'];
				}
			}
			//print_r($product);exit;
			$combo_prod_id = $existed_prod_id;
			if(!empty($dec)){
				$prod_mes_ids = implode(',',$dec);
			}else{
				$prod_mes_ids = 0;
			}
			$dt=$this->db->query("SELECT c.prod_title,b.title as mesurment,a.`prod_id`,a.`mes_id`,a.id as prod_mes_id,a.`prod_image`,a.`prod_org_price`,a.`prod_offered_price`,a.`prod_available_qty` FROM `product_mesurments` a JOIN mesurements b ON a.`mes_id`=b.mes_id JOIN products c ON a.prod_id=c.prod_id WHERE a.id IN ($prod_mes_ids)")->result_array();
			$arr=array();
			foreach($dt as $v){
				$prod=json_decode($v['prod_image'],TRUE);
				if(isset($prod[0])){
					$v['prod_image'] = $prod[0];
				}else{
					$v['prod_image'] ='';
				}
				$arr[]=$v;
			}
			$prods = json_encode($arr);
			$this->db->query("UPDATE `products` SET `combo_products`='$prods' WHERE `prod_id`=$combo_prod_id");
		}
		// if($this->session->userdata('prods')!=''){
		// 	$all = $this->session->unset_userdata('prods');
		// 	foreach($all as $kkk=>$v){
		// 		if($v==$prod_id){
		// 			unset($all[$kkk]);
		// 		}
		// 	}
		// }
	}
	public function add_product()
	{
		checklogin_admin();
		//if($this->session->userdata('prods')!=''){$this->session->unset_userdata('prods');}
		$data = array();
		$data['active_menu']='products';
		$admin_id=$this->session->userdata('admin_id');
		$data['products']=$this->db->query("SELECT * FROM `products` ORDER BY `prod_title` ASC")->result_array();
		$data['category']=$this->db->order_by('title', 'ASC')->get_where('categories',array('status'=>'1'))->result_array();
		$data['brands']=$this->db->order_by('brand_title', 'ASC')->get_where('category_brands',array('status'=>'1'))->result_array();
		$data['sub_cat_id'] = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1 ORDER BY `title` ASC")->result_array();
		$data['prod_id']='';
		$data['pg']=$this->Get_Prods_MesurMents(0);
		$data['prods'] = $this->db->query("SELECT `prod_id`,`prod_title` FROM `products` WHERE `prod_status`=1 ORDER BY `prod_title` ASC")->result_array();
		$data['sno']=0;
		$data['type']=1;
		$data['mes']=array();
		$data['combos']=$this->load->view('admin/prod_combo',$data,TRUE);
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_product');
		$this->load->view('admin/footer');
	}
	public function add_combo()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='combos';
		$admin_id=$this->session->userdata('admin_id');
		$data['products']=$this->db->query("SELECT * FROM `products`")->result_array();
		$data['category']=$this->db->get_where('categories',array('status'=>'1'))->result_array();
		$data['brands']=$this->db->get_where('category_brands',array('status'=>'1'))->result_array();
		$data['sub_cat_id'] = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1")->result_array();
		$data['products'] = $this->db->query("SELECT `prod_id`, `prod_title` FROM `products` WHERE `prod_status`=1")->result_array();
		$data['prod_id']='';
		$data['pg']=$this->Get_Prods_MesurMents(0);
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_combo');
		$this->load->view('admin/footer');
	}
	public function edit_product($prod_id='')
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='products';
		$admin_id=$this->session->userdata('admin_id');
		$data['products']=$this->db->query("SELECT * FROM `products` WHERE prod_status=1")->result_array();
		$data['category']=$this->db->get_where('categories',array('status'=>'1'))->result_array();
		$data['product']=$this->db->query("SELECT available_subscraibe,is_popular,`prod_description`,`prod_id`,prod_sub_category, `prod_title`, `prod_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`,combo_products FROM `products` WHERE `prod_id`=$prod_id")->row_array();
		$data['brands']=$this->db->get_where('category_brands',array('status'=>1,'sub_cat_id'=>$data['product']['prod_sub_category']))->result_array();
		if(empty($data['product'])){
			redirect('admin/products');
		}
		if($data['product']['combo_products']!=''){
			$defined = combo();
			$data['category']=$this->db->get_where('categories',array('status'=>'1','title'=>$defined['ct']))->result_array();
		}
		$cat_id=$data['product']['prod_category'];
		$temp['brands']=$this->db->get_where('category_brands',array('cat_id'=>$cat_id,'status'=>'1'))->result_array();
		$temp['mesurement']=$this->db->get_where('mesurements',array('cat_id'=>$cat_id,'status'=>'1'))->result_array();
		$data['prod_id']=$prod_id;
		$pg='';
		$mess=$data['product']['prod_mesurements'];
		if($mess!=''){
		$dec_mes=json_decode($mess,true);
		$cnt = count($dec_mes);
			foreach($dec_mes as $k=>$ms){
				$temp['mes']=$ms;
				$temp['id']=$k+1;
				$temp['load_type']=0;
				$incr = $k+1;
				$temp['enable']=($incr==$cnt)?1:0;
				$pg .= $this->load->view('admin/prod_mes',$temp,TRUE);
			}
		}
		$data['pg']=$pg;
		$data['sub_cat_id'] = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1")->result_array();
		$data['prods'] = $this->db->query("SELECT `prod_id`,`prod_title` FROM `products` WHERE `prod_status`=1")->result_array();
		$combos='';
		if($data['product']['combo_products']!=''){
			$decode = json_decode($data['product']['combo_products'],true);
			$dec=array();
			foreach($decode as $decp){
				$dec[$decp['prod_id']][]=$decp['prod_mes_id'];
			}
			//echo '<pre>' ; print_r($dec);exit;
			$i=0;
			$iniqids=array();
			foreach($dec as $kk=>$p){
				$iniqids[]=$kk;
				$temp['sno'] = $i;
				$temp['pid'] = $kk;
				$temp['prod_mes_id'] = $p;
				$prod_id = $temp['pid'];
				$temp['prods']=$this->db->query("SELECT * FROM `products` WHERE prod_status=1")->result_array();
				$temp['mes'] = $this->db->query("SELECT a.`id` prod_mes_id, b.title,a.`prod_org_price`,a.`prod_offered_price` FROM `product_mesurments` a INNER JOIN mesurements b ON a.`mes_id`=b.mes_id WHERE a.`prod_id`=$prod_id")->result_array();
				$temp['type']=($i==0)?0:1;
				$combos .= $this->load->view('admin/prod_combo',$temp,TRUE);
				$i++;
			}
			$iniqids_pids = array_unique($iniqids);
			//$this->session->set_userdata('prods',$iniqids_pids);
			//echo '<pre>';print_r($this->session->userdata('prods'));exit;
		}else{
			$data['sno']=0;
			$data['type']=1;
			$data['mes']=array();
			$combos=$this->load->view('admin/prod_combo',$data,TRUE);
		}
		$data['combos']=$combos;
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_product');
		$this->load->view('admin/footer');
	}
	public function edit_combo($prod_id='')
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='products';
		$admin_id=$this->session->userdata('admin_id');
		$data['products']=$this->db->query("SELECT * FROM `products`")->result_array();
		$data['category']=$this->db->get_where('categories',array('status'=>'1'))->result_array();
		$data['product']=$this->db->query("SELECT available_subscraibe,is_popular,`prod_description`,`prod_id`,prod_sub_category, `prod_title`, `prod_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`,`combo_products`, `prod_updated_date`, `orders_count` FROM `products` WHERE `prod_id`=$prod_id")->row_array();
		$data['brands']=$this->db->get_where('category_brands',array('status'=>1,'sub_cat_id'=>$data['product']['prod_sub_category']))->result_array();
		if(empty($data['product'])){
			redirect('admin/combos');
		}
		$cat_id=$data['product']['prod_category'];
		$temp['brands']=$this->db->get_where('category_brands',array('cat_id'=>$cat_id,'status'=>'1'))->result_array();
		$temp['mesurement']=$this->db->get_where('mesurements',array('cat_id'=>$cat_id,'status'=>'1'))->result_array();
		$data['prod_id']=$prod_id;
		$pg='';
		$mess=$data['product']['combo_products'];
		if($mess!=''){
		$dec_mes=json_decode($mess,true);
			foreach($dec_mes as $k=>$ms){
				$temp['mes']=$ms;
				$temp['id']=$k+1;
				$temp['load_type']=0;
				$pg .= $this->load->view('admin/prod_mes',$temp,TRUE);
			}
		}
		$data['pg']=$pg;
		$data['sub_cat_id'] = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1")->result_array();
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_combo');
		$this->load->view('admin/footer');
	}
	public function Get_Prods_MesurMents($id=0){
		$check=0;
		$wh=array('status'=>'1');
		if($this->input->post()){
			$id=$this->input->post('id');
			$check=1;
			if($this->input->post('cat_id')){
				$cat_id = $this->input->post('cat_id');
				$wh=array_merge(array('cat_id'=>$cat_id),$wh);
			}
		}
		$data['id']=$id+1;
		$data['mesurement']=$this->db->get_where('mesurements',$wh)->result_array();
		$data['load_type']=1;
		$data['enable']=1;
		if($check==1){
			echo $this->load->view('admin/prod_mes',$data,TRUE);
		}else{
			return $this->load->view('admin/prod_mes',$data,TRUE);
		}
	}
	public function Get_SubBrands(){
	    $cat_id = $this->input->post('cat_id');
		$brands=$this->db->get_where('category_brands',array('sub_cat_id'=>$cat_id,'status'=>1))->result_array();
		$bn = '<option value="">Select Brand</option>';
		if(count($brands)>0){
			foreach($brands as $br){
				$brand_id = @$br['brand_id'];
				$brand_title = $br['brand_title'];
				$bn .= "<option value='".$brand_id."'>".$brand_title."</option>";
			}
		}
		echo $bn;
	}
	public function Get_Brands(){
		$cat_id = $this->input->post('cat_id');
		$brands=$this->db->get_where('category_brands',array('cat_id'=>$cat_id,'status'=>'1'))->result_array();
		$bn = '<option value="">Select Brand</option>';
		if(count($brands)>0){
			foreach($brands as $br){
				$brand_id = @$br['brand_id'];
				$brand_title = $br['brand_title'];
				$bn .= "<option value='".$brand_id."'>".$brand_title."</option>";
			}
		}
		$mesur=$this->db->get_where('mesurements',array('cat_id'=>$cat_id,'status'=>'1'))->result_array();
		$ms = '<option value="">Select Mesurement</option>';
		if(count($mesur)>0){
			foreach($mesur as $msr){
				$mes_id = $msr['mes_id'];
				$title = $msr['title'];
				$ms .= "<option value='".$mes_id."'>".$title."</option>";
			}
		}
		$cat = $this->db->select('title')->get_where('categories',array('cat_id'=>$cat_id))->row()->title;
		$defined = combo();
		$array=array(
			'brand'=>$bn,
			'mes'=>$ms,
			'cat'=>strtolower($cat),
			'ct'=>$defined['ct']
		);
		echo json_encode($array);
	}
	public function qrcodes()
	{
		checklogin_admin();
		$data['qrcodes'] = $this->db->query("SELECT `scanner_id`, `prod_ids`, `title`, `qr_code`, `status`, `created_date`, `updated_date` FROM `scan_prods` ORDER BY `scanner_id` DESC")->result_array();
		$data['active_menu']='qrcodes';
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/qrcodes');
		$this->load->view('admin/footer');
	}
	public function add_qrcodes()
	{
	    if($this->input->post()){
            $ids=array();
            $tits=array();
	        $title=$this->input->post('title');
	        $check = $this->db->select('scanner_id')->get_where('scan_prods',array('title'=>$title))->num_rows();
	        if($check==0){
    	        $prod_id=$this->input->post('prod_id');
    	        $prod_id = array_values(array_filter($prod_id));
    	        if(count($prod_id)>0){
    	            foreach($prod_id as $pd){
    	                $prodet=$this->db->query("SELECT `prod_id`,`prod_title` FROM `products` WHERE prod_id=$pd")->row_array();
    	                $ids[]=$prodet['prod_id'];
    	                $tits[]=$prodet['prod_title'];
    	            }
                    if(!file_exists('assets/qrcodes')){mkdir('assets/qrcodes', 0777, true);}
                    $imgname=time();
                    $pnames=implode(',',$tits);
                    $pids=implode('##',$ids);
                    $insert=array(
                    'prod_ids'=>$pids,
                    'title'=>$title
                    );
                    $this->db->insert('scan_prods',$insert);
                    $scanner_id = $this->db->insert_id();
                    // $this->load->library('ciqrcode');
                    // $type=(count($prod_id)>1)?'s':'';
                    // $details = 'Product name'.$type.':'.ucfirst($pnames);
                    // $details .=',Product id'.$type.':'.$pids;
                    // $params['data'] = $pids;
                    // $params['level'] = 'H';
                    // $params['size'] = 10;
                    // $path='assets/qrcodes/'.$imgname.'';
                    // $params['savename'] = $path.'.png';
                    // $this->ciqrcode->generate($params);
                    //$fname=$params['savename'];
                    $filepath = (isset($_GET["filepath"])?$_GET["filepath"]:"");
                    $text = $scanner_id;
                    $size = (isset($_GET["size"])?$_GET["size"]:"20");
                    $orientation = (isset($_GET["orientation"])?$_GET["orientation"]:"horizontal");
                    $code_type = (isset($_GET["codetype"])?$_GET["codetype"]:"code128");
                    $print = (isset($_GET["print"])&&$_GET["print"]=='true'?true:false);
                    $sizefactor = (isset($_GET["sizefactor"])?$_GET["sizefactor"]:"1");
                    $tm=date("dmY").time();
                    $fname=$tm.'.png';
                    $this->load->model('common_model');
                    $this->common_model->barcode($tm, $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor);
                    $up=array('qr_code'=>$fname);
                    $this->db->update('scan_prods',$up,array('scanner_id'=>$scanner_id));
                    $this->session->set_flashdata('msg','Added successfully');
    	            redirect(base_url().'admin/qrcodes');
    	        }else{
    	            $this->session->set_flashdata('msg','Please select the products');
    	            redirect(base_url().'admin/add_qrcodes');
    	        }
	        }else{
	             $this->session->set_flashdata('msg','Please enter the titles');
	            redirect(base_url().'admin/add_qrcodes');
	        }
	    }
		checklogin_admin();
		$data['active_menu']='qrcodes';
		$data['prods'] =$this->db->query("SELECT a.`prod_id`,a.`prod_title`,b.title FROM `products` a LEFT JOIN categories b ON a.`prod_category`=b.cat_id WHERE a.`prod_status`=1")->result_array();
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_qrcode');
		$this->load->view('admin/footer');
	}
	public function add_location()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='locations';
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_location');
		$this->load->view('admin/footer');
	}
	public function add_measurements()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='measurements';
		$data['category']=$this->db->query("SELECT * FROM `categories` ORDER BY `title` ASC")->result_array();
		$admin_id=$this->session->userdata('admin_id');
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_measurements');
		$this->load->view('admin/footer');
	}
	public function save_location()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/location')) {
			mkdir('assets/location', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/location';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = '*';
				$config['overwrite']=true;
				$this->upload->initialize($config);
				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
						 redirect('admin/locations');
					}
					else
					{
						$imagename=$imagename;
					}
			}
			else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image!</strong></div>');
						 redirect('admin/locations');
			}
			$check=$this->db->get_where('locations',array('title'=>trim($this->input->post('title'))))->num_rows();
			if($check==0){
				$data=array('title'=>$title,'icon'=>$imagename,'created_date'=>$created_date);
				$this->db->insert('locations',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Category already added !..</strong></div>');
			}
			redirect('admin/locations/');
	}
	public function save_measurements()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$title=$this->input->post('title');
		$cat_id=$this->input->post('cat_id');
		$created_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('mesurements',array('cat_id'=>$cat_id,'LOWER(title)'=>strtolower(trim($this->input->post('title')))))->num_rows();
			if($check==0){
				$data=array('cat_id'=>$cat_id,'title'=>trim($title),'status'=>1,'created_date'=>$created_date);
				$this->db->insert('mesurements',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Mesurement already added !..</strong></div>');
			}
			redirect('admin/measurements/');
	}
	public function delete_location($loc_id='')
	{
		$this->db->where('loc_id',$loc_id);
		$res=$this->db->delete('locations');
		if ($res==1)
			{
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Location deleted successfully.</strong></div>');
			  redirect('admin/locations/');
			}
			else
			{
			$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Location delete failed!</strong></div>');
				  redirect('admin/locations/');
			}
	}
	public function download($filename) {
    $this->load->helper('download');
    $data = file_get_contents(base_url('assets/members/'.$filename));
    force_download($filename, $data);
	}
	public function generate_password(){
		$user_id =$this->input->post('user_id');
		$length = 10;
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
		$str = '';
		$max = strlen($chars) - 1;
		for ($i=0; $i < $length; $i++)
		$str .= $chars[random_int(0, $max)];
		echo $str;
	}
	public function change_order_status($res='',$orderid='')
	{
		$updated_date =date("Y-m-d H:i:s");
		$arr1 = array('order_status'=>$res);
		if($res=='Processing'){
			$arr2 = array('order_date'=>$updated_date);
		}elseif($res=='Success'){
			$arr2 = array('order_succ_date'=>$updated_date);
		}elseif($res=='Failed'){
			$arr2 = array('order_failed_date'=>$updated_date);
		}elseif($res=='Cancelled'){
			$arr2 = array('order_cancelled_date'=>$updated_date);
		}else{
		    $arr2 = array('order_delivered_date'=>$updated_date);
		}
		$data = array_merge($arr1,$arr2);
		$this->db->where('order_id',$orderid);
		$status=$this->db->update('orders',$data);
	    if($status==1){
			$history =array(
				'order_id'=>$orderid,
				'order_status'=>$res,
				'change_date'=>$updated_date,
			);
			$status_history =$this->db->insert('order_status_history',$history);
			if($status_history==1){
                $this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Order status updated successfully.</strong></div>');
			}else{
                $this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Order status update failed!</strong></div>');
			}
            $this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Order status updated successfully.</strong></div>');
		}else{
            $this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Order status update failed!</strong></div>');
		}
		redirect('admin/orders/');
	}
	public function order_view($order_id=0){
	    $response['order']=$this->db->query("SELECT a.`order_id`,a.user_apartment_det_id, a.`payment_id`, a.`user_id`, a.`reference_id`, a.`order_amount`, a.`user_address_id`, a.`payment_mode`, a.`payment_status`, a.`order_date`, a.`order_succ_date`, a.`order_failed_date`, a.`order_cancelled_date`,b.name,b.email,b.phone,c.user_address_id,c.mobile_no,c.floor_no,c.block_no,c.appartment,c.address,c.pincode FROM `orders` a LEFT JOIN users b ON a.user_id=b.user_id LEFT JOIN order_user_address c ON a.order_id=c.order_id WHERE a.`order_id`=$order_id")->row_array();
	    if(empty($response['order'])){
	        redirect('admin/orders');
	    }
	    $response['products']=$this->db->query("SELECT `order_prod_id`, `order_id`, `user_id`, `qty`, `tot_amount`, `offer_amount`, `prod_id`, `prod_title`, `prod_category`,`prod_mesurements`,prod_mes_id FROM `order_products` WHERE `order_id`=$order_id")->result_array();
	    $this->load->view('admin/invoice',$response);
	}
	public function invoice($order_id=0){
	    $response['order']=$this->db->query("SELECT a.`order_id`,a.user_apartment_det_id, a.`payment_id`, a.`user_id`, a.`reference_id`, a.`order_amount`, a.`user_address_id`, a.`payment_mode`, a.`payment_status`, a.`order_date`, a.`order_succ_date`, a.`order_failed_date`, a.`order_cancelled_date`,b.name,b.email,b.phone,c.user_address_id,c.mobile_no,c.floor_no,c.block_no,c.appartment,c.address,c.pincode FROM `orders` a LEFT JOIN users b ON a.user_id=b.user_id LEFT JOIN order_user_address c ON a.order_id=c.order_id WHERE a.`order_id`=$order_id")->row_array();
	    if(empty($response['order'])){
	        redirect('admin/orders');
	    }else{
	        $payment_id = $response['order']['payment_id'];
	    }
	    $response['products']=$this->db->query("SELECT `order_prod_id`, `order_id`, `user_id`, `qty`, `tot_amount`, `offer_amount`, `prod_id`, `prod_title`, `prod_category`,`prod_mesurements`,prod_mes_id FROM `order_products` WHERE `order_id`=$order_id")->result_array();
	    $htmlcontent = $this->load->view('admin/invoice',$response,TRUE);
        $path='Invoice_'.$payment_id.".pdf";
        $this->load->library('M_pdf');
        $this->m_pdf->mpdf->WriteHTML($htmlcontent);
        $this->m_pdf->mpdf->Output($path, "D");
	}
	public function blocks()
	{
		checklogin_admin();
		$data['blocks']=$this->db->query("SELECT `t1`.*, `t2`.`apartment_id`, `t2`.`apartment_name` FROM `blocks` as `t1` LEFT JOIN `apartments` as `t2` ON `t1`.`apartment_id` = `t2`.`apartment_id`")->result_array();
		$data['active_menu']='blocks';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/blocks');
		$this->load->view('admin/footer');
	}
	public function add_block()
	{
		checklogin_admin();
		$data = array();
		$data['apartments']=$this->db->get_where('apartments',array('status'=>'1'))->result_array();
		$data['active_menu']='blocks';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_block');
		$this->load->view('admin/footer');
	}
	public function save_block()
	{
		checklogin_admin();
		$apartment_id=$this->input->post('apartment_id');
		$block_name=$this->input->post('block_name');
		$created_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('blocks',array('block_name'=>trim($this->input->post('block_name')),'apartment_id'=>trim($this->input->post('apartment_id'))))->num_rows();
			if($check==0){
				$data=array('apartment_id'=>$apartment_id,'block_name'=>$block_name,'status'=>1,'created_date'=>$created_date);
				$this->db->insert('blocks',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Block Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Block already added !..</strong></div>');
			}
			redirect('admin/blocks/');
	}
	public function edit_block($block_id='')
	{
		checklogin_admin();
		$data['apartments']=$this->db->get_where('apartments',array('status'=>'1'))->result_array();
        $data['block']=$this->db->get_where('blocks',array('block_id'=>$block_id))->row_array();		
		$data['active_menu']='blocks';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_block');
		$this->load->view('admin/footer');
	}
	public function update_block()
	{
		checklogin_admin();
		$apartment_id=$this->input->post('apartment_id');
		$block_name=$this->input->post('block_name');
		$updated_date =date("Y-m-d H:i:s");
		$block_id=$this->input->post('block_id');
		$check=$this->db->get_where('blocks',array('block_name'=>trim($this->input->post('block_name')),'apartment_id'=>trim($this->input->post('apartment_id')),'block_id!='=>$block_id))->num_rows();
		  if($check==0){
			$this->db->update('blocks',array('block_name'=>trim($this->input->post('block_name')),'apartment_id'=>trim($this->input->post('apartment_id')),'updated_date'=>$updated_date),array('block_id'=>$block_id));
			$this->session->set_flashdata('success','Block Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','Block already exists...');
		  }
		redirect('admin/blocks/');
		
	}
	public function apartments()
	{
		checklogin_admin();
		$data['apartments']=$this->db->query("SELECT * FROM `apartments`")->result_array();
		$data['active_menu']='apartments';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/apartments');
		$this->load->view('admin/footer');
	}
	public function add_apartment()
	{
		checklogin_admin();
		$data = array();
		$data['active_menu']='apartments';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_apartment');
		$this->load->view('admin/footer');
	}
	public function save_apartment()
	{
		checklogin_admin();
		$apartment_name=$this->input->post('apartment_name');
		$apartment_address=$this->input->post('apartment_address');
		$apartment_pincode=$this->input->post('apartment_pincode');
		$created_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('apartments',array('apartment_name'=>trim($this->input->post('apartment_name'))))->num_rows();
			if($check==0){
				$data=array('apartment_name'=>$apartment_name,'apartment_address'=>$apartment_address,'apartment_pincode'=>$apartment_pincode,'status'=>1,'created_date'=>$created_date);
				$this->db->insert('apartments',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Apartment Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Apartment already added !..</strong></div>');
			}
			redirect('admin/apartments/');
	}
	public function edit_apartment($apartment_id='')
	{
		checklogin_admin();
        $data['apartment']=$this->db->get_where('apartments',array('apartment_id'=>$apartment_id))->row_array();		
		$data['active_menu']='apartments';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_apartment');
		$this->load->view('admin/footer');
	}
	public function update_apartment()
	{
		checklogin_admin();
		$apartment_name=$this->input->post('apartment_name');
		$apartment_address=$this->input->post('apartment_address');
		$apartment_pincode=$this->input->post('apartment_pincode');
		$updated_date =date("Y-m-d H:i:s");
		$apartment_id=$this->input->post('apartment_id');
		$check=$this->db->get_where('apartments',array('apartment_name'=>trim($this->input->post('apartment_name')),'apartment_id!='=>$apartment_id))->num_rows();
		  if($check==0){
			$this->db->update('apartments',array('apartment_name'=>trim($this->input->post('apartment_name')),'apartment_address'=>trim($this->input->post('apartment_address')),'apartment_pincode'=>trim($this->input->post('apartment_pincode')),'updated_date'=>$updated_date),array('apartment_id'=>$apartment_id));
			$this->session->set_flashdata('success','Apartment Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','Apartment already exists...');
		  }
		redirect('admin/apartments/');
		
	}
	public function delete_apartment()
	{
		$apartment_id =$this->input->post('apartment_id');
		$this->db->where('apartment_id',$apartment_id);
		$res=$this->db->delete('apartments');
		if ($res==1)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	public function flats()
	{
		checklogin_admin();
		$data['flats']=$this->db->query("SELECT `t1`.*, `t2`.`block_id`, `t2`.`block_name`, `t3`.`apartment_id`, `t3`.`apartment_name` FROM `flats` as `t1` LEFT JOIN `blocks` as `t2` ON `t1`.`block_id` = `t2`.`block_id` LEFT JOIN `apartments` as `t3` ON `t1`.`apartment_id` = `t3`.`apartment_id`")->result_array();
		$data['active_menu']='flats';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/flats');
		$this->load->view('admin/footer');
	}
	public function add_flat()
	{
		checklogin_admin();
		$data = array();
		$data['apartments']=$this->db->get_where('apartments',array('status'=>'1'))->result_array();
		$data['blocks']=$this->db->get_where('blocks',array('status'=>'1'))->result_array();
		// $data['flats']=$this->db->get_where('flats',array('status'=>'1'))->result_array();
		$data['active_menu']='flats';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_flat');
		$this->load->view('admin/footer');
	}
	public function save_flat()
	{
		checklogin_admin();
		$apartment_id=$this->input->post('apartment_id');
		$block_id=$this->input->post('block_id');
		$flat_name=$this->input->post('flat_name');
		$created_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('flats',array('flat_name'=>trim($this->input->post('flat_name')),'apartment_id'=>trim($this->input->post('apartment_id')),'block_id'=>trim($this->input->post('block_id'))))->num_rows();
			if($check==0){
				$data=array('apartment_id'=>$apartment_id,'block_id'=>$block_id,'flat_name'=>$flat_name,'status'=>1,'created_date'=>$created_date);
				$this->db->insert('flats',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Flat Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Flat already added !..</strong></div>');
			}
			redirect('admin/flats/');
	}
	public function edit_flat($flat_id='')
	{
		checklogin_admin();
		$data['apartments']=$this->db->get_where('apartments',array('status'=>'1'))->result_array();
        $data['blocks']=$this->db->get_where('blocks',array('status'=>'1'))->result_array();
        // print_r($data['blocks']);exit;
        $data['flat']=$this->db->get_where('flats',array('flat_id'=>$flat_id))->row_array();	
        // print_r($data['flat']);exit;	
		$data['active_menu']='flats';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_flat');
		$this->load->view('admin/footer');
	}
	public function update_flat()
	{
		checklogin_admin();
		$flat_id=$this->input->post('flat_id');
		$apartment_id=$this->input->post('apartment_id');
		$block_id=$this->input->post('block_id');
		$flat_name=$this->input->post('flat_name');
		$updated_date =date("Y-m-d H:i:s");
		$block_id=$this->input->post('block_id');
		$check=$this->db->get_where('flats',array('apartment_id'=>trim($this->input->post('apartment_id')),'block_id'=>trim($this->input->post('block_id')),'flat_name'=>trim($this->input->post('flat_name')),'flat_id!='=>$flat_id))->num_rows();
		  if($check==0){
			$this->db->update('flats',array('apartment_id'=>trim($this->input->post('apartment_id')),'block_id'=>trim($this->input->post('block_id')),'flat_name'=>trim($this->input->post('flat_name')),'updated_date'=>$updated_date),array('flat_id'=>$flat_id));
			$this->session->set_flashdata('success','Flat Updated successfully..');
		 }else{
			$this->session->set_flashdata('failed','Flat already exists...');
		  }
		redirect('admin/flats/');
		
	}
  public function getproduct_lists(){ 
    $postData = $this->input->post();
    // $this->load->model('login_model');
    $data = $this->loginmodel->getCityDepartment($postData);
    // print_r($data);exit;
    echo json_encode($data); 
  }
  public function barcode_download($id=0){
        $filename=$this->db->query("SELECT `qr_code`,`title` FROM `scan_prods` WHERE `scanner_id`=$id")->row_array();
        $fname ='assets/qrcodes/'.$filename['qr_code'];
        $this->load->helper('download');
        $data = file_get_contents(base_url($fname));
        $download_file_name=str_preg_replace($filename['title']).'.png';
        force_download($download_file_name, $data);
  }
  public function removemes(){
	  $wh=$this->input->post();
	  $products=$this->db->select('prod_id')->get_where('product_mesurments',$wh)->row_array();
	  $del=$this->db->delete('product_mesurments',$wh);
	  if($del>0){
		$prod_id = $products['prod_id'];
		$ms = $this->common_model->GetProdMes($prod_id);
		if(count($ms)>0){
			$prod_mesurements = json_encode($ms);
			$up = array('prod_mesurements'=>$prod_mesurements);
			$this->common_model->commonUpdate('products',$up,array('prod_id'=>$prod_id));
		}
	  }
  }
  public function Get_Sub_Cat(){
	$catid = $this->input->post('id');
	$sub_cat_id = $this->db->query("SELECT `sub_cat_id`,`cat_id`,`title` FROM `sub_categories` WHERE `status`=1 AND cat_id=$catid")->result_array();
	$op='<option value="">Select</option>';
	if(count($sub_cat_id)>0){
		foreach($sub_cat_id as $v){
			$op .= '<option value="'.$v['sub_cat_id'].'">'.$v['title'].'</option>';
		}
	}
	echo $op;
  }
  public function Add_SubCats_To_Main_Cat($cat_id){
	$Sub_Cat_Res = $this->db->query("SELECT `sub_cat_id`, `cat_id`, `title`, `icon`, `status`, `created_date`, `updated_date`, `is_brands_available`, `brands` FROM `sub_categories` WHERE `cat_id`=$cat_id")->result_array();
	if(count($Sub_Cat_Res)>0){
		$Enc_Dta = json_encode($Sub_Cat_Res);
		$this->db->update('categories',array('categories'=>$Enc_Dta),array('cat_id'=>$cat_id));
	}
  }
  public function subscription_cancell_reason(){
	checklogin_admin();
	$admin_id=$this->session->userdata('admin_id');
	$data['subscription_cancell_reason']=$this->db->query("SELECT `id`, `reason`, `is_active`, `created_date` FROM `subscription_cancell_reason`")->result_array();
	$data['active_menu']='subscription_cancell_reason';
	$this->load->view('admin/menu',$data);
	$this->load->view('admin/subscription_cancell_reason');
	$this->load->view('admin/footer');
  }
  public function add_subscription_cancell_reason(){
		checklogin_admin();
		$data = array();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='subscription_cancell_reason';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_subscription_cancell_reason');
		$this->load->view('admin/footer');
 }
 public function save_subscription_cancell_reason(){
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$reason=trim($this->input->post('reason'));
		$created_date =date("Y-m-d H:i:s");

		$check=$this->db->get_where('subscription_cancell_reason',array('reason'=>trim($this->input->post('reason'))))->num_rows();
			if($check==0){
				$data=array('reason'=>trim($reason),'is_active'=>1,'created_date'=>$created_date);
				$res =$this->db->insert('subscription_cancell_reason',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Subscription cancell reason Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Subscription cancell reason already added !..</strong></div>');
			}
			redirect('admin/subscription_cancell_reason/');
	}
  public function change_subscription_cancell_reason_status($docid='',$sta='')
	{
		$data = array('is_active'=>$sta);
		$this->db->where('id',$docid);
		$res=$this->db->update('subscription_cancell_reason',$data);
		if ($res==1)
					{
						$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Subscription cancell reason status updated successfully.</strong></div>');
						  redirect('admin/subscription_cancell_reason');
					}
					else
					{
					$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Subscription cancell reason status update failed!</strong></div>');
						  redirect('admin/subscription_cancell_reason');
					}
	}
	public function edit_subscription_cancell_reason($id='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['subscription_cancell_reason']=$this->db->get_where('subscription_cancell_reason',array('id'=>$id))->result_array();		
		$data['active_menu']='subscription_cancell_reason';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_subscription_cancell_reason');
		$this->load->view('admin/footer');
	}
	public function update_subscription_cancell_reason()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$reason=$this->input->post('reason');
		$id=$this->input->post('id');
		$updated_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('subscription_cancell_reason',array('reason'=>trim($this->input->post('reason')),'id!='=>$id))->num_rows();
		if($check==0){
			$this->db->update('subscription_cancell_reason',array('reason'=>trim($this->input->post('reason')),'updated_date'=>$updated_date),array('id'=>$id));
			$this->session->set_flashdata('success','Reason Updated successfully..');
		}else{
			$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Subscription cancell reason already existed !..</strong></div>');
		}
		redirect('admin/subscription_cancell_reason/');
	}
	public function delivery_slots(){
	checklogin_admin();
	$admin_id=$this->session->userdata('admin_id');
	$data['delivery_slots']=$this->db->query("SELECT `id`, `slot_from`, `slot_to`, `time_in_seconds`, `is_active`, `created_date`, `updated_date` FROM `delivery_slots`")->result_array();
	$data['active_menu']='delivery_slots';
	$this->load->view('admin/menu',$data);
	$this->load->view('admin/delivery_slots');
	$this->load->view('admin/footer');
  }
  public function add_delivery_slots(){
		checklogin_admin();
		$data = array();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='delivery_slots';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_delivery_slots');
		$this->load->view('admin/footer');
 }
 public function save_delivery_slots(){
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$slot_from=$this->input->post('slot_from');
		$slot_to=$this->input->post('slot_to');
		$time_in_24_hour_format  = date("H:i:s", strtotime($slot_from));
		$time_in_seconds =$time_in_24_hour_format*3600/1+0*60/1+0;
		// echo $time_in_seconds;exit;
		$created_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('delivery_slots',array('slot_from'=>trim($this->input->post('slot_from')),'slot_to'=>trim($this->input->post('slot_to'))))->num_rows();
		if($check==0){
			$data=array('slot_from'=>trim($slot_from),'slot_to'=>trim($slot_to),'time_in_seconds'=>trim($time_in_seconds),'is_active'=>1,'created_date'=>$created_date);
			$this->db->insert('delivery_slots',$data);
			$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Delivery Slots Added successfully</strong></div>');
		}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Delivery Slots Added !..</strong></div>');
			}
			redirect('admin/delivery_slots/');
	}
  public function change_delivery_slots_status($docid='',$sta='')
	{
		$data = array('is_active'=>$sta);
		$this->db->where('id',$docid);
		$res=$this->db->update('delivery_slots',$data);
		if ($res==1)
					{
						$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Delivery Slots status updated successfully.</strong></div>');
						  redirect('admin/delivery_slots');
					}
					else
					{
					$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Delivery Slots status update failed!</strong></div>');
						  redirect('admin/delivery_slots');
					}
	}
	public function edit_delivery_slots($id='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['delivery_slots']=$this->db->get_where('delivery_slots',array('id'=>$id))->result_array();
		$data['active_menu']='delivery_slots';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_delivery_slots');
		$this->load->view('admin/footer');
	}
	public function update_delivery_slots()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$slot_from=$this->input->post('slot_from');
		$slot_to=$this->input->post('slot_to');
		$time_in_24_hour_format  = date("H:i:s", strtotime($slot_from));
		$time_in_seconds =$time_in_24_hour_format*3600/1+0*60/1+0;
		$id=$this->input->post('id');
		$updated_date =date("Y-m-d H:i:s");
		$check=$this->db->get_where('delivery_slots',array('slot_from'=>trim($this->input->post('slot_from')),'slot_to'=>trim($this->input->post('slot_to')),'id!='=>$id))->num_rows();
		// echo $time_in_seconds;exit;
		// echo $this->db->last_query();exit;
		if($check==0){
			$res =$this->db->update('delivery_slots',array('slot_from'=>$slot_from,'slot_to'=>$slot_to,'time_in_seconds'=>$time_in_seconds,'updated_date'=>$updated_date),array('id'=>$id));
			$this->session->set_flashdata('success','Delivery Slots Updated successfully..');
		}else{
			$this->session->set_flashdata('failed','Delivery Slots Updating failed...');
		  }
		redirect('admin/delivery_slots/');
	}
	public function coupons()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['coupons']=$this->db->query("SELECT `id`, `name`, `code`, `description`, `type`, `discount`, `image`, `max_use`, `start_date`, `end_date`, `use_count`, `status`, `use_for`, `created_at`, `updated_at`, `deleted_at` FROM `coupon`")->result_array();
		$data['active_menu']='coupons';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/coupons');
		$this->load->view('admin/footer');
	}
	public function coupon_users($coupon_id='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$data['coupon_users']=$this->db->query("SELECT `id`,`use_for` FROM `coupon` WHERE `id`=$coupon_id")->row_array();
		// echo "<pre>";print_r($data['coupons']);exit;
		$data['active_menu']='coupons';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/coupon_users');
		$this->load->view('admin/footer');
	}
	public function add_coupons()
	{
		checklogin_admin();
		$data = array();
		$admin_id=$this->session->userdata('admin_id');
		$data['active_menu']='coupons';
		$data['category']=$this->db->query("SELECT * FROM `coupon`")->result_array();
		$data['users']=$this->db->query("SELECT `user_id`, `name` FROM `users` WHERE `status`=1")->result_array();
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/add_coupons');
		$this->load->view('admin/footer');
	}
	public function save_coupons()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$name=$this->input->post('name');
		$code=strtoupper(trim($this->input->post('code')));
		$description=$this->input->post('description');
		$type=$this->input->post('type');
		$discount=$this->input->post('discount');
		$max_use=$this->input->post('max_use');
		$start_date= date("Y-m-d", strtotime($this->input->post('start_date')));
		$end_date=date("Y-m-d", strtotime($this->input->post('end_date')));
		$use_for1=$this->input->post('use_for[]');
		$use_for =implode(",",$use_for1);
		// echo "<pre>";print_r($use_for);exit;
		$created_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if (!file_exists('assets/coupon_images')) {
			mkdir('assets/coupon_images', 0777, true);
		}
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/coupon_images';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = '*';
				$config['overwrite']=true;
				$this->upload->initialize($config);
				 if(!$this->upload->do_upload('simage'))
					{
						//print_r($this->upload->display_errors()); exit;
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image</strong></div>');
						 redirect('admin/coupons');
					}
					else
					{
						$imagename=$imagename;
					}
			}
			// echo $imagename;exit;
		$check=$this->db->get_where('coupon',array('code'=>str_replace(' ', '', $code)))->num_rows();
			if($check==0){
				$data=array('name'=>$name,'code'=>str_replace(' ', '', $code),'description'=>$description,'type'=>$type,'discount'=>$discount,'image'=>$imagename,'max_use'=>$max_use,'start_date'=>$start_date,'end_date'=>$end_date,'use_for'=>$use_for,'status'=>1,
					'created_at'=>$created_date);
			// echo "<pre>";print_r($use_for);exit;
				$this->db->insert('coupon',$data);
				$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Coupon Added successfully</strong></div>');
			}else{
				$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>This Coupon already added !..</strong></div>');
			}
			redirect('admin/coupons/');
	}
	public function change_coupons_status($docid='',$sta='')
	{
		$data = array('status'=>$sta);
		$this->db->where('id',$docid);
		$res=$this->db->update('coupon',$data);
		if ($res==1)
					{
						$this->session->set_flashdata('success','<div class="alert alert-success msgfade"><strong>Coupon status updated successfully.</strong></div>');
						  redirect('admin/coupons');
					}
					else
					{
					$this->session->set_flashdata('failed','<div class="alert alert-warning msgfade"><strong>Coupon status update failed!</strong></div>');
						  redirect('admin/coupons');
					}
	}
	public function edit_coupons($id='')
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
        $data['coupons']=$this->db->get_where('coupon',array('id'=>$id))->row_array();
        $data['users']=$this->db->query("SELECT `user_id`, `name` FROM `users` WHERE `status`=1")->result_array();
        $users =str_replace(array( '[', ']' ), '', $data['coupons']['use_for']);
        $data['p_users']=explode(",",$users);
        // echo "<pre>";print_r($data['p_users']);exit;
		$data['active_menu']='coupons';
		$this->load->view('admin/menu',$data);
		$this->load->view('admin/edit_coupons');
		$this->load->view('admin/footer');
	}
	public function update_coupons()
	{
		checklogin_admin();
		$admin_id=$this->session->userdata('admin_id');
		$id=$this->input->post('id');
		$oldpic=$this->input->post('oldpic');
		$name=$this->input->post('name');
		$code=strtoupper(trim($this->input->post('code')));
		$description=$this->input->post('description');
		$type=$this->input->post('type');
		$discount=$this->input->post('discount');
		$max_use=$this->input->post('max_use');
		$start_date= date("Y-m-d", strtotime($this->input->post('start_date')));
		$end_date=date("Y-m-d", strtotime($this->input->post('end_date')));
		$use_for=$this->input->post('use_for');
		$updated_date =date("Y-m-d H:i:s");
		$file='';
		$imagename='';
		if($_FILES['simage']['name'] !='')
			{
                $file=str_replace(" ","_",$_FILES['simage']['name']);
				$imagename=time().$file;
				$this->load->library('upload');
				$config['upload_path'] = 'assets/coupon_images';
				$config['file_name'] = $imagename;
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite']=true;
				$this->upload->initialize($config);

				 if(!$this->upload->do_upload('simage'))
					{
						$this->session->set_flashdata('failed','<div class="alert alert-danger msgfade"><strong>Please upload image only</strong></div>');
						 redirect('admin/coupons');
					}
					else
					{
						
							$imagename=$imagename;
					}
					}else
					{
						$imagename=$oldpic;
					}
			 $check=$this->db->get_where('coupon',array('code' => str_replace(' ', '', $code),'id!='=>$id))->num_rows();
			  if($check==0){
				$this->db->update('coupon',array('name'=>$name,'code'=>str_replace(' ', '', $code),'description'=>$description,'type'=>$type,'discount'=>$discount,'image'=>$imagename,'max_use'=>$max_use,'start_date'=>$start_date,'end_date'=>$end_date,'use_for'=>$use_for,'status'=>1,'updated_at'=>$updated_date),array('id'=>$id));
				$this->session->set_flashdata('success','Coupon Updated successfully..');
			 }else{
				$this->session->set_flashdata('failed','This Coupon Already existed...');
			  }
			redirect('admin/coupons/');
		
	}
	public function get_offer_banner_modles()
	{
		$val =$this->input->post('sel_value');
		if($val=='home'){
			// $result_data = array();
			$result_data[0]['title'] ="products";
			$result_data[0]['cat_id'] ="products";
			$result_data[1]['title'] ="deal";
			$result_data[1]['cat_id'] ="deal";
			$result_data[2]['title'] ="best";
			$result_data[2]['cat_id'] ="best";
			$result_data[3]['title'] ="subc";
			$result_data[3]['cat_id'] ="subc";
			$result_data[4]['title'] ="offer";
			$result_data[4]['cat_id'] ="offer";
			echo json_encode($result_data);
		}else{
			$this->db->select('cat_id,title');
	        $result_data = $this->db->get('categories')->result_array();
	        echo json_encode($result_data);
		}
	}
	public function Get_Prod_Mes(){
		$prod_id = $this->input->post('prod_id');
		$id = $this->input->post('id');
		$mes = $this->db->query("SELECT a.`id` prod_mes_id, b.title,a.`prod_org_price`,a.`prod_offered_price` FROM `product_mesurments` a INNER JOIN mesurements b ON a.`mes_id`=b.mes_id WHERE a.`prod_id`=$prod_id")->result_array();
		//$prodmesdata='<option value="">Select</option>';
		$prodmesdata='';
		if(count($mes)>0){
			foreach($mes as $ms){
				$prodmesdata .='<option value="'.$ms['prod_mes_id'].'">'.$ms['title'].'</option>';
			}
		}
		// if($this->session->userdata('prods')!=''){
		// 	$all = $this->session->userdata('prods');
		// 	$ids = array_unique($all);
		// 	if(in_array($prod_id,$ids)){
		// 	}else{
		// 		$prods = array_push($ids,$prod_id);
		// 	}
		// }else{
		// 	$prods[]=$prod_id;
		// }
		// $this->session->set_userdata('prods',$prods);
		echo $prodmesdata;exit;
	}
	public function all_product_mes(){
		$id = $this->input->post('id');
		// if($this->session->userdata('prods')!=''){
		// 	$all = $this->session->userdata('prods');
		// 	if(!empty($all)){
		// 		$all = implode(',',$all);
		// 	}
		// }else{
		// 	$all = $id;
		// }
		$data['prods'] = $this->db->query("SELECT `prod_id`,`prod_title` FROM `products` WHERE `prod_status`=1")->result_array();
		$data['sno']=$id+1;
		$data['mes']=array();
		$data['type']=1;
		echo $this->load->view('admin/prod_combo',$data,TRUE);exit;
	}
}