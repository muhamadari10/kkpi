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
use ScheduleMst as ScheduleMst;
use SectorMst as SectorMst;

use Navij\Libraries\Template as Template;


class Schedule_model extends Eloquent{

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

    private function schedule_list(){
 
        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];
        
        
        if ( isset($_GET['extra_search']) ) {

            $exsearch = $_GET['extra_search'];
        
            if ( $exsearch['projectFt'] != '' ) {
                $oprt_project = '=';
            } else {
                $oprt_project = '<>';
            }

            if ( $exsearch['pjpFt'] != '' ) {
                $oprt_pjp = '=';
            } else {
                $oprt_pjp = '<>';
            }

            if ( $exsearch['sectorFt'] != '' ) {
                $oprt_sector = '=';
            } else {
                $oprt_sector = '<>';
            }
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_pjp, $oprt_project, $exsearch) {

                $ds->where('project_mst_id', $oprt_project, $exsearch['projectFt'])
                ->where('pjp_id', $oprt_pjp, $exsearch['pjpFt'])
                ->where('sector_id', $oprt_sector, $exsearch['sectorFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $where_has_limiter = $this->template->limiter_access();
        

        $q_data = ScheduleMst::with(['project_mst', 'pjp', 'sector'])
                    ->whereHas('pjp', $where_has_limiter)
                    ->where($where_has);
        $val = $_GET['search']['value'];


        // dd($q_data);
        if(!empty($val))
            $q_data->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true' 
                        && $v['data'] != 'action'
                        ) {
                            
                            $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                        }

                }
            });

        $data_in = $q_data->take($_GET['length'])->offset($_GET['start'])->get();

        foreach ($data_in as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['schedule_activity_name'] = $value->schedule_activity_name;
            $this->data[$key]['schedule_status'] = $value->schedule_status;
            $this->data[$key]['start_plan_date'] = date('m/d/Y', strtotime($value->start_plan_date));
            $this->data[$key]['start_actual_date'] = date('m/d/Y', strtotime($value->start_actual_date));
            $this->data[$key]['end_actual_date'] = date('m/d/Y', strtotime($value->end_actual_date));
            $this->data[$key]['end_plan_date'] = date('m/d/Y', strtotime($value->end_plan_date));
            $this->data[$key]['deviation'] = $value->deviation;
            $this->data[$key]['sector_name'] = $value->sector->sector_name;
            $this->data[$key]['pjp_id'] = $value->pjp->id;
            $this->data[$key]['pjp_name'] = $value->pjp->pjp_name;
            $this->data[$key]['project_name'] = $value->project_mst->project_name;
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            
        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = ScheduleMst::with(['project_mst', 'pjp', 'sector'])
            ->whereHas('pjp', $where_has_limiter)
            ->where($where_has)
            ->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'action') {
                            
                            $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                        }

                }
            });

        $this->res = array(
            'recordsTotal' => isset($count)?$count->count():intval(
                ScheduleMst::with(['project_mst', 'pjp', 'sector'])
                    ->whereHas('pjp', $where_has_limiter)
                    ->where($where_has)->count()
                ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                ScheduleMst::with(['project_mst', 'pjp', 'sector'])
                    ->whereHas('pjp', $where_has_limiter)
                    ->where($where_has)->count()
                ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_schedule()
    {
        
        // dd($_POST);

        try {

            // $check_schedule_exist = ScheduleMst::select('id')
            //                         ->where('schedule_description', $_POST['scheduleDescription'])
            //                         ->get();

            // if ( $check_schedule_exist->count() < 1 ) {

                $schedule_store = new ScheduleMst();
                $schedule_store->project_mst_id = $_POST['projectOpt'];
                $schedule_store->pjp_id = $_POST['pjpOpt'];
                $schedule_store->sector_id = $_POST['sectorOpt'];
                $schedule_store->schedule_activity_name = $_POST['scheduleActivityName'];
                $schedule_store->schedule_status = $_POST['scheduleStatus'];
                $schedule_store->start_plan_date = date('Y-m-d', strtotime($_POST['startPlanDate']));
                $schedule_store->start_actual_date = date('Y-m-d', strtotime($_POST['startActualDate']));
                $schedule_store->end_plan_date = date('Y-m-d', strtotime($_POST['endPlanDate']));
                $schedule_store->end_actual_date = date('Y-m-d', strtotime($_POST['endActualDate']));
                $schedule_store->deviation = $_POST['deviation'];

                if ($schedule_store->save()) {
                    
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

    private function update_schedule()
    {
        
        // dd($_POST);

        try {

            // $check_schedule_exist = ScheduleMst::select('id')
            //                         ->where('schedule_description', $_POST['scheduleDescription'])
            //                         ->get();

            // if ( $check_schedule_exist->count() < 1 ) {

                $schedule_store = ScheduleMst::find($_POST['scheduleId']);
                $schedule_store->project_mst_id = $_POST['projectOpt'];
                $schedule_store->pjp_id = $_POST['pjpOpt'];
                $schedule_store->sector_id = $_POST['sectorOpt'];
                $schedule_store->schedule_activity_name = $_POST['scheduleActivityName'];
                $schedule_store->schedule_status = $_POST['scheduleStatus'];
                $schedule_store->start_plan_date = date('Y-m-d', strtotime($_POST['startPlanDate']));
                $schedule_store->start_actual_date = date('Y-m-d', strtotime($_POST['startActualDate']));
                $schedule_store->end_plan_date = date('Y-m-d', strtotime($_POST['endPlanDate']));
                $schedule_store->end_actual_date = date('Y-m-d', strtotime($_POST['endActualDate']));
                $schedule_store->deviation = $_POST['deviation'];

                if ($schedule_store->save()) {
                    
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

    private function delete_schedule()
    {

        $schedule_del = ScheduleMst::find($_POST['id']);
        $schedule_del->delete();
        $this->res = array("status" => true, "message" => "Data berhasil dihapus." );
        
        return  $this->res;
    }


    private function pjp_option()
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

        $where_has_limiter = $this->template->limiter_access();

        $get_data = PjpMst::where($where_has_limiter)
                        ->where('pjp_name', $oprt, $value)
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


    private function sector_option()
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

        $get_data = SectorMst::where('sector_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->sector_name;

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


}
