<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: text/html; charset=utf-8');
header("Access-Control-Request-Method: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Request-Headers: Content-Type");

date_default_timezone_set('Asia/Jakarta');

// use Navij\Libraries\Api_authentication as Api_authentication;
use Illuminate\Database\Capsule\Manager as Capsule;
use User as User;

class Api_Private_Controller extends MX_Controller
{
  protected $res = array('status' => false, 'message' => 'Please check your credentials!');
  protected $primary;

  public function __construct()
  {
    parent::__construct();


    if(!$this->check_api_logged_in())
      show_404();

  }

  private function check_api_logged_in()
  {

    $method_pass = array('grid','ajax');

    // dd($this->router->fetch_method());

    if(in_array($this->router->fetch_method(),$method_pass) == true){
      
      // dd($_POST);
      
      if (( ($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'GET') ) && empty($_POST)){
        
        $_POST = array_merge($_POST, (array) json_decode(trim(file_get_contents('php://input')), true));
        
        if (isset($_POST['data']['opt'])) {
          if ($_POST['data']['opt'] == 'config') {
            
            return true;
          
          } else {
            
            $q_user_logged_in = User::where(
              array(
                'username' => $_POST['account']['username'], 
                'password' => sha1('admin') 
              )
            )->first();

            if((bool)$q_user_logged_in){
              return true;
            } else {
              return false;
            }
          }

        } else {

          // dd($_POST);
          
          $q_user_logged_in = User::where(
            array(
              'username' => $_POST['account']['username'], 
              'password' => sha1('admin') 
            )
          )->first();
          
          if((bool)$q_user_logged_in){
            return true;
          } else {
            return false;
          }
          
        }

      }

    } else {
      return false;
    }

  }

}
