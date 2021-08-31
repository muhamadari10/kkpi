<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

date_default_timezone_set('Asia/Jakarta');

defined('BASEPATH') OR exit('No direct script access allowed');
use Navij\Libraries\Template as Template;
use Illuminate\Database\Capsule\Manager as Capsule;

class Private_Controller extends MX_Controller
{
  protected $data;
  protected $primary;
  protected $template;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();

    $this->template = new Template();

    if (!$this->template->logged_in())
      redirect('auth/login');
    elseif(!$this->check_module())
      show_404();

  }

  public function render($folder, $page, $data=null, $base=true, $header=true, $menu=true, $js='', $css='', $plugin_js='', $plugin_css='', $body_class = "", $custom_class = ""){
  
    try{
      
      $this->template->show($folder, $page, $data, $base, $header, $menu, $js, $css, $plugin_js, $plugin_css, $body_class, $custom_class);

    } catch(Exception $e) {
      
      show_404();

    }
  
  
  }

  public function get_sess($v)
  {
    return $this->template->get_session($v);
  }

  public function check_module()
  {
    $method_pass = array('grid','ajax');
    if(in_array($this->router->fetch_method(),$method_pass) == false){

        $group = $this->template->get_group_id();
        $path   = explode('/',$this->router->directory);
        $method = $path[2].'/'.$this->router->fetch_class().'/'.$this->router->fetch_method();

        $access = array(
          'group_id' => $group,
          'method' => $method
        );

        // dd(($this->template->check_method_access($access) > 0)?true:false);

        return ($this->template->check_method_access($access) > 0)?true:false;

    } else {
      if(  !$this->input->is_ajax_request())
        show_404();
      else
        return true;
    }
  }

  public function button_access()
  {

  }
}
