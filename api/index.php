<?php

add_action( 'rest_api_init', 'mypwp_check_user');
function mypwp_check_user(){
    global $wpdb ; 


    // deb($_POST);exit();

    if(isset($_POST['user_email']) && $_POST['user_email']){
        $user = get_user_by('email', $_POST['user_email']);
    }else{
        return;
    }

    
    $GLOBALS['mypwp_temp_data']['mypwp_user'] = array();
    $GLOBALS['mypwp_temp_data']['mypwp_user']['ID'] = $user; 
    $GLOBALS['mypwp_temp_data']['mypwp_user']['MyTempData'] = get_user_meta( $user->ID, 'MyTempData', true ) ; 

    
    if($_POST['action'] && $_POST['action'] === 'GetPost'){
        require_once SVELTEKITAUTH_PATH . 'api/GetPost.php' ;
    }else{
        require_once SVELTEKITAUTH_PATH . 'api/'.$_POST['action'].'.php' ;
    }


    //http://demo.test/wp-json/api/v1/data
    //  register_rest_route( 'api/v1', '/data', array(
    
    //http://demo.test/wp-json/jwt-auth/data
    register_rest_route( 'jwt-auth', '/data', array(
        'methods' => 'POST',
        'callback' => 'mypwp_check_user_callback'
    ));

    // register_rest_route( 'api', '/data', array(
    //     'methods' => 'POST',
    //     'callback' => 'mypwp_check_user_callback'
    // ));



}

function mypwp_check_user_callback(){
    return json_encode($GLOBALS['mypwp_temp_data']); 
    // return json_encode("salam"); 
}



function my_customize_rest_cors() {
    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
    add_filter( 'rest_pre_serve_request', function( $value ) {
      header( 'Access-Control-Allow-Origin: *' );
      header( 'Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT' );
      header( 'Access-Control-Allow-Credentials: true' );
      header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization' );
      header( 'Access-Control-Expose-Headers: Link', false );
      return $value;
    } );
  }
  add_action( 'rest_api_init', 'my_customize_rest_cors', 15 );
  
  function add_cors_http_header(){
      header( 'Access-Control-Allow-Origin: *' );
      header( 'Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT' );
      header( 'Access-Control-Allow-Credentials: true' );
      header( 'Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization' );
      header( 'Access-Control-Expose-Headers: Link', false );
  }
  add_action('init','add_cors_http_header');
  
?>