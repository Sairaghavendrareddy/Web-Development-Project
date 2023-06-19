<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('loginmodel');
	}
	public function index(){
		$this->load->view('login_view');
	}
	public function check_login()
	{ 
		if($this->input->post('username') !=''){
		   		$res=$this->loginmodel->check_login($this->input->post('username'),md5($this->input->post('password')));
	           if($res !=0){
					  redirect('admin/dashboard');
				}else{
						$this->session->set_flashdata('msg',"Your username or password is incorrect...");
					         redirect('master');
				}
			}else{
				$this->session->set_flashdata('msg',"Your username or password is incorrect");
				redirect('master');
			}
	}
	public function reset_password(){
		$this->load->view('reset_password');
	}
	public function forgot_password()
	{
		$name=trim($this->input->post('name'));
		$length = 10;
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.
            '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';
		$password = '';
		$max = strlen($chars) - 1;
		for ($i=0; $i < $length; $i++)
		$password .= $chars[random_int(0, $max)];
		$chk=$this->db->query("SELECT `t1`.* FROM `admin_login` as `t1` WHERE (`t1`.`email` = '$name' OR `t1`.`username` = '$name')")->num_rows();
		if(($chk)>0){
		$data1['result']=$this->db->query("SELECT `t1`.* FROM `admin_login` as `t1` WHERE (`t1`.`email` = '$name' OR `t1`.`username` = '$name')")->row_array();
		$id =$data1['result']['admin_id'];
		$username =$data1['result']['username'];
		$email =$data1['result']['email'];
		 $data = array('password' =>md5($password));
        $this->db->where('admin_id',$id);
         $res=$this->db->update('admin_login',$data);
		if($res==1){
		$this->load->library('email');
        $html_content3="Hi <b>".$username. "</b><br>Please use login to this password " .$password."</b>";
        $this->email->set_mailtype("html");
        $this->email->from('raghavendra@demo.com');
        $this->email->to($email);
        $this->email->subject('Soilson- Forgot Password');
        $this->email->message($html_content3);
        if($this->email->send()){
           $this->session->set_flashdata('msg','Password sent to your email id successfully.');
           	  redirect('master');
            }else{
            $this->session->set_flashdata('msg','Opps! something went to wrong');
              redirect('master/reset_password');
          }	
      }else{
      	 $this->session->set_flashdata('msg','Opps! something went to wrong');
         redirect('master/reset_password');
      }
		
     }else{
     	$this->session->set_flashdata('msg','Entered wrong username or email id');
         redirect('master/reset_password');
     }
	}
	}