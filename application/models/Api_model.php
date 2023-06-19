<?php
class Api_model extends CI_Model {
	public function Get_Invoice_Id(){
		return '#'.(rand(10,100));
	}
	public function Get_Order_Id(){
		$length=8;
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	public function Get_Otp(){
		return (rand(10,100));
	}
	public function Gate_Pass_Ids($id=''){
		$pass = substr(str_shuffle("0123456789"), 0, 4);
		if($pass!=''){
			$check = $this->db->query("SELECT id FROM `ams_gatepass_generate` WHERE `pass`='$pass'")->num_rows();
			if($check==0){
				$this->db->insert('ams_gatepass_generate',array('pass'=>$pass));
				return $pass;
			}else{
				$this->Gate_Pass_Ids($id);
			}
		}else{
			$this->Gate_Pass_Ids($id);
		}
	}
	public function commonInsert($tableName, $arrayData){
        $this->db->insert($tableName, $arrayData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
	public function commonUpdate($tableName, $updateArray, $whereCondition){
        $this->db->where($whereCondition);
        return $this->db->update($tableName, $updateArray);
    }
	public function commonDelete($tableName, $whereCondition){
        return $this->db->delete($tableName, $whereCondition);
    }
	public function commonGet($tablename, $fields, $where, $type){
        $res = $this->db->select($fields)->from($tablename);
        if ($where != '' OR $where != NULL) {
            $this->db->where($where);
        }
        if ($type == "all") {
            return $this->db->get()->result_array();
        }else{
            return $this->db->get()->row_array();
        }
    }
	public function commonCheck($tablename, $fields, $where){
        return $this->db->select($fields)->get_where($tablename,$where)->num_rows();
    }
	public function get_all_staff_categories($appartment_id){
		return $this->db->query("SELECT a.`id`, a.`appartment_id`, a.`title`,(SELECT COUNT(id) FROM `ams_staff_details` WHERE `staff_category_id`=a.id) as `total`, a.`created_date`, a.`is_active` FROM `ams_staff_categories` a WHERE a.`appartment_id`=$appartment_id")->result_array();
	}
	public function staff_list_with_category($appartment_id,$staff_category_id){
		return $this->db->select("`id`, `staff_name`, `phonenumber`, `appartment_id`, `staff_category_id`, `profile_pic`, `created_date`, `is_active`, `houses_count`, `rating`, `salary`, `gate_pass_id`, `very_punctual_revire`, `quite_regular_review`, `exceptional_servde_review`, `grate_attitude_review`")->get_where('ams_staff_details',array('staff_category_id'=>$staff_category_id,'appartment_id'=>$appartment_id,'is_active'=>'1'))->result_array();
	}
	public function staff_details($appartment_id,$staff_category_id,$staff_id){
		return $this->db->select('`id`, `staff_name`, `phonenumber`, `appartment_id`, `staff_category_id`, `profile_pic`, `created_date`, `is_active`, `houses_count`, `rating`, `salary`,gate_pass_id,very_punctual_revire,quite_regular_review,exceptional_servde_review,grate_attitude_review,review_users_count')->get_where('ams_staff_details',array('staff_category_id'=>$staff_category_id,'appartment_id'=>$appartment_id,'id'=>$staff_id))->result_array();
	}
	public function add_staff_to_member($member_id,$staff_id,$apartment_id){
		$data=array('member_id'=>$member_id,'staff_id'=>$staff_id,'apartment_id'=>$apartment_id);
		return $this->db->insert('ams_staff_working_details',$data);
	}
	public function Get_relations(){
		return $this->db->select('`id`,`title`,`is_active`')->get('ams_member_relations')->result_array();
	}
	public function check_fm_member_exist($member_id,$name,$gender){
		return $this->db->select('id')->get_where('ams_family_members',array('member_id'=>$member_id,'name'=>$name,'gender'=>$gender))->num_rows();
	}
	public function Get_all_groups($app_id){
		$que=$this->db->query("SELECT a.`id` as group_id, a.`apartment_id`, a.`member_id`, a.`group_name`, a.`created_date`, a.`is_active`,(SELECT COUNT(b.`id`) FROM `ams_group_topics` b WHERE b.`apartment_id`=a.`apartment_id`) as topics_count,(SELECT COUNT(id) FROM `ams_group_members` WHERE `group_id`=a.id) members_count FROM `ams_groups` a WHERE a.`apartment_id`=".$app_id)->result_array();
		return $que;
	}
	public function Get_my_groups($apartment_id,$member_id){
		//$que=$this->db->query("SELECT a.`id` as group_id, a.`apartment_id`, a.`member_id`, a.`group_name`,a.description, a.`created_date`, a.`is_active`,(SELECT COUNT(b.`id`) FROM `ams_group_topics` b WHERE b.`apartment_id`=a.`apartment_id` AND b.`member_id`='$member_id') as topics_count,(SELECT COUNT(id) FROM `ams_group_members` WHERE `group_id`=a.id AND `is_active`='1') members_count FROM `ams_groups` a WHERE a.`apartment_id`='$apartment_id' AND a.member_id='$member_id' AND a.`is_active`='1'")->result_array();
		 $que=$this->db->query("SELECT COUNT(b.`id`) as memberscount, b.group_id,a.*,COUNT(c.`id`) as topics_count FROM `ams_group_members` b INNER JOIN `ams_groups` a ON a.id=b.group_id LEFT JOIN `ams_group_topics` c ON a.id=c.group_id WHERE b.`is_active`='1' AND a.member_id='$member_id' AND b.apartment_id='$apartment_id' GROUP BY b.`group_id`")->result_array();
		
		return $que;
	}
	public function Get_All_Topics($group_id){
		$this->db->select('a.`id` as topic_id,c.group_name, a.`apartment_id`,a.group_id, a.`member_id`, a.`subject`, a.`description`, a.`image`, a.`created_date` as topic_created_date,b.`member_name`,b.`username`,b.`email`,b.`mobile_number`,b.`profile_pic`,block.block_name as `block_no`,flat.flat_number as `flat_no`,(SELECT COUNT(id) FROM `ams_group_topic_messages` WHERE `apartment_id`=a.`apartment_id` AND `member_id`=a.`member_id` AND `group_id`= a.`group_id` AND `topic_id`= a.`id`) as messages_count',FALSE);
		$this->db->from('ams_group_topics a');
		$this->db->join('ams_members b','a.member_id=b.user_id');
		$this->db->join('ams_groups c','a.group_id=c.id');
		$this->db->join('ams_flats flat','b.`flat_no`=flat.id');
		$this->db->join('ams_blocks block','b.`block_no`=block.id','left');
		$this->db->where(array('a.group_id'=>$group_id));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_Single_Topics($topic_id){
		$this->db->select('a.`id` as topic_id,c.group_name, a.`apartment_id`,a.group_id, a.`member_id`, a.`subject`, a.`description`, a.`image`, a.`created_date` as topic_created_date,b.`member_name`,b.`username`,b.`email`,b.`mobile_number`,b.`profile_pic`,block.block_name as `block_no`,flat.flat_number as `flat_no`,(SELECT COUNT(id) FROM `ams_group_topic_messages` WHERE `apartment_id`=a.`apartment_id` AND `member_id`=a.`member_id` AND `group_id`= a.`group_id` AND `topic_id`= a.`id`) as messages_count',FALSE);
		$this->db->from('ams_group_topics a');
		$this->db->join('ams_members b','a.member_id=b.user_id');
		$this->db->join('ams_groups c','a.group_id=c.id');
		$this->db->join('ams_flats flat','b.`flat_no`=flat.id');
		$this->db->join('ams_blocks block','b.`block_no`=block.id','left');
		$this->db->where(array('a.id'=>$topic_id));
		$res=$this->db->get()->row_array();
		return $res;
	}
	public function Get_All_Topic_Messages($topic_id){
		$this->db->select('a.topic_id,c.group_name, a.`apartment_id`,a.group_id, a.`member_id`, a.`message`,d.`subject`,d.`description`, a.`image`, a.`created_date` as message_date,b.`member_name`,b.`username`,b.`email`,b.`mobile_number`,b.`profile_pic`,block.block_name as block_no,flat.flat_number as flat_no',FALSE);
		$this->db->from('ams_group_topic_messages a');
		$this->db->join('ams_members b','a.member_id=b.user_id');
		$this->db->join('ams_groups c','a.group_id=c.id');
		$this->db->join('ams_group_topics d','a.topic_id=d.id');
		$this->db->join('ams_flats flat','b.`flat_no`=flat.id');
		$this->db->join('ams_blocks block','b.`block_no`=block.id','left');
		$this->db->where(array('a.topic_id'=>$topic_id));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Security_alerts($data){
		$this->db->select('a.`id` security_alert_id, a.`apartment_id`, a.`member_id`, a.`security_cat_id`, a.`created_date`, a.`message`,a.security_category',FALSE);
		$this->db->from('ams_member_security_alerts a');
		//$this->db->join('ams_security_alert_categories b','a.security_cat_id=b.id');
		$this->db->where(array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id']));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Cab_Once_Services($data){
		if(isset($data['member_id']) && $data['member_id']!=''){
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id']);
		}else{
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.added'=>0);
		}
		$this->db->select('"cab" as tab,a.`id`,b.image as company_image,a.end_date, a.`apartment_id`, a.`member_id`, a.`type`, e.next_in_hrs as `next_in_hours`, b.title as `company_name`, a.`last_four_digits`, a.`select_date`, a.`start_time`, a.`end_time`,a.days_of_week,a.validity_days, a.`created_date`',FALSE);
		$this->db->from('ams_once_member_cab_services a');
		$this->db->join('ams_company_services b','a.company_name=b.id AND b.type="cab"','left');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND c.type="cab" AND c.once_or_frequently="once"');
		//$this->db->join('ams_service_start_times d','a.valid_for_next=d.id AND d.type="cab" AND d.once_or_frequently="once"');
		$this->db->join('ams_next_in_hrs_services e','a.next_in_hours=e.id','left');
		$this->db->where($wh);
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Delivery_Once_Services($data){
		if(isset($data['member_id']) && $data['member_id']!=''){
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id']);
		}else{
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.added'=>0);
		}
		$this->db->select('"delivery" as tab,a.`id`,b.image as company_image, a.end_date,a.`apartment_id`, a.`member_id`, a.`type`, e.next_in_hrs as `next_in_hours`, b.title as `company_name`, a.`last_four_digits`, a.`select_date`, a.`start_time`, a.`end_time`,a.days_of_week,a.validity_days, a.`created_date`',FALSE);
		$this->db->from('ams_once_member_delivery_services a');
		$this->db->join('ams_company_services b','a.company_name=b.id AND b.type="delivery"','left');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND c.type="delivery" AND c.once_or_frequently="once"');
		//$this->db->join('ams_service_start_times d','a.valid_for_next=d.id AND d.type="delivery" AND d.once_or_frequently="once"');
		$this->db->join('ams_next_in_hrs_services e','a.next_in_hours=e.id','left');
		$this->db->where($wh);
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Guest_Once_Services($data){
		if(isset($data['member_id']) && $data['member_id']!=''){
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id']);
		}else{
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.added'=>0);
		}
		$this->db->select('"guest" as tab,a.`id`,a.end_date, a.`apartment_id`, a.`member_id`, a.`type`, a.`username`, a.`phonenumber`, a.`select_date`, a.`start_time`,a.`end_time`, a.`created_date`,a.gate_pass_id,a.days_of_week',FALSE);
		$this->db->from('ams_once_member_guest_services a');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND a.type="guest" AND c.once_or_frequently="once"');
		//$this->db->join('ams_service_start_times d','a.end_time=d.id AND a.type="guest" AND d.once_or_frequently="once"');
		$this->db->where($wh);
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Visiting_help_Once_Services($data){
		if(isset($data['member_id']) && $data['member_id']!=''){
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id']);
		}else{
			$wh=array('a.apartment_id'=>$data['apartment_id'],'a.added'=>0);
		}
		$this->db->select('"visiting_help" as tab,a.`id`,b.image as company_image,a.end_date,a.`apartment_id`, a.`member_id`, a.`type`, e.next_in_hrs as `next_in_hours`, b.title as `company_name`, a.`category_name`, a.`select_date`, a.`start_time`, a.`end_time`,a.days_of_week,a.validity_days, a.`created_date`',FALSE);
		$this->db->from('ams_once_member_visiting_help_services a');
		$this->db->join('ams_company_services b','a.company_name=b.id AND b.type="visiting_help"','left');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND type="visiting_help" AND c.once_or_frequently="once"');
		//$this->db->join('ams_service_start_times d','a.valid_for_next=d.id AND type="visiting_help"  AND d.once_or_frequently="once"');
		$this->db->join('ams_next_in_hrs_services e','a.next_in_hours=e.id','left');
		$this->db->where($wh);
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Cab_frequntly_Services($data){
		$this->db->select('a.`id`, a.`apartment_id`, a.`member_id`, a.`type`, e.next_in_hrs as `next_in_hours`, b.title as `company_name`, a.`last_four_digits`, a.`select_date`, a.`start_time`,a.`end_time`,a.days_of_week,a.validity_days,a.`created_date`',FALSE);
		$this->db->from('ams_once_member_cab_services a');
		$this->db->join('ams_company_services b','a.company_name=b.id AND b.type="cab"');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND c.type="cab" AND c.once_or_frequently="frequently"');
		//$this->db->join('ams_service_start_times d','a.valid_for_next=d.id AND d.type="cab" AND c.once_or_frequently="frequently"');
		$this->db->join('ams_next_in_hrs_services e','a.next_in_hours=e.id','left');
		$this->db->where(array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id'],'a.type'=>'frequently'));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Delivery_frequntly_Services($data){
		$this->db->select('a.`id`, a.`apartment_id`, a.`member_id`, a.`type`, e.next_in_hrs as `next_in_hours`, b.title as `company_name`, a.`last_four_digits`, a.`select_date`, a.`start_time`, a.`end_time`,a.days_of_week,a.validity_days, a.`created_date`',FALSE);
		$this->db->from('ams_once_member_delivery_services a');
		$this->db->join('ams_company_services b','a.company_name=b.id AND b.type="delivery"');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND type="delivery" AND c.once_or_frequently="frequently"');
		//$this->db->join('ams_service_start_times d','a.valid_for_next=d.id AND type="delivery"  AND d.once_or_frequently="frequently"');
		$this->db->join('ams_next_in_hrs_services e','a.next_in_hours=e.id','left');
		$this->db->where(array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id'],'a.type'=>'frequently'));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Guest_frequntly_Services($data){
		$this->db->select('a.`id`, a.`apartment_id`,a.end_date, a.`member_id`, a.`type`, a.`username`, a.`phonenumber`, a.`select_date`, a.`start_time`, a.`end_time`, a.`created_date`,a.gate_pass_id,a.next_days',FALSE);
		$this->db->from('ams_once_member_guest_services a');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND a.type="guest" AND c.once_or_frequently="frequently"');
		//$this->db->join('ams_service_start_times d','a.end_time=d.id AND a.type="guest" AND d.once_or_frequently="frequently"');
		$this->db->where(array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id'],'a.type'=>'frequently'));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_Visiting_help_frequntly_Services($data){
		$this->db->select('a.`id`, a.`apartment_id`, a.`member_id`, a.`type`, e.next_in_hrs as `next_in_hours`, b.title as `company_name`, a.category_name, a.`select_date`, a.`start_time`, a.`end_time`,a.days_of_week,a.validity_days, a.`created_date`',FALSE);
		$this->db->from('ams_once_member_visiting_help_services a');
		$this->db->join('ams_company_services b','a.company_name=b.id AND b.type="visiting_help"','left');
		//$this->db->join('ams_service_end_times c','a.start_time=c.id AND type="visiting_help" AND c.once_or_frequently="frequntly"');
		//$this->db->join('ams_service_start_times d','a.valid_for_next=d.id AND type="visiting_help"  AND d.once_or_frequently="frequntly"');
		$this->db->join('ams_next_in_hrs_services e','a.next_in_hours=e.id','left');
		$this->db->where(array('a.apartment_id'=>$data['apartment_id'],'a.member_id'=>$data['member_id'],'a.type'=>'frequntly'));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function Get_All_available($apartment_id,$id=''){
		$this->db->select('a.`id`,a.image,a.amount,a.`apartment_id`,a.`added_by`,a.`title`,a.`description`,a.`type`,a.`max_days_per_flat`,a.`max_capacity`,a.`number_of_days_in_capacity`,b.`slot`',FALSE);
		$this->db->from('ams_booking_category a');
		$this->db->join('ams_booking_timeslots b','a.slot=b.id');
		$this->db->where(array('a.apartment_id'=>$apartment_id));
		if($id!=''){
			$this->db->where(array('a.id'=>$id));
			$res=$this->db->get()->row_array();
		}else{
			$res=$this->db->get()->result_array();
		}
		return $res;
	}
	public function get_allschool_data($apartment_id,$member_id){
		$this->db->select('a.`id`, a.`apartment_id`, a.`school_name`, a.`route_name`, a.`driver_name`, a.`phone_number`, b.`added_date`',FALSE);
		$this->db->from('ams_school_bus a');
		$this->db->join('add_school_bus_member b','a.id=b.school_bus_id');
		$this->db->where(array('b.apartment_id'=>$apartment_id,'b.member_id'=>$member_id));
		$res=$this->db->get()->result_array();
		return $res;
	}
	public function sendpushnotification_sample($deviceid,$header,$message)
	{
	 $fcmRegIds= $this->db->query("SELECT  `device_id`,`pnr_id` FROM  cas_tmp where device_id='$deviceid' AND `pn_enabled`='1' ")->result_array();
     if(!empty($fcmRegIds))
	 {
	//print_r($fcmRegIds); exit;
	$fids=array_column($fcmRegIds,'pnr_id');
	$device_ids=array_column($fcmRegIds,'device_id');
	//$dd = $this->getusersbydevice($device_ids,$user_id);
	//return $fids;

	#API access key from Google API's Console
	define( 'API_ACCESS_KEY', 'AAAAosBpEI8:APA91bGNtdOP2BWOQuhX3AXOsoisrnajpaIMSmv-Nl0kTDrPk-BXmhECD46qSVJudrL9wsZwr-l6P6STTqWuEGNAZKecX3OiWrhgRSYCUUkbmLH13RfBOP36uKdOvye57pL10MTfVx-E' );
	$registrationIds =$fids;
	//   print_r($registrationIds); exit;
	#prep the bundle
	$msg = array
	(
	'body'  =>$message,
	'title' =>$header,
	'click_action'=>'FCM_PLUGIN_ACTIVITY',
	'icon' => 'fcm_push_icon',/*Default Icon*/
    "color"=>"#7CFC00",
	'sound' => 'mySound',/*Default sound*/
	"data"=>array('test'=>'venkat')
	);

	$fields = array
	(
	'registration_ids'  => $registrationIds,
	'notification' => $msg
	);


	$headers = array
	(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
	);

	#Send Reponse To FireBase Server 
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );

	#Echo Result Of FireBase Server
	echo  $result; 
	
	 }
	 else{
		 echo 0;
	 }
		
	}
	public function update_deviceid($user_id,$device_id,$pn_enabled,$pnr_id)
	{
		$data=array('pn_enabled'=>$pn_enabled,'pnr_id'=>$pnr_id,'created_date'=>date('Y-m-d H:i:s'));
		$this->db->where('device_id',$device_id);
		$this->db->where('user_id',$user_id);
		return $this->db->update('cas_tmp',$data);
		//return $this->db->last_query();
		
	}
	public function old_Calculation(){
		$time3 = date('H:i:s');
		$tentyfour3 = date("H:i:s", strtotime($time3));
		$seconds3 = strtotime("1970-01-01 $tentyfour3 UTC");
		$time1 = $v['start_time'];
		if($time1!='' && $time1!=null){
		$tentyfour1 = date("H:i:s", strtotime($time1));
		$seconds1 = strtotime("1970-01-01 $tentyfour1 UTC");
		}else{
		$seconds1 = 0;
		}
		$time2 = $v['end_time'];
		if($time1!='' && $time1!=null){
		$tentyfour2 = date("H:i:s", strtotime($time2));
		$seconds2 = strtotime("1970-01-01 $tentyfour2 UTC");
		}else{
		$seconds2 = 0;
		}
		if($seconds3>=$seconds1 && $seconds3<=$seconds2){
		$time='inbetween';
		}else if($seconds3>$seconds2){
		$time='greater';
		}else{
		$time='lessthan';
		}
	}
	public function getgatevisitortime($v,$type){
		// $present = date('H:i:s');
		// $current_time =date("H:i:s A", strtotime($present));
		// if($type==2){
		// 	$sunrise = ($v['start_time']=='' || $v['start_time']==null)?'07:00:00 AM':$v['start_time'];
		// 	$sunset = ($v['end_time']=='' || $v['end_time']==null)?'12:59:00 PM':$v['end_time'];
		// }else{
		// 	$sunrise = $v['start_time'];
		// 	$sunset  = $v['end_time'];
		// }
		// $date1 = DateTime::createFromFormat('H:i a', $current_time);
		// $date2 = DateTime::createFromFormat('H:i a', $sunrise);
		// $date3 = DateTime::createFromFormat('H:i a', $sunset);
		$today = date('H:i:s');
		$current_time = date("H:i:s", strtotime($today));
		$date1 = strtotime("1970-01-01 $current_time UTC");
		$time1 = $v['start_time'];
		if($time1!='' && $time1!=null){
			$sunrise = date("H:i:s", strtotime($time1));
			$date2 = strtotime("1970-01-01 $sunrise UTC");
		}else{
			$date2 = 0;
		}
		$time2 = $v['end_time'];
		if($time2!='' && $time2!=null){
			$sunset = date("H:i:s", strtotime($time2));
			$date3 = strtotime("1970-01-01 $sunset UTC");
		}else{
			$date3 = 0;
		}
		$CURRENTDATE = date('Y-m-d');
		$temp_id = $v['temp_id'];
		$Checked_Date=  $this->db->query("SELECT * FROM `ams_guest_data` WHERE DATE('$CURRENTDATE') between DATE(`select_date`) AND DATE(`end_date`) AND temp_id=$temp_id")->num_rows();
		if($Checked_Date>0){
			if($date1 > $date2 && $date1 < $date3){
				$time=array('time'=>'inbetween','order_id'=>1);
				$final='inbetween';
			}else if($date1 < $date2){
				$time=array('time'=>'lessthan','order_id'=>2);
				$final='lessthan';
			}else{
				if(isset($v['temp_id'])){
					$temp_id=$v['temp_id'];
				}else{
					$temp_id=0;
				}
				$temp_id_tm = $this->db->query("SELECT DATE(`end_date`)-(`select_date`) as tm FROM `ams_guest_data` WHERE temp_id=$temp_id")->row_array();
				$temp_id_tm = ($temp_id_tm['tm']<1 )?0:$temp_id_tm['tm'];
				$date3 = (86400*$temp_id_tm)+$date3;
				if($date1 > $date3){
					$time=array('time'=>'greater','order_id'=>3);
					$final='greater';
				}else{
					$time=array('time'=>'inbetween','order_id'=>1);
					$final='inbetween';
				}
			}
		}else{
			$select_date = $v['select_date'];
			if($select_date > $CURRENTDATE){
				$time=array('time'=>'lessthan','order_id'=>2);
				$final='lessthan';
			}else{
				$time=array('time'=>'greater','order_id'=>3);
				$final='greater';
			}
		}
		$current_time = $current_time .'='. $date1;
		$sunrise = $sunrise .'='. $date2;
		$sunset = $sunset .'='. $date3;
		if($type==1){
			$all = array('t1'=>$current_time,'t2'=>$sunrise,'t3'=>$sunset);
			return array(
				'time'=>$time,
				'time2'=>$all
			);
		}else{
			return array('time'=>$final,'t1'=>$current_time,'t2'=>$sunrise,'t3'=>$sunset);
		}
	}
	public function Array_Ordering($order_id){
		$prices = array_column($order_id, 'order_id');
		array_multisort($prices, SORT_ASC, $order_id);
		return ($order_id);
	}
}