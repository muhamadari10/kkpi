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
use PjpMst as PjpMst;
use ProjectImageMst as ProjectImageMst;
use SeverityLevelMst as SeverityLevelMst;
use FrequencyLevelMst as FrequencyLevelMst;
use ActivityMst as ActivityMst;
use PhaseMst as PhaseMst;

use Navij\Libraries\Template as Template;


class Project_img_model extends Eloquent{

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

    private function project_img_list(){
 
        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];
        
        
        $q_data = ProjectMst::with(['pjp', 'sector']);
        $val = $_GET['search']['value'];


        // dd($q_data);
        if(!empty($val))
            $q_data->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true' 
                        && $v['data'] != 'action'
                        && $v['data'] != 'project_img_name'
                        ) {
                            
                            if ( $v['data'] == 'pjp_name' ) {
                                
                                $ds->whereHas('pjp', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'sector_name' ) {
                                
                                $ds->whereHas('sector', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else {
                                
                                $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                            }

                        }

                }
            });

        $data_in = $q_data->take($_GET['length'])->offset($_GET['start'])->get();

        foreach ($data_in as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['project_name'] = $value->project_name;
            $this->data[$key]['external_code'] = $value->external_code;
            $this->data[$key]['pjp_name'] = $value->pjp->pjp_name;
            $this->data[$key]['sector_name'] = $value->sector->sector_name;
            $this->data[$key]['operation_date'] = date('d/m/Y', strtotime($value->operation_date));

            $get_project = $count_project = ProjectImageMst::select('id', 'project_mst_id', 'image')
                ->where('project_mst_id', $value->id)->orderBy(Capsule::raw('RAND()'))->limit(2)->get();

            $this->data[$key]['project_img_name'] = '';


            if ( $count_project->count() > 0 ) {

                foreach ($get_project as $ki => $vi) {

                    
                    $this->data[$key]['project_img_name'] .= '<img src="' . base_url() . 'images/project/' . $vi->image . '" class="img-responsive pad" />';
                    
                }
                
            } else {
                
                $this->data[$key]['project_img_name'] = 'No Images...';                

            }


            $this->data[$key]['action'] = '<div class="btn-group">
                <a data-toggle="tooltip" title="Lihat/Tambah Gambar" class="btn btn-danger btn-flat" href="' . base_url() . 'Project/Project_img_create?projectId=' . $value->id . '"><i class="fa fa-image"></i></a>
            </div>';
            
        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = ProjectMst::with(['pjp', 'sector'])
            ->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'action'
                        && $v['data'] != 'project_img_name'
                        ) {
                            
                            if ( $v['data'] == 'pjp_name' ) {
                                
                                $ds->whereHas('pjp', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'sector_name' ) {
                                
                                $ds->whereHas('sector', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else {
                                
                                $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                            }
                            
                        }

                }
            });

        $this->res = array(
            'recordsTotal' => isset($count)?$count->count():intval(
                ProjectMst::with(['pjp', 'sector'])
                    ->count()
                ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                ProjectMst::with(['pjp', 'sector'])
                    ->count()
                ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_project_img()
    {
        
        // dd($_POST);

        try {

            // $check_project_img_exist = Project_imgMst::select('id')
            //                         ->where('project_img_description', $_POST['project_imgDescription'])
            //                         ->get();

            // if ( $check_project_img_exist->count() < 1 ) {

                $project_img_store = new Project_imgMst();
                $project_img_store->project_mst_id = $_POST['projectOpt'];
                $project_img_store->project_img_description = $_POST['project_imgDescription'];
                $project_img_store->impact_duration = $_POST['impactDuration'];
                $project_img_store->severity_level_id = $_POST['severityLevelOpt'];
                $project_img_store->frequency_level_id = $_POST['frequencyLevelOpt'];
                $project_img_store->activity_id = $_POST['activityOpt'];
                $project_img_store->phase_id = $_POST['phaseOpt'];
                $project_img_store->stakeholder = json_encode($_POST['stakeholderOpt']);
                $project_img_store->planning_solve_project_img_date = date('Y-m-d', strtotime($_POST['planningSolveProject_imgDate']));
                $project_img_store->case_project_img_date = date('Y-m-d', strtotime($_POST['caseProject_imgDate']));
                
                if ($project_img_store->save()) {
                    
                    $this->res = array(
                        'status' => 200,
                        'message' => 'Data berhasil disimpan.',
                        'data' => $this->data
                    );
                    
                } else {
                    
                    $this->res = array(
                        'status' => 404,
                        'message' => 'Data gagal disimpan.',
                        'data' => $this->data
                    );
    
                }

            // } else {

            //     $this->res = array(
            //         'status' => 404,
            //         'message' => 'Data tersebut sudah tersimpan sebelumnya, mohon gunakan data yg lain.',
            //         'data' => $this->data
            //     );

            // }
            
        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }

    private function update_project_img()
    {
        
        // dd($_POST);

        try {

            // $check_project_img_exist = Project_imgMst::select('id')
            //                         ->where('project_img_description', $_POST['project_imgDescription'])
            //                         ->get();

            // if ( $check_project_img_exist->count() < 1 ) {

                $project_img_store = Project_imgMst::find($_POST['project_imgId']);
                $project_img_store->project_mst_id = $_POST['projectOpt'];
                $project_img_store->project_img_description = $_POST['project_imgDescription'];
                $project_img_store->impact_duration = $_POST['impactDuration'];
                $project_img_store->severity_level_id = $_POST['severityLevelOpt'];
                $project_img_store->frequency_level_id = $_POST['frequencyLevelOpt'];
                $project_img_store->activity_id = $_POST['activityOpt'];
                $project_img_store->phase_id = $_POST['phaseOpt'];
                $project_img_store->stakeholder = json_encode($_POST['stakeholderOpt']);
                $project_img_store->planning_solve_project_img_date = date('Y-m-d', strtotime($_POST['planningSolveProject_imgDate']));
                $project_img_store->case_project_img_date = date('Y-m-d', strtotime($_POST['caseProject_imgDate']));
                
                if ($project_img_store->save()) {
                    
                    $this->res = array(
                        'status' => 200,
                        'message' => 'Data berhasil disimpan.',
                        'data' => $this->data
                    );
                    
                } else {
                    
                    $this->res = array(
                        'status' => 404,
                        'message' => 'Data gagal disimpan.',
                        'data' => $this->data
                    );
    
                }

            // } else {

            //     $this->res = array(
            //         'status' => 404,
            //         'message' => 'Data tersebut sudah tersimpan sebelumnya, mohon gunakan data yg lain.',
            //         'data' => $this->data
            //     );

            // }
            
        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }

    private function delete_project_img()
    {

        $project_img_del = Project_imgMst::find($_POST['id']);
        $project_img_del->delete();
        $this->res = array("status" => true, "message" => "Data berhasil dihapus." );
        
        return  $this->res;
    }


    private function phase_option()
    {

        if (isset($_GET['q'])) {
            
            if ($_GET['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_GET['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = PhaseMst::where('phase_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->phase_name;

        }

        if ( count($this->data) > 0 ) {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => true,
                "message" => "Success"
            );

        } else {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => false,
                "message" => "Error"
            );

        }
        

    }


    private function activity_option()
    {

        if (isset($_GET['q'])) {
            
            if ($_GET['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_GET['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = ActivityMst::where('activity_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->activity_name;

        }

        if ( count($this->data) > 0 ) {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => true,
                "message" => "Success"
            );

        } else {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => false,
                "message" => "Error"
            );

        }
        

    }


    private function stakeholder_option()
    {

        if (isset($_GET['q'])) {
            
            if ($_GET['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_GET['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = PjpMst::where('pjp_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->pjp_name;

        }

        if ( count($this->data) > 0 ) {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => true,
                "message" => "Success"
            );

        } else {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => false,
                "message" => "Error"
            );

        }
        

    }

    private function project_option()
    {

        if (isset($_GET['q'])) {
            
            if ($_GET['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_GET['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = ProjectMst::where('project_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->project_name;

        }

        if ( count($this->data) > 0 ) {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => true,
                "message" => "Success"
            );

        } else {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => false,
                "message" => "Error"
            );

        }
        
    }


    private function frequency_level_option()
    {

        if (isset($_GET['q'])) {
            
            if ($_GET['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_GET['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = FrequencyLevelMst::where('frequency_level_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->frequency_level_name;

        }

        if ( count($this->data) > 0 ) {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => true,
                "message" => "Success"
            );

        } else {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => false,
                "message" => "Error"
            );

        }
        
    }

    private function severity_level_option()
    {

        if (isset($_GET['q'])) {
            
            if ($_GET['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_GET['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = SeverityLevelMst::where('severity_level_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->severity_level_name;

        }

        if ( count($this->data) > 0 ) {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => true,
                "message" => "Success"
            );

        } else {
            
            return $this->res = array(
                "data" => $this->data,
                "status" => false,
                "message" => "Error"
            );

        }
        
    }

}
