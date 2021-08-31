<?php defined("BASEPATH") OR exit("No direct script access allowed");

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

class Resume_project extends Private_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		// page specific plugin scripts
		$js = array(
			"class",
			"modules/Dashboard/ResumeProject",
		);

		$plugin_js = array(
			array( // sum of file
				"name" => "plugins", // name path
				"file" => array(
					// "jvectormap/jquery-jvectormap-1.2.2.min",
					// "jvectormap/jquery-jvectormap.id",
				)
			),
			array( // sum of file
				"name" => "bower_components", // name path
				"file" => array(
					// "morris.js/morris.min", // array file
					// "raphael/raphael.min", // array file
					"datatables.net/js/jquery.dataTables.min", // array file
					"datatables.net-bs/js/dataTables.bootstrap.min", // array file
					"select2/dist/js/select2.full.min", // array file
					// "datatables.net/js/jquery.dataTables.min", // array file
					// "datatables.net-bs/js/dataTables.bootstrap.min", // array file
					"PACE/pace.min", // array file
					// "jvectormap/jquery-jvectormap", // array file
				)
			),
		);
		
		// page specific plugin styles
		$css = array(
			'custom'
		);

		$plugin_css = array(
			array( // sum of file
				"name" => "bower_components", // name path
				"file" => array(
					// "jvectormap/jquery-jvectormap",
					"datatables.net-bs/css/dataTables.bootstrap.min", // array file
					// "morris.js/morris", // array file
					"select2/dist/css/select2.min", // array file
				)
			),
			array( // sum of file
				"name" => "plugins", // name path
				"file" => array(
					"pace/pace.min", // array file
				)
			)
			// array( // sum of file
			// 	"name" => "plugins", // name path
			// 	"file" => array(
			// 		"pace/pace.min", // array file
			// 		"jvectormap/jquery-jvectormap-1.2.2", // array file
			// 	)
			// )
		);

		$data = array();

		$this->render("Dashboard","resume_project_view", $data, true, true, true, $js, $css, $plugin_js, $plugin_css, "hold-transition skin-blue sidebar-mini", "wrapper");
	}	

	public function grid($grid)
	{
		$this->load->model("Resume_project_model");
		echo json_encode($this->Resume_project_model->call_method($grid,"grid"));
	}

	public function ajax($action)
	{
		$this->load->model("Resume_project_model");
		echo json_encode($this->Resume_project_model->call_method($action,"action"));
	}

}
