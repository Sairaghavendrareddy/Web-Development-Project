<?php 
  function remove_unknown_fields($raw_data, $expected_fields) {
  $new_data=array();
  foreach($raw_data as $field_name=>$field_value)
   {
       $new_data[$field_name]=$field_value;
   }
   return $new_data;
  }
 