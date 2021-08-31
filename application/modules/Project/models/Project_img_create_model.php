<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

use ProjectMst as ProjectMst;
use ProjectImageMst as ProjectImageMst;

use Navij\Libraries\Template as Template;


class Project_img_create_model extends Eloquent{

    public function __construct() {
        parent::__construct();

        $this->template = new Template();

    }

    protected $data     = array();
    protected $return   = array();
    protected $res      = array("status" => false, "message" => "Error");

    //call_method Model
    public function call_method($method,$type){

        $this->$method();

        return $this->res;
    }

    private function uploaded_project_list(){

        $q_data = ProjectImageMst::select('*')->where('project_mst_id', $_POST['projectId'])->get();

        foreach ($q_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['img'] = $value->image;
            $this->data[$key]['url'] = base_url() . 'images/project/';
            $this->data[$key]['caption'] = $value->image_desc;
            $this->data[$key]['type'] = $value->type;
            $this->data[$key]['size'] = $value->size;

        }

        if ( count($q_data) > 0 ) {
            $this->res = array(
                'status' => true,
                'message' => 'Success',
                'data' => $this->data
            );
        } else {
            $this->res = array(
                'status' => false,
                'message' => 'Data masih kosong.',
                'data' => $this->data
            );
        }

        return $this->res;
    }

    private function upload_project_img()
    {
        
        // var_dump($_REQUEST);
        // dd($_FILES);

        try {

            $name     = $_FILES['file']['name'];
            $tmpName  = $_FILES['file']['tmp_name'];
            $error    = $_FILES['file']['error'];
            $size     = $_FILES['file']['size'];
            $ext      = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            
            // $targetPath =  base_url() . 'images' . date('Ymd') . $name;
            
            // var_dump($_FILES);
            // dd($tmpName);
            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if ( !in_array($ext, array('jpg','jpeg','png')) ) {
                        $valid = false;
                        $response = 'Invalid file extension.';
                    }
                    //validate file size
                    if ( $size/1024/1024 > 2 ) {
                        $valid = false;
                        $response = 'File size is exceeding maximum allowed size.';
                    }
                    //upload file
                    if ($valid) {

                        $date_now = date('YmdHis');
                        $random_number = rand(100,900);

                        $targetPath =  $_SERVER['DOCUMENT_ROOT'] . '/kppip/images/project/' . "PROJECT" . $date_now . $random_number . "." . $ext;
                        move_uploaded_file($tmpName,$targetPath);
                        chmod($targetPath, 0777);
                        
                        $save_project_img = new ProjectImageMst();
                        $save_project_img->project_mst_id = $_REQUEST['projectId'];
                        $save_project_img->image = "PROJECT" . $date_now . $random_number . "." . $ext;
                        $save_project_img->image_desc = "PROJECT" . $date_now . $random_number;
                        $save_project_img->type = $ext;
                        $save_project_img->size = $size;
                        $save_project_img->created_by = $this->template->get_session('user_id_fk');
                        $save_project_img->created_on = date('Y-m-d H:i:s');

                        if ( $save_project_img->save() ) {
                            
                            $valid = true;
                            $response = "File " . $save_project_img->caption    . " berhasil disimpan.";

                        } else {
                            
                            $valid = false;

                            $response = "File gagal disimpan.";

                        }
                        

                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $valid = false;
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $valid = false;                    
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $valid = false;

                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $valid = false;

                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $valid = false;

                    $response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $valid = false;

                    $response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $valid = false;

                    $response = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
                    break;
                default:
                    $valid = false;

                    $response = 'Unknown error';
                break;
            }

            $this->res = array(
                'status' => $valid,
                'message' => $response
            );
            

        } catch (Exception $e) {
            
            $this->res = array(
                
                'status' => false,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }

    private function delete_uploaded_project()
    {

        // dd($_POST);

        $check_data = $project_img_del = ProjectImageMst::where('image_desc', $_POST['id'])->where('project_mst_id', $_POST['projectId']);

        // dd($check_data->first());

        if( count($check_data->first()) > 0 ) {

            // if( $check_data_fish->count() > 0 ) {

            //     $this->res = array("status" => false, "message" => "Data masih digunakan" );

            // } else {

                // var_dump(file_exists( $_SERVER['DOCUMENT_ROOT'] . '/kppip/images/project/' . $file_exist ));

            $file_exist = $check_data->first()->image;
    
            if ( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/kppip/images/project/' . $file_exist )) {
                
                unlink( $_SERVER['DOCUMENT_ROOT'] . '/kppip/images/project/' . $file_exist );
                
                if ( $project_img_del->delete() ) {
    
                    $this->res = array("status" => true, "message" => "Data berhasil dihapus" );
                    
                } else {
                    
                    $this->res = array("status" => false, "message" => "Data gagal dihapus, data tidak ada" );
    
                }
    
    
            } else {
    
                $this->res = array("status" => false, "message" => "Data gagal dihapus. File gambar tidak ditemukan" );
                
            }

            // }
            
        } else {

            $this->res = array("status" => false, "message" => "Data gagal dihapus" );
            
        }
        
        return  $this->res;
    }

}
