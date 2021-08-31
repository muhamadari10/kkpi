<?php defined("BASEPATH") OR exit("No direct script access allowed");

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

class Island extends Private_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		// page specific plugin scripts
		$js = array(
			"class",
			"modules/Administration/Island",
		);

		$plugin_js = array(
			array( // sum of file
				"name" => "bower_components", // name path
				"file" => array(
					"datatables.net/js/jquery.dataTables.min", // array file
					"datatables.net-bs/js/dataTables.bootstrap.min", // array file
					"select2/dist/js/select2.full.min", // array file
					"bootstrap-datepicker/dist/js/bootstrap-datepicker.min", // array file
					"PACE/pace.min"
				)
			),
			array( // sum of file
				"name" => "plugins", // name path
				"file" => array(
					"sweetalert/sweetalert.min", // array file
				)
			)
		);
		
		// page specific plugin styles
		$css = array();

		$plugin_css = array(
			array( // sum of file
				"name" => "bower_components", // name path
				"file" => array(
					"datatables.net-bs/css/dataTables.bootstrap.min", // array file
					"bootstrap-datepicker/dist/css/bootstrap-datepicker.min", // array file
					"select2/dist/css/select2.min", // array file
				)
			),
			array( // sum of file
				"name" => "plugins", // name path
				"file" => array(
					"sweetalert/sweetalert", // array file
					"pace/pace.min"
				)
			)
		);

		$data = array();

		$this->render("Administration","island_view", $data, true, true, true, $js, $css, $plugin_js, $plugin_css, "", "hold-transition skin-blue sidebar-mini", "wrapper");
	}

	public function grid($grid)
	{
		$this->load->model("Island_model");
		echo json_encode($this->Island_model->call_method($grid,"grid"));
	}

	public function ajax($action)
	{
		$this->load->model("Island_model");
		echo json_encode($this->Island_model->call_method($action,"action"));
	}

}
