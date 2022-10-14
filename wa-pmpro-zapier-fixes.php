<?php
/**
 * Plugin Name: WA PMPro Zapier Fixes
 * Plugin URI: http://www.webascender.com/?wa-pmpro-zapier-fixes
 * Description: Zapier integration is buggy rubbish, this fixes the data sent across
 * Version: 1.0
 * Author: Web Ascender
 * Author URI: http://www.webascender.com
 */

/*
apply_filters( 'pmproz_added_order_data', array $data, MemberOrder object $order, int $order-&gt;user_id );

apply_filters( 'pmproz_updated_order_data', array $data, MemberOrder object $order, int $order-&gt;user_id );

apply_filters( 'pmproz_after_change_membership_level_data', array $data, int $level_id, int $user_id, int $cancel_level );

apply_filters( 'pmproz_after_checkout_data', array $data, int $user_id, object $level, MemberOrder object $order );

apply_filters( 'pmproz_prepare_request_webhook', $options[ $hook . '_url' ], $data );

*/

  /*
  echo '<pre>';
  echo 'added_order_data';
  print_r($data);
  echo '</pre>';
  die();
  */

function standardize_data_fields($data, $user_id){
  global $wpdb;
  
  $user = get_userdata( $user_id );
  $data['wp_user_id'] = $user_id;
  $data['wp_username'] = $user->user_login;
  $e_mail = strtolower($user->user_email);
  $e_mail = trim($e_mail);
  $data['wp_email'] = $e_mail;
  $data['wp_first_name'] = $user->first_name;
  $data['wp_last_name'] = $user->last_name;
  
  $level = pmpro_getMembershipLevelForUser($user_id);
  
  if($level == false){
    $data['wp_membership_id'] = 0;
		$sqlQuery = "SELECT status FROM {$wpdb->pmpro_memberships_users} WHERE user_id = {$user_id} AND status NOT LIKE 'active' ORDER BY id DESC LIMIT 1";
		$data['wp_membership_status'] = $wpdb->get_var( $sqlQuery );    
  }else{
    $data['wp_membership_id'] = $level->ID;   //some of his code this object has ->id and sometimes both. beware.
    $data['wp_membership_status'] = 'active';  
  }

  return $data;
}


function hook_pmp_added_order_data( $data, $order, $user_id ) {
  $data = standardize_data_fields($data,$user_id);
  return $data;
}
add_filter('pmproz_added_order_data', 'hook_pmp_added_order_data', 10, 3);

function hook_pmp_updated_order_data( $data, $order, $user_id ) {
  $data = standardize_data_fields($data,$user_id);
  return $data;
}
add_filter('pmproz_updated_order_data', 'hook_pmp_updated_order_data',10,3);


function hook_pmp_change_membership_level_data($data, $level_id, $user_id, $cancel_level){
  $data = standardize_data_fields($data,$user_id);
  return $data;
}
add_filter('pmproz_after_change_membership_level_data', 'hook_pmp_change_membership_level_data',10,4);










 ?>