<?php
ob_start();
class Common_model extends CI_Model
{
    public function chk_location($location_name, $trid)
    {
        if ($trid == '') {
            $res = $this->db->query("select `location_name` from `locations` where  `location_name`='$location_name'");
        } else {
            $res = $this->db->query("select `location_name` from `locations` where `location_name`='$location_name' and `location_id`!=$trid");
        }
        $result = $res->num_rows();
        return $result;
    }
    public function commonCheck($tableName,$fiedls,$arrayData)
    {
        return $this->db->select($fiedls)->get_where($tableName,$arrayData)->num_rows();
        
    }
    #--------------------------------------------------------------------
    # Common Insert Function
    #---------------------------------------------------------------------
    public function commonInsert($tableName,$arrayData)
    {
        $this->db->insert($tableName, $arrayData);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    #--------------------------------------------------------------------
    # Common Update Function
    #---------------------------------------------------------------------
    public function commonUpdate($tableName, $updateArray, $whereCondition)
    {
        $this->db->where($whereCondition);
        return $this->db->update($tableName, $updateArray);
    }
    #--------------------------------------------------------------------
    # Common Delete Function
    #---------------------------------------------------------------------
    public function commonDelete($tableName, $whereCondition)
    {
        return $this->db->delete($tableName, $whereCondition);
    }
    #--------------------------------------------------------------------
    # common function for get all data
    #---------------------------------------------------------------------
    public function commonGet($tablename, $fields, $where, $type)
    {
        $res = $this->db->select($fields)->from($tablename);
        if ($where != '' OR $where != NULL) {
            $this->db->where($where);
        }
        if ($type == "all") {
            return $this->db->get()->result_array();
        } else {
            return $this->db->get()->row_array();
        }
    }
    #--------------------------------------------------------------------
    # common function for get all data Query String
    #---------------------------------------------------------------------
    public function commonRetriveQuery($query, $type)
    {
        if ($type == 'all') {
            $result = $this->db->query("$query")->result_array();
        } else {
            $result = $this->db->query("$query")->row_array();
        }
        return $result;
    }
    public function mmddyyyy_to_yyyymmdd($date)
    {
        if ($date != '') {
            return substr($date, 6, 4) . "/" . substr($date, 0, 2) . "/" . substr($date, 3, 2);
        } else {
            return '0000-00-00';
        }
    }
    public function yyyymmdd_to_mmddyyyy($date)
    {
        //echo $date;
        if ($date != '0000-00-00' && $date != '') {
            return date('m/d/Y', strtotime($date));
        } else {
            return '';
        }
    }
    #--------------------------------------------------------------------
    # function for genrate password
    #---------------------------------------------------------------------
    public function generate_pwd()
    {
        $str = "qwertyuiopasdfghjklzxcvbnm123456789";
        return $sub_str = substr(str_shuffle($str), 0, 7);
    }
   
    #--------------------------------------------------
    # Function to send email
    #--------------------------------------------------
    public function send_email($html_content, $email, $subject)
    {
        $this->load->library('email');
        $this->email->from('noreply@thesoilson.com', 'The Soilson');
        $this->email->to($email);
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($html_content);
        if ($this->email->send()) {
            return $mailstatus = 1;
        } else {
            return $mailstatus = 0;
        }
    }    
    #--------------------------------------------------
    # Function to send email
    #--------------------------------------------------
    public function send_email_to($html_content, $fromemail, $toemail, $subject)
    {
        $this->load->library('email');
        $this->email->from($fromemail);
        $this->email->to($toemail);
        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($html_content);
        if ($this->email->send()) {
            return $mailstatus = 1;
        } else {
            return $mailstatus = 0;
        }
    }
    public function sendSMS($mobileno,$msg)
    {
            // $apiKey = urlencode('XHxN6NF3Dtk-TdP3792tIiCgLQmsdioHOBSRUvcjLf');
            // $sender = urlencode('VIEWAD');
            // $message = rawurlencode($msg);
            // $numbers = implode(',', $mobileno);
            // $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
            // $ch = curl_init('https://api.textlocal.in/send/');
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // curl_close($ch);
            // return $response;
    }
    public function GetRefId(){
       return $random = time() . rand(10*45, 100*98);
    }
    public function Get_Temp_Content($template_id,$replace){
        $Temp=$this->db->select('message')->get_where('sms_email_templates',array('template_id'=>$template_id,'status'=>1))->row_array();
        if(!empty($Temp)){
            $sms_template=$Temp['message'];
            $fields=array(
                '{OTP_PAGE}'=>isset($replace['OTP_PAGE'])?$replace['OTP_PAGE']:'',
                '{OTP}'=>isset($replace['OTP'])?$replace['OTP']:'',
            );
            $str =  @strtr($sms_template,$fields);
        }else{
            $str = '';
        }
        return $str;
    }
    function GetProdMes($prod_id){
        $res = $this->db->query("SELECT a.`id` as prod_mes_id, a.`prod_id`, a.`mes_id`, a.`prod_image`, a.`prod_image_name`, a.`prod_org_price`, a.`prod_offered_price`, a.`prod_available_qty`,b.title FROM `product_mesurments` a LEFT JOIN mesurements b ON a.`mes_id`=b.mes_id WHERE a.`prod_id`=$prod_id")->result_array();
        return $res;
    }
    public function barcode($tm, $filepath="", $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 ) {
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
        $activeKey = substr( $text, ($X-1), 1);
        $code_string .= $code_array[$activeKey];
        $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";
        } elseif ( strtolower($code_type) == "code128a" ) {
        $chksum = 103;
        $text = strtoupper($text); // Code 128A doesn't support lower case
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
        $activeKey = substr( $text, ($X-1), 1);
        $code_string .= $code_array[$activeKey];
        $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];
        $code_string = "211412" . $code_string . "2331112";
        } elseif ( strtolower($code_type) == "code39" ) {
        $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");
        // Convert to uppercase
        $upper_text = strtoupper($text);
        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
        $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
        }
        $code_string = "1211212111" . $code_string . "121121211";
        } elseif ( strtolower($code_type) == "code25" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
        $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");
        for ( $X = 1; $X <= strlen($text); $X++ ) {
        for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
        if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
        $temp[$X] = $code_array2[$Y];
        }
        }
        for ( $X=1; $X<=strlen($text); $X+=2 ) {
        if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
        $temp1 = explode( "-", $temp[$X] );
        $temp2 = explode( "-", $temp[($X + 1)] );
        for ( $Y = 0; $Y < count($temp1); $Y++ )
        $code_string .= $temp1[$Y] . $temp2[$Y];
        }
        }
        $code_string = "1111" . $code_string . "311";
        } elseif ( strtolower($code_type) == "codabar" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
        $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");
        // Convert to uppercase
        $upper_text = strtoupper($text);
        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
        for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
        if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
        $code_string .= $code_array2[$Y] . "1";
        }
        }
        $code_string = "11221211" . $code_string . "1122121";
        }
        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
        $text_height = 30;
        } else {
        $text_height = 0;
        }
        for ( $i=1; $i <= strlen($code_string); $i++ ){
        $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
        }
        if ( strtolower($orientation) == "horizontal" ) {
        $img_width = $code_length*$SizeFactor;
        $img_height = $size;
        } else {
        $img_width = $size;
        $img_height = $code_length*$SizeFactor;
        }
        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate ($image, 0, 0, 0);
        $white = imagecolorallocate ($image, 255, 255, 255);
        imagefill( $image, 0, 0, $white );
        if ( $print ) {
        imagestring($image, 5, 31, $img_height, $text, $black );
        }
        $location = 10;
        for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
        $cur_size = $location + ( substr($code_string, ($position-1), 1) );
        if ( strtolower($orientation) == "horizontal" )
        imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
        else
        imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
        $location = $cur_size;
        }
        // Draw barcode to the screen or save in a file
        if ( $filepath=="" ) {
        header ('Content-type: image/png');
        imagepng($image);
        $save = "assets/qrcodes/".$tm.strtolower($image) .".png";
        imagepng($image, $save);
        imagedestroy($image);
        } else {
        imagepng($image,$filepath);
        $save = "assets/qrcodes/".$tm.strtolower($image) .".png";
        imagepng($image, $save);
        imagedestroy($image);       
        }
    }
    public function send_invoice($order_id=0){
        $response['order']=$this->db->query("SELECT a.`order_id`,a.user_apartment_det_id, a.`payment_id`, a.`user_id`, a.`reference_id`, a.`order_amount`, a.`user_address_id`, a.`payment_mode`, a.`payment_status`, a.`order_date`, a.`order_succ_date`, a.`order_failed_date`, a.`order_cancelled_date`,b.name,b.email,b.phone,c.user_address_id,c.mobile_no,c.floor_no,c.block_no,c.appartment,c.address,c.pincode FROM `orders` a LEFT JOIN users b ON a.user_id=b.user_id LEFT JOIN order_user_address c ON a.order_id=c.order_id WHERE a.`order_id`=$order_id")->row_array();
        if(empty($response['order'])){
            redirect('admin/orders');
        }else{
            $payment_id = $response['order']['payment_id'];
        }
        $response['products']=$this->db->query("SELECT `order_prod_id`, `order_id`, `user_id`, `qty`, `tot_amount`, `offer_amount`, `prod_id`, `prod_title`, `prod_category`,`prod_mesurements`,prod_mes_id FROM `order_products` WHERE `order_id`=$order_id")->result_array();
        // echo $this->db->last_query();
        // echo "<pre>";print_r($response);exit;
        $htmlcontent = $this->load->view('admin/invoice',$response,TRUE);
        // echo print_r($htmlcontent);exit;
        $path='assets/invoices/Invoice_'.$order_id.".pdf";
        $this->load->library('M_pdf');
        @$this->m_pdf->mpdf->WriteHTML($htmlcontent);
        //$this->m_pdf->mpdf->Output($path, "D");
        $this->m_pdf->mpdf->Output($path, "F");
    }
    public function sending_low_balance_alert($user_id=0){

    }
    public function subscribe_cron(){
        $Sub_Data = $this->db->query("SELECT `type`,`subscribe_id`,`user_id` FROM `prod_subscriptions` WHERE `is_active`<3")->result_array();
        if(count($Sub_Data)>0){
            $curdate = date('Y-m-d');
            $next_day   = date($curdate,strtotime("+1 day"));
            $next_day_2 = date($curdate,strtotime("+2 day"));
            $Cron_Arr = array();
            foreach($Sub_Data as $k=>$va){
                $next_delivery = '';
                $subscribe_id = $va['subscribe_id'];
                $type         = $va['type'];
                $user_id      = $val['user_id'];
                if($type=='temporarily_change' || $type=='pause_subscription'){
                    $Check_Temp = $this->db->query("SELECT `id`,`qty`, `from_date`, `to_date`, `type`, `is_expaired` FROM `pause_subscriptions` WHERE `subscribe_id`=$subscribe_id AND is_expaired=1 ORDER BY id DESC LIMIT 1")->row_array();
                    $this->db->update('prod_subscriptions',array('reason'=>'','type'=>'no_change','is_active'=>1),array('id'=>$Check_Temp['id']));
                    $this->db->update('pause_subscriptions',array('is_expaired'=>0),array('subscribe_id'=>$subscribe_id));
                }
                $Check_Sub = $this->db->query("SELECT `a`.`subscribe_id`, `a`.`user_id`, `a`.`prod_id`, `a`.`prod_mes_id`, `a`.`qty`, `a`.`next_payment`,`b`.`prod_offered_price` FROM `prod_subscriptions` a INNER JOIN `product_mesurments` b ON `a`.`prod_mes_id`=`b`.`id` WHERE `a`.`subscribe_id`=$subscribe_id")->row_array();
                //$existed_count['created_date']=date('Y-m-d H:i:s');
                //$existed_count['action_type']=1;
                if($Check_Sub['is_active']==1){
                    $pause = 'Your subscription paused due to insufficient wallet amount';
                    $start_date = $Check_Sub['from_date'];
                    $days_list  = $Check_Sub['days_list'];  
                    if($schedule_type=='daily'){
                        if($next_day >= $start_date){
                            if(is_null($Check_Sub['next_payment'])){
                                if($start_date == $next_day){
                                    $next_delivery = $next_day;
                                }
                            }else{
                                $next_delivery = $next_day;
                            }
                        }
                    }else if($schedule_type=='alternative'){
                        if($next_day >= $start_date){
                            if(is_null($Check_Sub['next_payment'])){
                                if($start_date == $next_day){
                                    $next_delivery = $start_date;
                                }
                            }else{
                                $calc_delivery_date = date($Check_Sub['next_payment'],strtotime("+2 day"));
                                if($calc_delivery_date == $next_day){
                                    $next_delivery = $calc_delivery_date;
                                }
                            } 
                        }
                    }else if($schedule_type=='every_three_days'){
                        if($next_day >= $start_date){
                            if(is_null($Check_Sub['next_payment'])){
                                if($start_date == $next_day){
                                    $next_delivery = $start_date;
                                }
                            }else{
                                $calc_delivery_date = date($Check_Sub['next_payment'],strtotime("+3 day"));
                                if($calc_delivery_date == $next_day){
                                    $next_delivery = $calc_delivery_date;
                                }
                            } 
                        }
                    }else if($schedule_type=='weekely'){
                        if($next_day >= $start_date){
                            $Wk_Days    = explode(',',$days_list);
                            $DayOfWeek  = date('D', strtotime($next_day));
                            if(in_array($DayOfWeek,$Wk_Days)) {
                                $next_delivery = $next_day;
                            }
                        }
                    }else{
                        if($next_day >= $start_date){
                            $Month_Days    = explode(',',$days_list);
                            $Date_Check  = date('d', strtotime($next_day));
                            if(in_array($Date_Check,$Month_Days)) {
                                $next_delivery = $next_day;
                            }
                        }
                    }
                    $prod_offered_price = $Check_Sub['prod_offered_price'];
                    $qty                = $Check_Sub['qty'];
                    if($next_delivery!=''){
                        $next_payment_up_arr = array('next_payment'=>$next_delivery);
                        $price = ($prod_offered_price*$qty)+Service_Charge();
                        $Cron_Arr[] = array(
                            'subscribe_id'  =>  $subscribe_id,
                            'user_id'       =>  $user_id,
                            'price'         => $price,
                        );
                        //$Check_Wall_Amt = $this->db->query("SELECT `final_wallet_amount`,`reserved_amount` FROM `users` WHERE `user_id`=$user_id")->row_array();
                    }else{
                        $next_payment_up_arr = array('next_payment'=>NULL);
                    }
                    $this->db->update('prod_subscriptions',$next_delivery,array('subscribe_id'=>$subscribe_id));
                }
            }
        }
        $this->db->insert('test',array('date'=>date('Y-m-d H:i:s')));
    }
}