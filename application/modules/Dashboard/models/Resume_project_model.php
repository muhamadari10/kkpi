<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

// ------------------ Eloquent Model -------------------- //

use ProjectMst as ProjectMst;
use FundIndicationMst as FundIndicationMst;

use Navij\Libraries\Template as Template;

class Resume_project_model extends Eloquent{

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


    private function project_list_v2(){

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
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_project, $oprt_pjp, $exsearch) {

                $ds->where('id', $oprt_project, $exsearch['projectFt'])
                    ->where('sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $where_has_limiter = $this->template->limiter_access();

        $q_data = ProjectMst::with(['sector', 'unit', 'pjp'])
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
            $this->data[$key]['external_code'] = $value->external_code;
            $this->data[$key]['project_name'] = $value->project_name;
            $this->data[$key]['sector_id'] = $value->sector_id;
            $this->data[$key]['sector_name'] = $value->sector->sector_name;

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
                <button type="button" data-toggle="tooltip" title="View" class="btn btn-warning btn-flat view-row"><i class="fa fa-search-plus"></i></button>
            </div>';

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = ProjectMst::with(['pjp', 'sector', 'unit'])
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
                ProjectMst::with(['pjp', 'sector', 'unit'])
                    ->whereHas('pjp', $where_has_limiter)->where($where_has)->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                ProjectMst::with(['pjp', 'sector', 'unit'])
                    ->whereHas('pjp', $where_has_limiter)->where($where_has)->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }
    
    private function project_list(){

        $pjpId = $_POST['pjpId'];
        $projectId = $_POST['projectId'];
        $sectorId = $_POST['sectorId'];

        if ( isset($projectId) && isset($sectorId) && isset($pjpId) ) {
            
            $where_has_limiter = $this->template->limiter_access();

            $data_in = ProjectMst::with(['sector', 'unit', 'pjp'])
                        ->where('id', $projectId)
                        ->where('sector_id', $sectorId)
                        ->whereHas('pjp', $where_has_limiter)
                        ->whereHas('pjp', function($q) use($pjpId){
                            $q->where('pjp_id', $pjpId);
                        })
                        ->first();

            if ( count($data_in) == 1 ) {
                
                
                $this->data['id'] = $data_in->id;
                $this->data['external_code'] = $data_in->external_code;
                $this->data['project_name'] = $data_in->project_name;
                $this->data['sector_id'] = $data_in->sector_id;
                $this->data['sector_name'] = $data_in->sector->sector_name;
                // $this->data['fund_indication_id'] = $value->fund_indication_id;

                $get_fund_indication = FundIndicationMst::select('*')
                                        ->whereIn('id', json_decode($data_in->fund_indication_id))
                                        ->get();

                $fund_indication_temp = '';
                $fund_indication_temp_array = array();

                foreach ($get_fund_indication as $key_fund => $value_fund) {

                    $fund_indication_temp .= '- ' . $value_fund->fund_indication_name . '<br />';
                    $fund_indication_temp_array[$key_fund]['id'] = $value_fund->id;
                    $fund_indication_temp_array[$key_fund]['name'] = $value_fund->fund_indication_name;
                    
                }

                $this->data['fund_indication_name'] = nl2br($fund_indication_temp);
                $this->data['fund_indication_array'] = $fund_indication_temp_array;
                $this->data['currency'] = $data_in->currency;
                $this->data['total_fund'] = $data_in->total_fund;
                $this->data['pjp_id'] = $data_in->pjp->id;
                $this->data['pjp_name'] = $data_in->pjp->pjp_name;
                $this->data['contact_person'] = $data_in->contact_person;
                $this->data['output'] = $data_in->output;
                $this->data['unit_id'] = $data_in->unit_id;
                $this->data['unit_name'] = $data_in->unit->unit_name;
                $this->data['description'] = $data_in->description;
                $this->data['status'] = $data_in->status;
                $this->data['total_fund_apbnd'] = $data_in->total_fund_apbnd;
                $this->data['total_fund_bumnd'] = $data_in->total_fund_bumnd;
                $this->data['total_fund_swasta'] = $data_in->total_fund_swasta;
                $this->data['province_id'] = $data_in->province_id;
                $this->data['province_name'] = $data_in->province->province_name;
                $this->data['island_id'] = $data_in->island_id;
                $this->data['island_name'] = $data_in->island->island_name;
                $this->data['transaction_date'] = date('d F Y', strtotime($data_in->transaction_date));
                $this->data['construction_date'] = date('d F Y', strtotime($data_in->construction_date));
                $this->data['operation_date'] = date('d F Y', strtotime($data_in->operation_date));
                $this->data['start_date'] = date('d F Y', strtotime($data_in->start_date));
                $this->data['start_date'] = date('d F Y', strtotime($data_in->start_date));
                $this->data['end_date'] = date('d F Y', strtotime($data_in->end_date));

                $this->res = array(
                    'status' => true,
                    'message' => 'Success',
                    'data' => $this->data
                );

            } else {
                $this->res = array(
                    'status' => false,
                    'message' => 'Data kosong',
                    'data' => $this->data
                );
            }

        } else {
            
            $this->res = array(
                'status' => false,
                'message' => 'Error',
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
