<?php defined("BASEPATH") OR exit("No direct script access allowed");

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

class Project_img_create extends Private_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		// page specific plugin scripts
		$js = array(
			"class",
			"modules/Project/ProjectImgCreate",
		);

		$plugin_js = array(
			array( // sum of file
				"name" => "bower_components", // name path
				"file" => array(
					"PACE/pace.min", // array file
				)
			),
			array( // sum of file
				"name" => "plugins", // name path
				"file" => array(
					"dropzone/dropzone", // array file
				)
			)
		);
		
		// page specific plugin styles
		$css = array(
			'file-uploader'
		);

		$plugin_css = array(
			array( // sum of file
				"name" => "plugins", // name path
				"file" => array(
					"dropzone/dropzone.min", // array file
					"dropzone/basic.min", // array file
					"pace/pace.min", // array file
				)
			)
		);

		$data = array();

		$this->render("Project","project_img_create_view", $data, true, true, true, $js, $css, $plugin_js, $plugin_css, "", "hold-transition skin-blue sidebar-mini", "wrapper");
	}

	public function grid($grid)
	{
		$this->load->model("Project_img_create_model");
		echo json_encode($this->Project_img_create_model->call_method($grid,"grid"));
	}

	public function ajax($action)
	{
		$this->load->model("Project_img_create_model");
		echo json_encode($this->Project_img_create_model->call_method($action,"action"));
	}

}
