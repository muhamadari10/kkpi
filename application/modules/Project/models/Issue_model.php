<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;

use ProjectMst as ProjectMst;
use PjpMst as PjpMst;
use IssueMst as IssueMst;
use ProvinceMst as ProvinceMst;
use SeverityLevelMst as SeverityLevelMst;
use FrequencyLevelMst as FrequencyLevelMst;
use IssueTypeMst as IssueTypeMst;

use Navij\Libraries\Template as Template;


class Issue_model extends Eloquent{

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

    private function issue_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];

        if ( isset($_GET['extra_search']) ) {

            $exsearch = $_GET['extra_search'];
        
            if ( $exsearch['projectFt'] != '' ) {
                $oprt_project = '=';
            } else {
                $oprt_project = '<>';
            }

            if ( $exsearch['phaseFt'] != '' ) {
                $oprt_phase = '=';
            } else {
                $oprt_phase = '<>';
            }

            if($_SESSION['pjp_name'] != 'ALL') // custom code
                $exsearch['stakeholderFt'] = $_SESSION['pjp_id']; // default stakeholder

            if ( $exsearch['activityFt'] != '' ) {
                $oprt_activity = '=';
            } else {
                $oprt_activity = '<>';
            }

            if ( $exsearch['stakeholderFt'] != '' ) {
                $oprt_stakeholder = 'like';
            } else {
                $oprt_stakeholder = '<>';
            }
            
            
            $where_has = function($ds) use($oprt_activity, $oprt_stakeholder, $oprt_phase, $oprt_project, $exsearch) {

                $ds->where('project_mst_id', $oprt_project, $exsearch['projectFt'])
                ->where('phase_id', $oprt_phase, $exsearch['phaseFt'])
                ->where('activity_id', $oprt_activity, $exsearch['activityFt'])
                ->where('stakeholder', $oprt_stakeholder, '%' . $exsearch['stakeholderFt'] . '%' );
                
            };


        } else {
            
            $where_has = function ($ds) { // add script custom query
                if($_SESSION['pjp_name'] !== 'ALL')
                    $ds->where('stakeholder', 'like', '%' . '"'.$_SESSION['pjp_id'].'"' . '%' );
            };

        }

        $q_data = IssueMst::with(['project_mst', 'issue_type', 'project_mst.province', 'severity_level', 'frequency_level', 'activity', 'phase'])->where($where_has);
        $val = $_GET['search']['value'];


        // dd($q_data);
        if(!empty($val))
            $q_data->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true' 
                        && $v['data'] != 'action'
                        && $v['data'] != 'stakeholder_name'
                        ) {

                            if ( $v['data'] == 'project_name' ) {
                                
                                $ds->whereHas('project_mst', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'severity_level_name' ) {
                                
                                $ds->whereHas('severity_level', function($q) use($v, $search){
                                    $q->orWhere('severity_level_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'level' ) {
                                
                                $ds->whereHas('severity_level', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'severity_level_issue' ) {
                                
                                $ds->whereHas('severity_level', function($q) use($v, $search){
                                    $q->orWhere('severity_level_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'frequency_level_name' ) {
                                
                                $ds->whereHas('frequency_level', function($q) use($v, $search){
                                    $q->orWhere('frequency_level_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'issue_type_name' ) {
                                
                                $ds->whereHas('issue_type', function($q) use($v, $search){
                                    $q->orWhere('issue_type_name', 'LIKE', '%'.$search.'%');
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
            $this->data[$key]['issue_description'] = $value->issue_description;
            $this->data[$key]['project_mst_id'] = $value->project_mst_id;
            $this->data[$key]['project_name'] = $value->project_mst->project_name;
            $this->data[$key]['external_code'] = $value->project_mst->external_code;

            $get_pjp = PjpMst::select('*')->whereIn('id', json_decode($value->stakeholder))->get();
            
            $pjp_temp = '';
            $pjp_temp_array = '';

            foreach ($get_pjp as $key_pjp => $value_pjp) {
                
                $pjp_temp .= '- ' . $value_pjp->pjp_name . '<br />';
                $pjp_temp_array[$key_pjp]['id'] = $value_pjp->id;
                $pjp_temp_array[$key_pjp]['name'] = $value_pjp->pjp_name;
                
            }

            $this->data[$key]['stakeholder_name'] = nl2br($pjp_temp);
            $this->data[$key]['stakeholder_array'] = $pjp_temp_array;

            $this->data[$key]['impact_duration'] = $value->impact_duration;
            $this->data[$key]['level'] = $value->severity_level->level;
            $this->data[$key]['phase_id'] = $value->phase_id;
            $this->data[$key]['phase_name'] = $value->phase->phase_name;
            $this->data[$key]['activity_id'] = $value->activity_id;
            $this->data[$key]['activity_name'] = $value->activity->activity_name;
            $this->data[$key]['severity_level_id'] = $value->severity_level_id;
            $this->data[$key]['severity_level_name'] = $value->severity_level->severity_level_name;
            $this->data[$key]['severity_level_issue'] = nl2br('Level ' . $value->severity_level->level . '<br/>' . $value->severity_level->severity_level_name);
            $this->data[$key]['frequency_level_id'] = $value->frequency_level_id;
            $this->data[$key]['frequency_level_name'] = $value->frequency_level->frequency_level_name;
            $this->data[$key]['case_issue_date'] = date('m/d/Y', strtotime($value->case_issue_date));
            $this->data[$key]['planning_solve_issue_date'] = date('m/d/Y', strtotime($value->planning_solve_issue_date));
            $this->data[$key]['province_id'] = $value->project_mst->province_id;
            $this->data[$key]['province_name'] = $value->project_mst->province->province_name;
            $this->data[$key]['issue_type_id'] = $value->issue_type_id;
            $this->data[$key]['issue_type_name'] = $value->issue_type->issue_type_name;
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = IssueMst::with(['project_mst', 'issue_type', 'project_mst.province', 'severity_level', 'frequency_level', 'activity', 'phase'])
            ->where($where_has)
            ->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'action'
                        && $v['data'] != 'stakeholder_name'
                        ) {

                            if ( $v['data'] == 'project_name' ) {
                                
                                $ds->whereHas('project_mst', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'severity_level_name' ) {
                                
                                $ds->whereHas('severity_level', function($q) use($v, $search){
                                    $q->orWhere('severity_level_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'level' ) {
                                
                                $ds->whereHas('severity_level', function($q) use($v, $search){
                                    $q->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'severity_level_issue' ) {
                                
                                $ds->whereHas('severity_level', function($q) use($v, $search){
                                    $q->orWhere('severity_level_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'frequency_level_name' ) {
                                
                                $ds->whereHas('frequency_level', function($q) use($v, $search){
                                    $q->orWhere('frequency_level_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'issue_type_name' ) {
                                
                                $ds->whereHas('issue_type', function($q) use($v, $search){
                                    $q->orWhere('issue_type_name', 'LIKE', '%'.$search.'%');
                                });

                            } else {
                                
                                $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                            }
                            
                        }

                }
            });

        $this->res = array(
            'recordsTotal' => isset($count)?$count->count():intval(
                IssueMst::with(['project_mst', 'issue_type', 'project_mst.province', 'severity_level', 'frequency_level', 'activity', 'phase'])->where($where_has)->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                IssueMst::with(['project_mst', 'issue_type', 'project_mst.province', 'severity_level', 'frequency_level', 'activity', 'phase'])->where($where_has)->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_issue()
    {
        
        // dd($_POST);

        try {

            // $check_issue_exist = IssueMst::select('id')
            //                         ->where('issue_description', $_POST['issueDescription'])
            //                         ->get();

            // if ( $check_issue_exist->count() < 1 ) {

                $issue_store = new IssueMst();
                $issue_store->project_mst_id = $_POST['projectOpt'];
                $issue_store->issue_description = $_POST['issueDescription'];
                $issue_store->impact_duration = $_POST['impactDuration'];
                $issue_store->severity_level_id = $_POST['severityLevelOpt'];
                $issue_store->frequency_level_id = $_POST['frequencyLevelOpt'];
                $issue_store->activity_id = $_POST['activityOpt'];
                $issue_store->phase_id = $_POST['phaseOpt'];
                $issue_store->issue_type_id = $_POST['issueTypeOpt'];
                $issue_store->stakeholder = json_encode($_POST['stakeholderOpt']);
                $issue_store->planning_solve_issue_date = date('Y-m-d', strtotime($_POST['planningSolveIssueDate']));
                $issue_store->case_issue_date = date('Y-m-d', strtotime($_POST['caseIssueDate']));
                
                if ($issue_store->save()) {
                    
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

    private function update_issue()
    {
        
        // dd($_POST);

        try {

            // $check_issue_exist = IssueMst::select('id')
            //                         ->where('issue_description', $_POST['issueDescription'])
            //                         ->get();

            // if ( $check_issue_exist->count() < 1 ) {

                $issue_store = IssueMst::find($_POST['issueId']);
                $issue_store->project_mst_id = $_POST['projectOpt'];
                $issue_store->issue_description = $_POST['issueDescription'];
                $issue_store->impact_duration = $_POST['impactDuration'];
                $issue_store->severity_level_id = $_POST['severityLevelOpt'];
                $issue_store->frequency_level_id = $_POST['frequencyLevelOpt'];
                $issue_store->activity_id = $_POST['activityOpt'];
                $issue_store->phase_id = $_POST['phaseOpt'];
                $issue_store->issue_type_id = $_POST['issueTypeOpt'];
                $issue_store->stakeholder = json_encode($_POST['stakeholderOpt']);
                $issue_store->planning_solve_issue_date = date('Y-m-d', strtotime($_POST['planningSolveIssueDate']));
                $issue_store->case_issue_date = date('Y-m-d', strtotime($_POST['caseIssueDate']));
                
                if ($issue_store->save()) {
                    
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

    private function delete_issue()
    {

        $issue_del = IssueMst::find($_POST['id']);
        $issue_del->delete();
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

    private function issue_type_option()
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

        $get_data = IssueTypeMst::where('issue_type_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->issue_type_name;

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

    private function province_option()
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

        $get_data = ProvinceMst::where('province_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->province_name;

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
