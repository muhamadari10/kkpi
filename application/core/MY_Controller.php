<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require APPPATH."third_party/MX/Controller.php";
    
    class MY_Controller extends MX_Controller {

        /**
         *  __construct
         * 
         * Class Constructor    PHP 5+
         * 
         * @access    public
         * @return    void
         */

        protected $data;
        
        // public function MY_Controller()
        // {
        //     parent::__construct();
        // }
        function __construct()
	    {
            
        }
    }
?>