<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('isLogin'))
{
    function isLogin(){
        $CI =& get_instance();
        if($CI->session->userdata('osw_isLogin'))
		{
			$user_id=$CI->session->userdata('user_id');
			$res = $CI->db->query("select * from `users` where `is_deleted`='0' and `user_id`='$user_id'");
			
			  if($res->num_rows()==1)
			  {
			  }
			  else
			  {
				  redirect('logout');
			  }
			
		}
		else
		{
			redirect('login');
		}
    }
}

if(! function_exists('studentDetails'))
{
	function studentDetails($required){
		 $field_required = (trim($required)==1)? "chk_validate_select":'';
        $CI =& get_instance();
        $res = $CI->db->query("SELECT `student_id`,CONCAT(first_name, ' ', last_name) as student_name FROM `mt_students` where `is_deleted`='0'");
		$results = $res->result_array();
		$resd =  '<select name="attended_student[]" id="attended_student" multiple class="'.$field_required.'">';
		if(!empty($results))
		{
			foreach($results as $rr)
			{
				$resd.='<option value="'.$rr['student_id'].'">'.$rr['student_name'].'</option>';
			}
			
			
			
		}
                $resd.='</select>';
                
			$resd.="<script>$('#attended_student').multiselect({
                    numberDisplayed: 3,
                    enableCaseInsensitiveFiltering:true,
                    nonSelectedText: 'Please select student',
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    selectAllValue: 0
                });</script>";
                return $resd;
    }
	                        
}

if(! function_exists('facultyDetails'))
{
	function facultyDetails($required){
		$field_required = ($required==1)? "chk_validate_select":'';
        $CI =& get_instance();
        $res = $CI->db->query("SELECT `user_id`,CONCAT(first_name,' ',last_name) as name FROM `teaching_assistent` UNION  SELECT `user_id`,CONCAT(first_name,' ',last_name) as name FROM `mentors` UNION  SELECT `user_id`,CONCAT(first_name,' ',last_name) as name FROM `program_managers`");
		$results = $res->result_array();
		$resd =  '<select name="attended_faculty[]" id="attended_faculty" multiple class="'.$field_required.'">';
		//$resd .=  '<option value="">Select faculty</option>';
		if(!empty($results))
		{
			foreach($results as $rr)
			{
				$resd.='<option value="'.$rr['user_id'].'">'.$rr['name'].'</option>';
			}
			
		}
                $resd.='</select>';
			
			$resd.="<script>$('#attended_faculty').multiselect({
                    numberDisplayed: 3,
                    enableCaseInsensitiveFiltering:true,
                    nonSelectedText: 'Please select faculty',
                    includeSelectAllOption: true,
                    enableFiltering: true, 
                    selectAllValue: ''
                });</script>";
			return $resd;
    }
	                        
}
if(! function_exists('contactDetails'))
{
	function contactDetails($required){
		$field_required = ($required==1)? "chk_validate":'';
        $CI =& get_instance();
        	return  '<div class="row"><div class="col-xs-12 col-sm-4"><div class="left_side2"><strong>Name</strong></div><div class="right_side2"><input type="text" name="contact_name" class="form-control ' .$field_required.'" placeholder="Enter Name" /></div>
			</div><div class="col-xs-12 col-sm-4"><div class="left_side2"><strong>Email</strong></div><div class="right_side2"><input type="email" name="contact_email" class="form-control ' .$field_required.'" placeholder="Enter Email" /></div></div><div class="col-xs-12 col-sm-4">
							<div class="left_side2"><strong>Phone Number</strong></div>
								<div class="right_side2">
									<input type="tel" name="contact_phone" pattern="[0-9]{10}"  class="form-control '.$field_required.'" placeholder="Enter phone number" />
								</div>
							</div>
						</div>';
    }
	                        
}
if(! function_exists('getrating'))
{
	function getrating($type,$stop,$question_id){
        $resd ="";
	if($type == 'hearts')
	{
	$resd =  '<input type="hidden" name="question['.$question_id.'][choices][]" class="rating " data-filled="glyphicon glyphicon-heart cheart_rating" data-empty="glyphicon glyphicon-heart-empty cheart_rating" data-fractions="2" data-start="0" data-stop="'.$stop.'"/>';
	}
	else if($type == 'stars')
	{
	$resd =  '<input type="hidden" name="question['.$question_id.'][choices][]" class="rating " data-filled="glyphicon glyphicon-star cstar_rating" data-empty="glyphicon glyphicon-star-empty cstar_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'" />';
	}
	else if($type == 'thumbs_up')
	{
	$resd =  '<input type="hidden" name="question['.$question_id.'][choices][]" class="rating " data-filled="fa fa-thumbs-up cthumbsup_rating" data-empty="fa fa-thumbs-o-up cthumbsup_rating" data-fractions="2" data-start="0" data-stop="'.$stop.'"/>';
	}

        return $resd;
        }
	                        
}
if(! function_exists('groupsDetails'))
{
	function groupsDetails($required){
		 $field_required = ($required==1)? "chk_validate_select":'';
        $CI =& get_instance();
        $res = $CI->db->query("SELECT `group_id`,`group_name` FROM `mt_group` WHERE `is_deleted`='0'");
		$results = $res->result_array();
		$resd =  '<select name="attended_groups[]" id="attended_groups" multiple class="'.$field_required.'">';
		if(!empty($results))
		{
			foreach($results as $rr)
			{
				$resd.='<option value="'.$rr['group_id'].'">'.$rr['group_name'].'</option>';
			}
			
		}
                $resd.='</select>';
			
			$resd.="<script>$('#attended_groups').multiselect({
                    numberDisplayed: 3,
                    enableCaseInsensitiveFiltering:true,
                    nonSelectedText: 'Please select group',
                    includeSelectAllOption: true,
                    enableFiltering: true
                });</script>";
			return $resd;
    }
	                        
}
if(! function_exists('getrating_forcapture'))
{
	function getrating_forcapture($activity_type_id,$student_id,$type,$stop,$question_id,$required,$answers='')
	{    $activity_type_id=trim($activity_type_id);
		 $field_required = ($required==1)? "chk_validate":'';
        $resd ="";
	   if($type == 'stars')
		{
		$resd =  '<input type="hidden" value="'.$answers.'"  onchange="saveCaptureData('.$activity_type_id.','.$student_id.','.$question_id.',this.value)" data-questionid="'.$question_id.'" name="answers['.$student_id.']" class="questionData rating '.$field_required.'" data-filled="glyphicon glyphicon-star cstar_rating" data-empty="glyphicon glyphicon-star-empty cstar_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'"  />';
		}
		else if($type == 'hearts')
		{
			$resd =  '<input type="hidden" value="'.$answers.'"  onchange="saveCaptureData('.$activity_type_id.','.$student_id.','.$question_id.',this.value)" data-questionid="'.$question_id.'" name="answers['.$student_id.']" class="questionData rating '.$field_required.'" data-filled="glyphicon glyphicon-heart cheart_rating" data-empty="glyphicon glyphicon-heart-empty cheart_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'"  />';
		
		}
		else if($type == 'thumbs_up')
		{
			$resd =  '<input type="hidden" value="'.$answers.'"  onchange="saveCaptureData('.$activity_type_id.','.$student_id.','.$question_id.',this.value)" data-questionid="'.$question_id.'" name="answers['.$student_id.']" class="questionData rating '.$field_required.'" data-filled="fa fa-thumbs-up cthumbsup_rating" data-empty="fa fa-thumbs-o-up cthumbsup_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'"  />';
	
		}

		
	    return $resd;
        
	}
	                        
}

if(! function_exists('edit_studentDetails'))
{
	function edit_studentDetails($required,$students){
		$chk = "";
		 $field_required = ($required==1)? "chk_validate_select":'';
        $CI =& get_instance();
        $res = $CI->db->query("SELECT `student_id`,CONCAT(first_name, ' ', last_name) as student_name FROM `mt_students` where `is_deleted`='0'");
		$results = $res->result_array();
		$resd =  '<select name="attended_student[]" id="attended_student" multiple class="'.$field_required.'">';
		//echo "<pre>";print_r($results);exit;
		if(!empty($results))
		{
			foreach($results as $k=>$rr)
			{
				if(!empty($students))
				{ 
		
				if (in_array($rr['student_id'], $students))
					{
						 $chk = 'selected';
					}
					else
					{
						$chk = "";
					}
				}
				$resd.='<option value="'.$rr['student_id'].'" '.$chk.'>'.$rr['student_name'].'</option>';
			}
			$resd.='</select>';
			
			$resd.="<script>$('#attended_student').multiselect({
                    numberDisplayed: 3,
                    enableCaseInsensitiveFiltering:true,
                    nonSelectedText: 'Please select student',
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    selectAllValue: 0
                });</script>";
			return $resd;
		}
    }
	                        
}
if(! function_exists('edit_facultyDetails'))
{
		function edit_facultyDetails($required,$faculty){
			$chk = "";
		$field_required = ($required==1)? "chk_validate_select":'';
        $CI =& get_instance();
        $res = $CI->db->query("SELECT `user_id`,CONCAT(first_name,' ',last_name) as name FROM `teaching_assistent` UNION  SELECT `user_id`,CONCAT(first_name,' ',last_name) as name FROM `mentors` UNION  SELECT `user_id`,CONCAT(first_name,' ',last_name) as name FROM `program_managers`");
		$results = $res->result_array();
		$resd =  '<select name="attended_faculty[]" id="attended_faculty" multiple class="'.$field_required.'">';
		//$resd .=  '<option value="">Select faculty</option>';
		if(!empty($results))
		{
			foreach($results as $rr)
			{
				if(!empty($faculty))
				{ 
		
				if (in_array($rr['user_id'], $faculty))
					{
						 $chk = 'selected';
					}
					else
					{
						$chk = "";
					}
				}
				$resd.='<option value="'.$rr['user_id'].'" '.$chk.'>'.$rr['name'].'</option>';
			}
			$resd.='</select>';
			
			$resd.="<script>$('#attended_faculty').multiselect({
                    numberDisplayed: 3,
                    enableCaseInsensitiveFiltering:true,
                    nonSelectedText: 'Please select faculty',
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    selectAllValue: ''
                });</script>";
			return $resd;
		}
    }
	                        
}
if(! function_exists('edit_groupsDetails'))
{
	function edit_groupsDetails($required,$groups){
		$chk = "";
		 $field_required = ($required==1)? "chk_validate_select":'';
        $CI =& get_instance();
        $res = $CI->db->query("SELECT `group_id`,`group_name` FROM `mt_group` WHERE `is_deleted`='0'");
		$results = $res->result_array();
		$resd =  '<select name="attended_groups[]" id="attended_groups" multiple class="'.$field_required.'">';
		if(!empty($results))
		{
			foreach($results as $rr)
			{
				if(!empty($groups))
				{ 
		
				  if (in_array($rr['group_id'], $groups))
					{
						 $chk = 'selected';
					}
					else
					{
						$chk = "";
					}
				}
				$resd.='<option value="'.$rr['group_id'].'" '.$chk.'>'.$rr['group_name'].'</option>';
			}
			$resd.='</select>';
			
			$resd.="<script>$('#attended_groups').multiselect({
                    enableCaseInsensitiveFiltering:true,
                    numberDisplayed: 3,
                    nonSelectedText: 'Please select group',
                    includeSelectAllOption: true,
                    enableFiltering: true
                });</script>";
			return $resd;
		}
    }
	                        
}
if(! function_exists('edit_contactDetails'))
{
	function edit_contactDetails($required,$name='',$email='',$phone=''){
		$field_required = ($required==1)? "chk_validate":'';
        $CI =& get_instance();
        	return  '<div class="row"><div class="col-xs-12 col-sm-4"><div class="left_side2"><strong>Name</strong></div><div class="right_side2"><input type="text" name="contact_name" class="form-control ' .$field_required.'" placeholder="Enter Name" value="'.$name.'" /></div>
			</div><div class="col-xs-12 col-sm-4"><div class="left_side2"><strong>Email</strong></div><div class="right_side2"><input type="email" name="contact_email" class="form-control ' .$field_required.'" placeholder="Enter Email" value="'.$email.'"/></div></div><div class="col-xs-12 col-sm-4">
							<div class="left_side2"><strong>Phone Number</strong></div>
								<div class="right_side2">
									<input type="tel" name="contact_phone" pattern="[0-9]{10}" class="form-control '.$field_required.'" placeholder="Enter phone number" value="'.$phone.'" />
								</div>
							</div>
						</div>';
    }
	                        
}
if(! function_exists('rating_capture_view'))
{
	function rating_capture_view($student_id,$type,$stop,$question_id,$answers='')
	{    
        $resd ="";
	   if($type == 'stars')
		{
		$resd =  '<input type="hidden" value="'.$answers.'"  data-questionid="'.$question_id.'" name="answers['.$student_id.']" class="questionData rating" data-filled="glyphicon glyphicon-star cstar_rating" data-empty="glyphicon glyphicon-star-empty cstar_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'" readonly  />';
		}
		else if($type == 'hearts')
		{
			$resd =  '<input type="hidden" value="'.$answers.'"  data-questionid="'.$question_id.'" name="answers['.$student_id.']" class="questionData rating" data-filled="glyphicon glyphicon-heart cheart_rating" data-empty="glyphicon glyphicon-heart-empty cheart_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'" readonly />';
		
		}
		else if($type == 'thumbs_up')
		{
			$resd =  '<input type="hidden" value="'.$answers.'" data-questionid="'.$question_id.'" name="answers['.$student_id.']" class="questionData rating" data-filled="fa fa-thumbs-up cthumbsup_rating" data-empty="fa fa-thumbs-o-up cthumbsup_rating" data-fractions="2"  data-start="0" data-stop="'.$stop.'"  readonly />';
	
		}

		
	    return $resd;
        
	}
	}
	
	if(! function_exists('monthsCalculation'))
	{
		
		function monthsCalculation($count='',$startmonth='',$startyear='')
		{
			$resArr = array();
			if($startmonth=='')
			{
			  $startmonth =  date("m");	
			}
			
			if($startyear=='')
			{
				$startyear=date("Y");
			}
			$effectiveDate=$startyear."-".$startmonth;
			if($count>0)
			{
				
				
				$resArr[]= $effectiveDate;
				for($i=1;$i<$count;$i++)
				{

				$effectiveDates = date('Y-m', strtotime("+1 month", strtotime($effectiveDate)));
				$resArr[]= $effectiveDates;
				  $effectiveDate=$effectiveDates;
				}
			}
			else
			{
				
				

				if($count<0)
				{

				$effectiveDate=$startyear."-".$startmonth;
				$resArr[]= $effectiveDate;
				for($i=-1;$i>$count;$i--)
				{

				$effectiveDates = date('Y-m', strtotime("-1 month", strtotime($effectiveDate)));
				$resArr[]= $effectiveDates;
				 $effectiveDate=$effectiveDates;
				}
				}
			}
			return $resArr;
		}
	}
	                        

?>
