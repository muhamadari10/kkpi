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
use ScheduleMst as ScheduleMst;
use FundIndicationMst as FundIndicationMst;
use IssueMst as IssueMst;
use ProjectImageMst as ProjectImageMst;
use RiskMst as RiskMst;
use SectorMst as SectorMst;
use UnitMst as UnitMst;
use IslandMst as IslandMst;
use ProvinceMst as ProvinceMst;
use StatusCodeMst as StatusCodeMst;

use Navij\Libraries\Template as Template;


class Project_model extends Eloquent{

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

    private function project_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];

        if ( isset($_GET['extra_search']) ) {

            $exsearch = $_GET['extra_search'];
        
            if ( $exsearch['projectFt'] != '' ) {
                $oprt_project = '=';
            } else {
                $oprt_project = '<>';
            }

            if ( $exsearch['sectorFt'] != '' ) {
                $oprt_sector = '=';
            } else {
                $oprt_sector = '<>';
            }

            if ( $exsearch['statusCodeFt'] != '' ) {
                $oprt_status_code = '=';
            } else {
                $oprt_status_code = '<>';
            }
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_project, $oprt_status_code, $exsearch) {

                $ds->where('id', $oprt_project, $exsearch['projectFt'])
                    ->where('sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('status_code_id', $oprt_status_code, $exsearch['statusCodeFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $where_has_limiter = $this->template->limiter_access();

        $q_data = ProjectMst::with(['sector', 'unit', 'pjp', 'status_code'])
                    ->whereHas('pjp', $where_has_limiter)->where($where_has);
        $val = $_GET['search']['value'];


        // dd($q_data);
        if(!empty($val))
            $q_data->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true' 
                        && $v['data'] != 'action'
                        && $v['data'] != 'icon'
                        && $v['data'] != 'id'
                        && $v['data'] != 'unit_id'
                        && $v['data'] != 'unit_name'
                        && $v['data'] != 'status_code_name'
                        && $v['data'] != 'fund_indication_name'
                        && $v['data'] != 'fund_indication_array_name'
                        && $v['data'] != 'fund_indication_array_id'
                        ) {

                            if ( $v['data'] == 'pjp_name' ) {
                                
                                $ds->whereHas('pjp', function($q) use($v, $search){
                                    $q->orWhere('pjp_name', 'LIKE', '%'.$search.'%');
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
            $this->data[$key]['icon'] = '<i data-toogle="tooltip" title="Multi Proyek" class="glyphicon glyphicon-plus"></i>';
            $this->data[$key]['external_code'] = $value->external_code;
            $this->data[$key]['project_name'] = $value->project_name;
            $this->data[$key]['sector_id'] = $value->sector_id;
            $this->data[$key]['sector_name'] = $value->sector->sector_name;
            $this->data[$key]['status_code_id'] = $value->status_code_id;
            $this->data[$key]['status_code_name'] = $value->status_code->status_code_name;
            // $this->data[$key]['fund_indication_id'] = $value->fund_indication_id;

            $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($value->fund_indication_id))->get();

            $fund_indication_temp = '';
            $fund_indication_temp_array = array();

            foreach ($get_fund_indication as $key_fund => $value_fund) {

                $fund_indication_temp .= '- ' . $value_fund->fund_indication_name . '<br />';
                $fund_indication_temp_array[$key_fund]['id'] = $value_fund->id;
                $fund_indication_temp_array[$key_fund]['name'] = $value_fund->fund_indication_name;
                
            }

            $this->data[$key]['fund_indication_name'] = nl2br($fund_indication_temp);
            $this->data[$key]['fund_indication_array'] = $fund_indication_temp_array;
            $this->data[$key]['currency'] = $value->currency;
            $this->data[$key]['total_fund'] = $value->total_fund;
            $this->data[$key]['pjp_id'] = $value->pjp->id;
            $this->data[$key]['pjp_name'] = $value->pjp->pjp_name;
            $this->data[$key]['contact_person'] = $value->contact_person;
            $this->data[$key]['output'] = $value->output;
            $this->data[$key]['unit_id'] = $value->unit_id;
            $this->data[$key]['unit_name'] = $value->unit->unit_name;
            $this->data[$key]['description'] = $value->description;
            $this->data[$key]['status'] = $value->status;
            $this->data[$key]['total_fund_apbnd'] = $value->total_fund_apbnd;
            $this->data[$key]['total_fund_bumnd'] = $value->total_fund_bumnd;
            $this->data[$key]['total_fund_swasta'] = $value->total_fund_swasta;
            $this->data[$key]['province_id'] = $value->province_id;
            $this->data[$key]['province_name'] = $value->province->province_name;
            $this->data[$key]['island_id'] = $value->island_id;
            $this->data[$key]['island_name'] = $value->island->island_name;
            $this->data[$key]['transaction_date'] = date('m/d/Y', strtotime($value->transaction_date));
            $this->data[$key]['construction_date'] = date('m/d/Y', strtotime($value->construction_date));
            $this->data[$key]['operation_date'] = date('m/d/Y', strtotime($value->operation_date));
            $this->data[$key]['start_date'] = date('m/d/Y', strtotime($value->start_date));
            $this->data[$key]['start_date'] = date('m/d/Y', strtotime($value->start_date));
            $this->data[$key]['end_date'] = date('m/d/Y', strtotime($value->end_date));
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" data-toggle="tooltip" title="View dan Edit" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = ProjectMst::with(['pjp', 'sector', 'unit', 'status_code'])
            ->whereHas('pjp', $where_has_limiter)
            ->where($where_has)
            ->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'action'
                        && $v['data'] != 'icon'
                        && $v['data'] != 'id'
                        && $v['data'] != 'unit_id'
                        && $v['data'] != 'unit_name'
                        && $v['data'] != 'status_code_name'
                        && $v['data'] != 'fund_indication_name'
                        && $v['data'] != 'fund_indication_array_name'
                        && $v['data'] != 'fund_indication_array_id'
                        ) {

                            if ( $v['data'] == 'pjp_name' ) {
                                
                                $ds->whereHas('pjp', function($q) use($v, $search){
                                    $q->orWhere('pjp_name', 'LIKE', '%'.$search.'%');
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
                ProjectMst::with(['pjp', 'sector', 'unit', 'status_code'])
                    ->whereHas('pjp', $where_has_limiter)->where($where_has)->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                ProjectMst::with(['pjp', 'sector', 'unit', 'status_code'])
                    ->whereHas('pjp', $where_has_limiter)->where($where_has)->count()
            ),
            'data' => $this->data
        );

        return $this->res;
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

    private function project_detail_list()
    {
        
        $project_id = $_POST['id'];

        $q_data = ProjectDet::with(['sector', 'unit', 'pjp', 'status_code', 'project_mst'])
                    ->where('project_mst_id', $project_id)->get();

        // dd($q_data);

        foreach ($q_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['external_code'] = $value->external_code;
            $this->data[$key]['project_name'] = $value->project_name;
            $this->data[$key]['sector_id'] = $value->sector_id;
            $this->data[$key]['sector_name'] = $value->sector->sector_name;
            $this->data[$key]['status_code_id'] = $value->status_code->status_code_id;
            $this->data[$key]['status_code_name'] = $value->status_code->status_code_name;
            // $this->data[$key]['fund_indication_id'] = $value->fund_indication_id;

            $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($value->fund_indication_id))->get();

            $fund_indication_temp = '';
            $fund_indication_temp_array = array();

            foreach ($get_fund_indication as $key_fund => $value_fund) {

                $fund_indication_temp .= '- ' . $value_fund->fund_indication_name . '<br />';
                $fund_indication_temp_array[$key_fund]['id'] = $value_fund->id;
                $fund_indication_temp_array[$key_fund]['name'] = $value_fund->fund_indication_name;
                
            }

            $this->data[$key]['fund_indication_name'] = nl2br($fund_indication_temp);
            $this->data[$key]['fund_indication_array'] = $fund_indication_temp_array;
            $this->data[$key]['currency'] = $value->currency;
            $this->data[$key]['total_fund'] = $value->total_fund;
            $this->data[$key]['pjp_id'] = $value->pjp->id;
            $this->data[$key]['pjp_name'] = $value->pjp->pjp_name;
            $this->data[$key]['contact_person'] = $value->contact_person;
            $this->data[$key]['output'] = $value->output;
            $this->data[$key]['unit_id'] = $value->unit_id;
            $this->data[$key]['unit_name'] = $value->unit->unit_name;
            $this->data[$key]['description'] = $value->description;
            $this->data[$key]['status'] = $value->status;
            $this->data[$key]['total_fund_apbnd'] = $value->total_fund_apbnd;
            $this->data[$key]['total_fund_bumnd'] = $value->total_fund_bumnd;
            $this->data[$key]['total_fund_swasta'] = $value->total_fund_swasta;
            $this->data[$key]['province_id'] = $value->province_id;
            $this->data[$key]['province_name'] = $value->province->province_name;
            $this->data[$key]['island_id'] = $value->island_id;
            $this->data[$key]['island_name'] = $value->island->island_name;
            $this->data[$key]['transaction_date'] = date('m/d/Y', strtotime($value->transaction_date));
            $this->data[$key]['construction_date'] = date('m/d/Y', strtotime($value->construction_date));
            $this->data[$key]['operation_date'] = date('m/d/Y', strtotime($value->operation_date));
            $this->data[$key]['start_date'] = date('m/d/Y', strtotime($value->start_date));
            $this->data[$key]['start_date'] = date('m/d/Y', strtotime($value->start_date));
            $this->data[$key]['end_date'] = date('m/d/Y', strtotime($value->end_date));
            // $multi_proyek_data = json_encode($this->data[$key]);
            $this->data[$key]['action'] = '<div class="btn-group">
                <button onclick="_updateMultiProject('. $value->id .')" type="button" data-toggle="tooltip" title="View dan Edit" class="btn btn-warning btn-flat update-multi-project-row"><i class="fa fa-edit"></i></button>
                <button onclick="_deleteMultiProject(' . $value->id . ')" type="button" data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-flat multi-delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            
        }
        
        // dd($this->data);

        if ( count($q_data) > 0 ) {
            
            $this->res = array(
                'status' => true,
                'message' => 'Success',
                'data' => $this->data
            );

        } else {

            $this->res = array(
                'status' => false,
                'message' => 'Data kosong.',
                'data' => $this->data
            );

        }
        
        return $this->res;

    }

    private function get_multi_project()
    {
        
        $project_id = $_POST['id'];

        $q_data = ProjectDet::with(['sector', 'unit', 'pjp', 'status_code', 'project_mst'])
                    ->where('id', $project_id)->first();

        // dd($q_data);

        if ( count($q_data) > 0 ) {
            
            
            $this->data['id'] = $q_data->id;
            $this->data['external_code'] = $q_data->external_code;
            $this->data['project_mst_id'] = $q_data->project_mst_id;
            $this->data['project_mst_name'] = $q_data->project_mst->project_name;
            $this->data['project_name'] = $q_data->project_name;
            $this->data['sector_id'] = $q_data->sector_id;
            $this->data['sector_name'] = $q_data->sector->sector_name;
            $this->data['status_code_id'] = $q_data->status_code_id;
            $this->data['status_code_name'] = $q_data->status_code->status_code_name;

            $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($q_data->fund_indication_id))->get();

            $fund_indication_temp = '';
            $fund_indication_temp_array = array();

            foreach ($get_fund_indication as $key_fund => $value_fund) {

                $fund_indication_temp .= '- ' . $value_fund->fund_indication_name . '<br />';
                $fund_indication_temp_array[$key_fund]['id'] = $value_fund->id;
                $fund_indication_temp_array[$key_fund]['name'] = $value_fund->fund_indication_name;
                
            }

            $this->data['fund_indication_name'] = nl2br($fund_indication_temp);
            $this->data['fund_indication_array'] = $fund_indication_temp_array;
            $this->data['currency'] = $q_data->currency;
            $this->data['total_fund'] = $q_data->total_fund;
            $this->data['pjp_id'] = $q_data->pjp->id;
            $this->data['pjp_name'] = $q_data->pjp->pjp_name;
            $this->data['contact_person'] = $q_data->contact_person;
            $this->data['output'] = $q_data->output;
            $this->data['unit_id'] = $q_data->unit_id;
            $this->data['unit_name'] = $q_data->unit->unit_name;
            $this->data['description'] = $q_data->description;
            $this->data['status'] = $q_data->status;
            $this->data['total_fund_apbnd'] = $q_data->total_fund_apbnd;
            $this->data['total_fund_bumnd'] = $q_data->total_fund_bumnd;
            $this->data['total_fund_swasta'] = $q_data->total_fund_swasta;
            $this->data['province_id'] = $q_data->province_id;
            $this->data['province_name'] = $q_data->province->province_name;
            $this->data['island_id'] = $q_data->island_id;
            $this->data['island_name'] = $q_data->island->island_name;
            $this->data['transaction_date'] = date('m/d/Y', strtotime($q_data->transaction_date));
            $this->data['construction_date'] = date('m/d/Y', strtotime($q_data->construction_date));
            $this->data['operation_date'] = date('m/d/Y', strtotime($q_data->operation_date));
            $this->data['start_date'] = date('m/d/Y', strtotime($q_data->start_date));
            $this->data['start_date'] = date('m/d/Y', strtotime($q_data->start_date));
            $this->data['end_date'] = date('m/d/Y', strtotime($q_data->end_date));
            

            $this->res = array(
                'status' => true,
                'message' => 'Success',
                'data' => $this->data
            );

        } else {

            $this->res = array(
                'status' => false,
                'message' => 'Data kosong.',
                'data' => $this->data
            );

        }
        
        return $this->res;

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

    private function status_code_option()
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

        // $where_has_limiter = $this->template->limiter_access();

        $get_data = StatusCodeMst::where('status_code_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->status_code_name;

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

    private function island_option()
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

        $get_data = IslandMst::where('island_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->island_name;

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

    private function fund_indication_option()
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

        $get_data = FundIndicationMst::where('fund_indication_name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->fund_indication_name;

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

    private function unit_option()
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

        $get_data = UnitMst::where('simbol', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->simbol;

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

    private function create_project()
    {
        
        // dd($_POST);

        try {

            $check_project_exist = ProjectMst::select('id')
                                    ->where('external_code', $_POST['externalCode'])
                                    ->where('project_name', $_POST['projectName'])
                                    ->get();

            if ( $check_project_exist->count() < 1 ) {

                $project_store = new ProjectMst();
                $project_store->external_code = $_POST['externalCode'];
                $project_store->project_name = $_POST['projectName'];
                $project_store->sector_id = $_POST['sectorOpt'];
                $project_store->fund_indication_id = json_encode($_POST['fundIndicationOpt']);
                $project_store->currency = $_POST['currency'];
                $project_store->total_fund = $_POST['totalFund'];
                $project_store->status_code_id = $_POST['statusCodeOpt'];
                $project_store->pjp_id = $_POST['pjpOpt'];
                $project_store->contact_person = $_POST['contactPerson'];
                $project_store->output = $_POST['output'];
                $project_store->unit_id = $_POST['unitOpt'];
                $project_store->description = $_POST['description'];
                $project_store->status = $_POST['status'];
                $project_store->total_fund_apbnd = $_POST['totalFundApbnd'];
                $project_store->total_fund_bumnd = $_POST['totalFundBumnd'];
                $project_store->total_fund_swasta = $_POST['totalFundSwasta'];
                $project_store->province_id = $_POST['provinceOpt'];
                $project_store->island_id = $_POST['islandOpt'];
                $project_store->start_date = date('Y-m-d', strtotime($_POST['startDate']) );
                $project_store->transaction_date = date('Y-m-d', strtotime($_POST['transactionDate']) );
                $project_store->construction_date = date('Y-m-d', strtotime($_POST['constructionDate']) );
                $project_store->operation_date = date('Y-m-d', strtotime($_POST['operationDate']) );
                $project_store->end_date = date('Y-m-d', strtotime($_POST['endDate']) );
                
                if ($project_store->save()) {
                    
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

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data tersebut sudah tersimpan sebelumnya, mohon gunakan data yg lain.',
                    'data' => $this->data
                );

            }
            
        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }

    private function create_multi_project()
    {
        
        // dd($_POST);

        try {

            $check_project_exist = ProjectDet::select('id')
                                    ->where('external_code', $_POST['externalCode'])
                                    ->where('project_name', $_POST['projectName'])
                                    ->get();

            if ( $check_project_exist->count() < 1 ) {

                $project_store = new ProjectDet();
                $project_store->project_mst_id = $_POST['projectOpt'];
                $project_store->external_code = $_POST['externalCode'];
                $project_store->project_name = $_POST['projectName'];
                $project_store->sector_id = $_POST['sectorOpt'];
                $project_store->fund_indication_id = json_encode($_POST['fundIndicationOpt']);
                $project_store->currency = $_POST['currency'];
                $project_store->total_fund = $_POST['totalFund'];
                $project_store->status_code_id = $_POST['statusCodeOpt'];
                $project_store->pjp_id = $_POST['pjpOpt'];
                $project_store->contact_person = $_POST['contactPerson'];
                $project_store->output = $_POST['output'];
                $project_store->unit_id = $_POST['unitOpt'];
                $project_store->description = $_POST['description'];
                $project_store->status = $_POST['status'];
                $project_store->total_fund_apbnd = $_POST['totalFundApbnd'];
                $project_store->total_fund_bumnd = $_POST['totalFundBumnd'];
                $project_store->total_fund_swasta = $_POST['totalFundSwasta'];
                $project_store->province_id = $_POST['provinceOpt'];
                $project_store->island_id = $_POST['islandOpt'];
                $project_store->start_date = date('Y-m-d', strtotime($_POST['startDate']) );
                $project_store->transaction_date = date('Y-m-d', strtotime($_POST['transactionDate']) );
                $project_store->construction_date = date('Y-m-d', strtotime($_POST['constructionDate']) );
                $project_store->operation_date = date('Y-m-d', strtotime($_POST['operationDate']) );
                $project_store->end_date = date('Y-m-d', strtotime($_POST['endDate']) );
                
                if ($project_store->save()) {
                    
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

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data tersebut sudah tersimpan sebelumnya, mohon gunakan data yg lain.',
                    'data' => $this->data
                );

            }
            
        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }

    private function update_project()
    {
        
        // dd($_POST);

        try {

            $check_project_exist = ProjectMst::select('id')
                                    ->where('id', $_POST['id'])
                                    ->get();

            if ( $check_project_exist->count() > 0 ) {

                $project_store = ProjectMst::find($_POST['id']);
                $project_store->external_code = $_POST['externalCode'];
                $project_store->project_name = $_POST['projectName'];
                $project_store->sector_id = $_POST['sectorOpt'];
                $project_store->fund_indication_id = json_encode($_POST['fundIndicationOpt']);
                $project_store->currency = $_POST['currency'];
                $project_store->total_fund = $_POST['totalFund'];
                $project_store->status_code_id = $_POST['statusCodeOpt'];
                $project_store->pjp_id = $_POST['pjpOpt'];
                $project_store->contact_person = $_POST['contactPerson'];
                $project_store->output = $_POST['output'];
                $project_store->unit_id = $_POST['unitOpt'];
                $project_store->description = $_POST['description'];
                $project_store->status = $_POST['status'];
                $project_store->total_fund_apbnd = $_POST['totalFundApbnd'];
                $project_store->total_fund_bumnd = $_POST['totalFundBumnd'];
                $project_store->total_fund_swasta = $_POST['totalFundSwasta'];
                $project_store->province_id = $_POST['provinceOpt'];
                $project_store->island_id = $_POST['islandOpt'];
                $project_store->start_date = date('Y-m-d', strtotime($_POST['startDate']) );
                $project_store->transaction_date = date('Y-m-d', strtotime($_POST['transactionDate']) );
                $project_store->construction_date = date('Y-m-d', strtotime($_POST['constructionDate']) );
                $project_store->operation_date = date('Y-m-d', strtotime($_POST['operationDate']) );
                $project_store->end_date = date('Y-m-d', strtotime($_POST['endDate']) );

                if ($project_store->save()) {
                    
                    $this->res = array(
                        'status' => 200,
                        'message' => 'Data berhasil diupdate.',
                    );
                    
                } else {
                    
                    $this->res = array(
                        'status' => 404,
                        'message' => 'Data gagal diupdate.',
                    );
    
                }

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data tersebut sudah tersimpan sebelumnya, mohon gunakan data yg lain.',
                );

            }
            
        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }

    private function update_multi_project()
    {
        
        // dd($_POST);

        try {

            $check_project_exist = ProjectDet::select('id')
                                    ->where('id', $_POST['id'])
                                    ->where('project_mst_id', $_POST['projectOpt'])
                                    ->get();
            // dd($check_project_exist->count());
            if ( $check_project_exist->count() > 0 ) {

                $project_store = ProjectDet::find($_POST['id']);
                $project_store->external_code = $_POST['externalCode'];
                $project_store->project_name = $_POST['projectName'];
                $project_store->sector_id = $_POST['sectorOpt'];
                $project_store->fund_indication_id = json_encode($_POST['fundIndicationOpt']);
                $project_store->currency = $_POST['currency'];
                $project_store->total_fund = $_POST['totalFund'];
                $project_store->status_code_id = $_POST['statusCodeOpt'];
                $project_store->pjp_id = $_POST['pjpOpt'];
                $project_store->contact_person = $_POST['contactPerson'];
                $project_store->output = $_POST['output'];
                $project_store->unit_id = $_POST['unitOpt'];
                $project_store->description = $_POST['description'];
                $project_store->status = $_POST['status'];
                $project_store->total_fund_apbnd = $_POST['totalFundApbnd'];
                $project_store->total_fund_bumnd = $_POST['totalFundBumnd'];
                $project_store->total_fund_swasta = $_POST['totalFundSwasta'];
                $project_store->province_id = $_POST['provinceOpt'];
                $project_store->island_id = $_POST['islandOpt'];
                $project_store->start_date = date('Y-m-d', strtotime($_POST['startDate']) );
                $project_store->transaction_date = date('Y-m-d', strtotime($_POST['transactionDate']) );
                $project_store->construction_date = date('Y-m-d', strtotime($_POST['constructionDate']) );
                $project_store->operation_date = date('Y-m-d', strtotime($_POST['operationDate']) );
                $project_store->end_date = date('Y-m-d', strtotime($_POST['endDate']) );

                if ($project_store->save()) {
                    
                    $this->res = array(
                        'status' => 200,
                        'message' => 'Data berhasil diupdate.',
                    );
                    
                } else {
                    
                    $this->res = array(
                        'status' => 404,
                        'message' => 'Data gagal diupdate.',
                    );
    
                }

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data tersebut belum tersedia, mohon periksa data Anda kembali.',
                );

            }
            
        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => $e->getMessage()
            );

        }

        return $this->res;

    }
    
    // private function update_multi_project()
    // {
        
    //     // var_dump(json_encode($_POST['fundIndicationOptMul']));
    //     // dd($_POST);

    //     try {

    //         $check_project_exist = ProjectDet::select('id')
    //                                 ->where('id', $_POST['detId'])
    //                                 ->get();

    //         if ( $check_project_exist->count() > 0 ) {

    //             $project_store = ProjectDet::find($_POST['detId']);
    //             // $project_store->project_mst_id = $_POST['projectMstId'];
    //             $project_store->external_code = $_POST['externalCodeMul'];
    //             $project_store->project_name = $_POST['projectNameMul'];
    //             $project_store->sector_id = $_POST['sectorOptMul'];
    //             $project_store->fund_indication_id = json_encode($_POST['fundIndicationOptMul']);
    //             $project_store->currency = $_POST['currencyMul'];
    //             $project_store->total_fund = $_POST['totalFundMul'];
    //             $project_store->total = $_POST['totalMul'];
    //             $project_store->pjp_id = $_POST['pjpOptMul'];
    //             $project_store->contact_person = $_POST['contactPersonMul'];
    //             $project_store->output = $_POST['outputMul'];
    //             $project_store->unit_id = $_POST['unitOptMul'];
    //             $project_store->funder = $_POST['funderMul'];
    //             $project_store->description = $_POST['descriptionMul'];
    //             $project_store->start_date = date('Y-m-d', strtotime($_POST['startDateMul']) );
    //             $project_store->transaction_date = date('Y-m-d', strtotime($_POST['transactionDateMul']) );
    //             $project_store->construction_date = date('Y-m-d', strtotime($_POST['constructionDateMul']) );
    //             $project_store->operation_date = date('Y-m-d', strtotime($_POST['operationDateMul']) );
    //             $project_store->end_date = date('Y-m-d', strtotime($_POST['endDateMul']) );
    //             $project_store->signature_date = date('Y-m-d', strtotime($_POST['signatureDateMul']) );
    //             $project_store->effective_date = date('Y-m-d', strtotime($_POST['effectiveDateMul']) );
                
    //             if ($project_store->save()) {
                    
    //                 $this->res = array(
    //                     'status' => 200,
    //                     'message' => 'Data berhasil disimpan.',
    //                     'data' => $this->data
    //                 );
                    
    //             } else {
                    
    //                 $this->res = array(
    //                     'status' => 404,
    //                     'message' => 'Data gagal disimpan.',
    //                     'data' => $this->data
    //                 );
    
    //             }

    //         } else {

    //             $this->res = array(
    //                 'status' => 404,
    //                 'message' => 'Data tersebut sudah tersimpan sebelumnya, mohon gunakan data yg lain.',
    //                 'data' => $this->data
    //             );

    //         }
            
    //     } catch (Exception $e) {
            
    //         $this->res = array(
    //             'status' => 500,
    //             'message' => $e->getMessage()
    //         );

    //     }

    //     return $this->res;

    // }

    private function delete_project()
    {
        // try {

            $schedule_del = ScheduleMst::where('project_mst_id', $_POST['id']);

            if ( $schedule_del->count() > 0 ) {
                
                $schedule_del->delete();
                
            }
            
            $risk_del = RiskMst::where('project_mst_id', $_POST['id']);

            if ( $risk_del->count() > 0 ) {
                
                $risk_del->delete();
                
            }
            
            $issue_del = IssueMst::where('project_mst_id', $_POST['id']);
            
            if ( $issue_del->count() > 0 ) {
                
                $issue_del->delete();

            }
            
            $image_del = ProjectImageMst::where('project_mst_id', $_POST['id']);
            
            if ( $image_del->count() > 0 ) {
                
                $image_id = array();

                foreach ($image_del as $key => $value) {
                    $image_id[$key] = $value->id;
                }
                
                $image_del->delete();

                $this->delete_uploaded_project();

            }
            
            $project_det_del = ProjectDet::where('project_mst_id', $_POST['id']);

            if ( $project_det_del->count() > 0 ) {
                
                $project_det_del->delete();

            }

            $project_del = ProjectMst::find($_POST['id']);
            $project_del->delete();
            $this->res = array("status" => true, "message" => "Data berhasil dihapus." );

        // } catch(Exception $e){
            
        //     $this->res = array(
        //         'status' => 500,
        //         'message' => "Data Proyek sedang digunakan."
        //     );

        // }
        
        return  $this->res;
    }

    private function delete_multi_project()
    {
        try {
            
            $project_det_del = ProjectDet::where('id', $_POST['id']);

            if ( $project_det_del->count() > 0 ) {
                
                $project_det_del->delete();

            }

            $this->res = array("status" => true, "message" => "Data berhasil dihapus." );

        } catch(Exception $e){
            
            $this->res = array(
                'status' => 500,
                'message' => "Terjadi gangguan pada jaringan."
            );

        }
        
        return  $this->res;
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
