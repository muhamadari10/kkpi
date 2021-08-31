<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

namespace Navij\Libraries;

use Illuminate\Database\Capsule\Manager as Capsule;
use User_menu as User_menu;
use UserGroupPermission as UserGroupPermission;
use User as User;
use UserGroup as UserGroup;
use Group as Group;
use MethodAccess as MethodAccess;
use Permission as Permission;
use UserRegionMst as UserRegionMst;

class Template
{
    private $data;
    private $js_file;
    private $css_file;
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
    }

    public function show( $folder, $page, $data=null, $base=true, $header=true, $menu=true, $js='', $css='', $plugin_js, $plugin_css, $body_class = "", $custom_class = "")
    {

        if ( ! file_exists('application/modules/'.$folder.'/views/'.$page.'.php') )
        {
            show_404();
        }
        else
        {
            $this->js_file[] = $js;
            $this->data = $data;
            $this->load_css($css);
            $this->load_plugin_css($plugin_css);
            $this->load_JS($js);
            $this->load_plugin_js($plugin_js);

            $this->data['body_class']   = $body_class;
            $this->data['custom_class'] = $custom_class;
            $this->data['header']       = ($header)?$this->init_header():'';
            $this->data['menu']         = ($menu)?$this->init_menu():'';
            $this->data['base_top']     = ($base)?'<div id="base">':'';
            $this->data['content']      = $this->CI->load->view($folder.'/'.$page.'.php', $this->data, true);
            $this->data['base_bottom']  = ($base)?'</div>':'';

            $this->CI->load->view('theme.php', $this->data);
        }
    }

    public function login($user)
    {

        $user_region = array();

        $get_userdata = UserGroup::with(['user', 'group', 'pjp'])
                            ->whereHas('user', function($qr) use ($user){
                                $qr->where('username', $user['username'])
                                    ->where('password', sha1($user['password']))
                                    ->where('active', 1);
                            })->where('default_user', 1)
                            ->first();

        // dd($user_region);

        if ( (bool) $get_userdata ) {

            $ids = $get_userdata->user->id;

            // $get_region = UserRegionMst::with(['user_group'])
            //                 ->whereHas('user_group', function($sq) use($ids){
            //                     $sq->where('user_id', $ids);
            //                 })->get();

            // if ( $get_region->count() > 0 ) {
                
            //     foreach ($get_region as $key => $value) {
                    
            //         $user_region[$key]['province_id'] = $value->province_id;
            //         $user_region[$key]['district_id'] = $value->district_id;
                    
            //     }
                
            // } else {
                
            //     $user_region = array();

            // }

            $last_login = User::find($ids);
            $last_login->last_login = date('Y-m-d H:i:s');

            if ( $last_login->save() ) {

                $session_data = array(
                    'user_id' => $get_userdata->user->id,
                    'username' => $get_userdata->user->username,
                    'name' => $get_userdata->user->full_name,
                    'group_id' => $get_userdata->group_id,
                    'pjp_id' => $get_userdata->pjp_id,
                    'pjp_name' => $get_userdata->pjp->pjp_name,
                    'group_name' => $get_userdata->group->name,
                    'group_desc' => $get_userdata->group->description,
                    'default_user' => $get_userdata->default_user,
                    'email' => $get_userdata->email,
                    'active' => $get_userdata->active
                );

            } else {
                
                return 0;

            }

            $this->CI->session->set_userdata($session_data);

            return 1;
        } else {
            return 0;
        }

    }

    public function limiter_access()
    {
        
        $where = function() { };

        if ( ($this->get_session('group_name') == 'manager') || $this->get_session('group_name') == 'coordinator' ) {
            
            $pjp_id = $this->get_session('pjp_id');

            $where = function($q) use($pjp_id) {
                
                $q->where('id', $pjp_id);

            };
    
        } else {

            $where = function($q) {
                
                $q->where('pjp_name', '<>', 'ALL');

            };

        }
        
        return $where;
        
    }

    public function logged_in(){
        return (bool) $this->CI->session->userdata('user_id');
    }

    public function get_group_id()
    {
        return $this->CI->session->userdata('group_id');
    }

    public function get_session($v) {
        
        return $this->CI->session->userdata($v);
    }

    public function check_method_access($access)
    {
        $method_access = MethodAccess::with(['group'])->where('group_id', $access['group_id'])->where('method', $access['method'])->where('active', 1)->get();
        
        return $method_access->count();
    }

    private function load_JS($js)
    {
        $this->data['js'] = '';

        if ( $js )
        {
            foreach( $js as $js_file )
            {
                $this->data['js'] .= "<script type='text/javascript' src=".js_url($js_file.'.js')."></script>". "\n";
            }
        }
    }

    private function load_plugin_js($plugin_js)
    {
        $this->data['plugin_js'] = '';

        if ( $plugin_js )
        {
            foreach( $plugin_js as $plugin_js_file ) {

                foreach ( $plugin_js_file['file'] as $file ) {

                    $this->data['plugin_js'] .= "<script type='text/javascript' src='". base_url() . "assets/" . $plugin_js_file['name'] . "/" . $file .".js'></script>". "\n";
                    
                }

            }
        }

    }

    private function load_plugin_css($plugin_css)
    {
        $this->data['plugin_css'] = '';

        if ( $plugin_css )
        {
            foreach( $plugin_css as $plugin_css_file ) {
                
                foreach ( $plugin_css_file['file'] as $file ) {

                    $this->data['plugin_css'] .= "<link rel='stylesheet' type='text/css' href='". base_url() . "assets/" . $plugin_css_file['name'] . "/" . $file .".css' />". "\n";
                }

            }
        }

    }

    private function load_css($css)
    {
        $this->data['css'] = '';

        if ( $css )
        {
            foreach( $css as $css_file )
            {
                $this->data['css'] .= "<link rel='stylesheet' type='text/css' href=".css_url($css_file.'.css').">". "\n";
            }
        }
    }

    private function init_header()
    {

        $userdata = Group::where('id', $this->CI->session->userdata('group_id'))->first();

        $html_header  = '';
        $html_header .= '<header class="main-header">

                            <!-- Logo -->
                            <a href="'. base_url('Dashboard') .'" class="logo">
                                <!-- mini logo for sidebar mini 50x50 pixels -->
                                <span class="logo-mini"><b>KPPIP</b></span>
                                <!-- logo for regular state and mobile devices -->
                                <span class="logo-lg"><b>KPPIP</b></span>
                            </a>

                            <!-- Header Navbar: style can be found in header.less -->
                            <nav class="navbar navbar-static-top">
                                <!-- Sidebar toggle button-->
                                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                                    <span class="sr-only">Toggle navigation</span>
                                </a>
                                <!-- Navbar Right Menu -->
                                <div class="navbar-custom-menu">
                                    <ul class="nav navbar-nav">
                                        <!-- User Account: style can be found in dropdown.less -->
                                        <li class="dropdown user user-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="' . base_url() . 'assets/img/kppip-logo.png" class="user-image" style="width: 60px !important; filter: drop-shadow(2px 2px 3px #fff);" alt="User Image">
                                            <span class="hidden-xs">' . $this->CI->session->userdata('name') . '</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!-- User image -->
                                                <li class="user-header">
                                                    <img src="' . base_url() . 'assets/img/kppip-logo.png" class="img-circle" style="width: 190px !important; filter: drop-shadow(2px 2px 3px #fff);" alt="User Image">

                                                    <p>
                                                    ' . $this->CI->session->userdata('name') . '
                                                    </p>
                                                </li>
                                                <!-- Menu Footer-->
                                                <li class="user-footer">
                                                    <div class="pull-right">
                                                    <a href="' . base_url('Auth/auth/logout') . '" class="btn btn-default btn-flat">Sign out</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </header>';

        return $html_header;
    }

    private function init_menu()
    {

        $user_id = $this->CI->session->userdata('user_id');
        $group_id = $this->CI->session->userdata('group_id');

        $head_menu = Permission::with(['menu'])->whereHas('menu', function( $q ){
						$q->where('parent_menu', '=', NULL)->where('active', 1);
                    })->where('group_id', $group_id)->get();

        $html = '';
        $html .= '<aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="' . base_url() . 'assets/img/kppip-logo.png" style="max-width:100%; height: 45px; width: 95px; filter: drop-shadow(2px 2px 3px #888);" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info" style="margin-left: 40px;">
                        <p>' . $this->CI->session->userdata('name') . '</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                        ';

        foreach($head_menu as $key => $val) {

            $user_permission = UserGroupPermission::with(['menu', 'user_group'])
                        ->whereHas('user_group', function($q)  use( $user_id, $group_id) {
                            $q->where('user_id', $user_id)
                                ->where('group_id', $group_id);
                        })->where('menu_id', $val->menu->id)->first();

            if ( $user_permission === NULL ) {

                $session_data = array(
                    'error_status' => 'Please set Your Role Access first!'
                );

                $this->CI->session->set_userdata($session_data);
                
                show_404();

            }
            

            $detail_menu = Permission::with(['menu'])->whereHas('menu', function($q_m) use($user_permission){
                $q_m->where('parent_menu', $user_permission->menu->id)->where('active', 1);
            })->where('group_id', $group_id)->orderBy('order_idx', 'asc');

            $get_menu = $detail_menu->get();


            $count_num = $get_menu->count();

            if($count_num > 0) {

                $html .= '  <li class="treeview">
                                <a href="#">
                                    <i class="' . $user_permission->menu->icon_class . '"></i> <span>' . $user_permission->menu->name . '</span>
                                    <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">';

                foreach ($get_menu as $detkey => $detval) {
                
                    $html .= '          <li>
                                            <a href="' . base_url($detval->menu->url) . '">
                                                <i class="fa fa-circle-o"></i>' . $detval->menu->name . '
                                            </a>
                                        </li>';

                }

                $html .= '      </ul>
                            </li>';

            } else {

                $html .= '  <li>
                                <a href="' . base_url($user_permission->menu->url) . '">
                                    <i class="' . $user_permission->menu->icon_class . '"></i> <span>' . $user_permission->menu->name . '</span>
                                </a>
                            </li>';

            }
        }

        $html .= '      </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>';

        return $html;
    }

}
