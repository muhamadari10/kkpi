<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;

use ProjectMst as ProjectMst;
use ProjectDet as ProjectDet;
use PjpMst as PjpMst;
use IssueMst as IssueMst;
use ProvinceMst as ProvinceMst;
use SeverityLevelMst as SeverityLevelMst;
use FrequencyLevelMst as FrequencyLevelMst;
use SectorMst as SectorMst;

use Navij\Libraries\Template as Template;


class Achievement_project_report_model extends Eloquent{

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

    private function achievement_list(){

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

            if ( $exsearch['pjpFt'] != '' ) {
                $oprt_pjp = '=';
            } else {
                $oprt_pjp = '<>';
            }

            if ( $exsearch['provinceFt'] != '' ) {
                $oprt_province = '=';
            } else {
                $oprt_province = '<>';
            }
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_project, $oprt_pjp, $oprt_province, $exsearch) {

                $ds->where('sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('id', $oprt_project, $exsearch['projectFt'])
                    ->where('province_id', $oprt_province, $exsearch['provinceFt'])
                    ->where('pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function ($ds) { // add script custom query
                if($_SESSION['pjp_name'] !== 'ALL')
                    $ds->where('pjp_id', '=', $_SESSION['pjp_id'] );
            };

        }

        $q_data = ProjectMst::with(['pjp', 'sector', 'status_code'])->where($where_has);
        $val = $_GET['search']['value'];


        // dd($q_data);
        if(!empty($val))
            $q_data->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'id'
                        && $v['data'] != 'fund_indication_name'
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

        $last_id = 0;

        foreach ($data_in as $key => $value) {

            $q_data_det = ProjectDet::with(['pjp', 'sector', 'status_code'])->where('project_mst_id', $value->id)->where($where_has)->get();

            if ( $q_data_det->count() > 0 ) {

                $this->data[$last_id]['id'] = $value->id;
                $this->data[$last_id]['external_code'] = $value->external_code;
                $this->data[$last_id]['project_name'] = $value->project_name;
                $this->data[$last_id]['sector_id'] = $value->sector_id;
                $this->data[$last_id]['sector_name'] = $value->sector->sector_name;
                // $this->data[$key]['fund_indication_id'] = $value->fund_indication_id;
                
                $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($value->fund_indication_id))->get();
                
                $fund_indication_temp = '';

                foreach ($get_fund_indication as $key_fund => $value_fund) {
                    
                    $fund_indication_temp .= $value_fund->fund_indication_name . '<br />';
                    
                }

                $this->data[$last_id]['fund_indication_name'] = nl2br($fund_indication_temp);
                $this->data[$last_id]['currency'] = $value->currency;
                $this->data[$last_id]['total_fund'] = $value->total_fund;
                $this->data[$last_id]['pjp_id'] = $value->pjp_id;
                $this->data[$last_id]['status_code_name'] = $value->status_code->status_code_name;
                $this->data[$last_id]['pjp_name'] = $value->pjp->pjp_name;
                $this->data[$last_id]['contact_person'] = $value->contact_person;
                $this->data[$last_id]['output'] = $value->output;
                $this->data[$last_id]['status'] = $value->status;
                $this->data[$last_id]['description'] = $value->description;
                $this->data[$last_id]['transaction_date'] = date('m/d/Y', strtotime($value->transaction_date));
                $this->data[$last_id]['construction_date'] = date('m/d/Y', strtotime($value->construction_date));
                $this->data[$last_id]['operation_date'] = date('m/d/Y', strtotime($value->operation_date));
                $this->data[$last_id]['start_date'] = date('m/d/Y', strtotime($value->start_date));
                $this->data[$last_id]['start_date'] = date('m/d/Y', strtotime($value->start_date));
                $this->data[$last_id]['end_date'] = date('m/d/Y', strtotime($value->end_date));
                $this->data[$last_id]['project_status'] = 'PROYEK INDUK';

                $last_id++;

                foreach ($q_data_det as $key_det => $value_det) {
                
                    $this->data[$last_id]['id'] = $value_det->id;
                    $this->data[$last_id]['external_code'] = $value_det->external_code;
                    $this->data[$last_id]['project_name'] = $value_det->project_name;
                    $this->data[$last_id]['sector_id'] = $value_det->sector_id;
                    $this->data[$last_id]['sector_name'] = $value_det->sector->sector_name;
                    // $this->data[$key]['fund_indication_id'] = $value->fund_indication_id;
                    
                    $get_fund_indication_det = FundIndicationMst::select('*')->whereIn('id', json_decode($value_det->fund_indication_id))->get();
                    
                    $fund_indication_temp_det = '';

                    foreach ($get_fund_indication_det as $key_fund_det => $value_fund_det) {
                        
                        $fund_indication_temp_det .= $value_fund_det->fund_indication_name . '<br />';
                        
                    }

                    $this->data[$last_id]['fund_indication_name'] = nl2br($fund_indication_temp_det);
                    $this->data[$last_id]['currency'] = $value_det->currency;
                    $this->data[$last_id]['total_fund'] = $value_det->total_fund;
                    $this->data[$last_id]['pjp_id'] = $value_det->pjp_id;
                    $this->data[$last_id]['status_code_name'] = $value_det->status_code->status_code_name;
                    $this->data[$last_id]['pjp_name'] = $value_det->pjp->pjp_name;
                    $this->data[$last_id]['contact_person'] = $value_det->contact_person;
                    $this->data[$last_id]['output'] = $value_det->output;
                    $this->data[$last_id]['status'] = $value_det->status;
                    $this->data[$last_id]['description'] = $value_det->description;
                    $this->data[$last_id]['transaction_date'] = date('m/d/Y', strtotime($value_det->transaction_date));
                    $this->data[$last_id]['construction_date'] = date('m/d/Y', strtotime($value_det->construction_date));
                    $this->data[$last_id]['operation_date'] = date('m/d/Y', strtotime($value_det->operation_date));
                    $this->data[$last_id]['start_date'] = date('m/d/Y', strtotime($value_det->start_date));
                    $this->data[$last_id]['start_date'] = date('m/d/Y', strtotime($value_det->start_date));
                    $this->data[$last_id]['end_date'] = date('m/d/Y', strtotime($value_det->end_date));
                    $this->data[$last_id]['project_status'] = 'SUB PROYEK';
                    
                    $last_id++;
                
                }

            } else {
                
                $this->data[$last_id]['id'] = $value->id;
                $this->data[$last_id]['external_code'] = $value->external_code;
                $this->data[$last_id]['project_name'] = $value->project_name;
                $this->data[$last_id]['sector_id'] = $value->sector_id;
                $this->data[$last_id]['sector_name'] = $value->sector->sector_name;
                // $this->data[$key]['fund_indication_id'] = $value->fund_indication_id;
                
                $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($value->fund_indication_id))->get();
                
                $fund_indication_temp = '';

                foreach ($get_fund_indication as $key_fund => $value_fund) {
                    
                    $fund_indication_temp .= $value_fund->fund_indication_name . '<br />';
                    
                }

                $this->data[$last_id]['fund_indication_name'] = nl2br($fund_indication_temp);
                $this->data[$last_id]['currency'] = $value->currency;
                $this->data[$last_id]['total_fund'] = $value->total_fund;
                $this->data[$last_id]['pjp_id'] = $value->pjp_id;
                $this->data[$last_id]['status_code_name'] = $value->status_code->status_code_name;
                $this->data[$last_id]['pjp_name'] = $value->pjp->pjp_name;
                $this->data[$last_id]['contact_person'] = $value->contact_person;
                $this->data[$last_id]['output'] = $value->output;
                $this->data[$last_id]['status'] = $value->status;
                $this->data[$last_id]['description'] = $value->description;
                $this->data[$last_id]['transaction_date'] = date('m/d/Y', strtotime($value->transaction_date));
                $this->data[$last_id]['construction_date'] = date('m/d/Y', strtotime($value->construction_date));
                $this->data[$last_id]['operation_date'] = date('m/d/Y', strtotime($value->operation_date));
                $this->data[$last_id]['start_date'] = date('m/d/Y', strtotime($value->start_date));
                $this->data[$last_id]['start_date'] = date('m/d/Y', strtotime($value->start_date));
                $this->data[$last_id]['end_date'] = date('m/d/Y', strtotime($value->end_date));
                $this->data[$last_id]['project_status'] = 'PROYEK INDUK';

                $last_id++;

            }
            
        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = ProjectMst::with(['pjp', 'sector', 'status_code'])
            ->where($where_has)
            ->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'id'
                        && $v['data'] != 'fund_indication_name'
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
            'recordsTotal' => isset($count)?$count->count():intval(ProjectMst::with(['pjp', 'sector', 'status_code'])->where($where_has)->count()),
            'recordsFiltered' => isset($count)?$count->count():intval(ProjectMst::with(['pjp', 'sector', 'status_code'])->where($where_has)->count()),
            'data' => $this->data
        );

        return $this->res;
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

        $where_has_limiter = $this->template->limiter_access();

        $get_data = ProjectMst::whereHas('pjp', $where_has_limiter)
                        ->where('project_name', $oprt, $value)
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
