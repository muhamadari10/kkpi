<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

use \Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

// ------------------ Eloquent Model -------------------- //

use IssueMst as IssueMst;
use ProjectMst as ProjectMst;
use ProjectDet as ProjectDet;
use SectorMst as SectorMst;
use PjpMst as PjpMst;

use Navij\Libraries\Template as Template;


class Dashboard_model extends Eloquent{

    protected $data     = array();
    protected $return   = array();
    protected $res      = array("status" => false, "message" => "Error");

    public function __construct() {
        parent::__construct();

        $this->template = new Template();

    }

    //call_method Model
    public function call_method($method,$type){

        $this->$method();

        return $this->res;
    }

    private function activity_charts(){

        if ( isset($_POST['sectorFt']) && isset($_POST['pjpFt']) ) {

            $exsearch['sectorFt'] = $_POST['sectorFt'];
            $exsearch['pjpFt'] = $_POST['pjpFt'];

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
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_pjp, $exsearch) {

                $ds->where('sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $this->res = array(
            "data" => array(
                "design" => array(
                    "ids"    => 1,
                    "label" => "Perencanaan",
                    "value" => ProjectMst::select('id')->where('status_code_id', 1)->where($where_has)->get()->count()
                ),
                "preparation" => array(
                    "ids"    => 2,
                    "label" => "Penyiapan",
                    "value" => ProjectMst::select('id')->where('status_code_id', 2)->where($where_has)->get()->count()
                ),
                "transaction" => array(
                    "ids"    => 3,
                    "label" => "Transaksi",
                    "value" => ProjectMst::select('id')->where('status_code_id', 3)->where($where_has)->get()->count()
                ),
                "constructionAfter2019" => array(
                    "ids"    => 4,
                    "label" => "Konstruksi dan Akan Mulai Beroperasi setelah 2019",
                    "value" => ProjectMst::select('id')->where('status_code_id', 4)->where($where_has)->get()->count()
                ),
                "constructionOperation2019" => array(
                    "ids"    => 5,
                    "label" => "Konstruksi dan Akan Mulai Beroperasi di 2019",
                    "value" => ProjectMst::select('id')->where('status_code_id', 5)->where($where_has)->get()->count()
                ),
                "constructionOperation2018" => array(
                    "ids"    => 6,
                    "label" => "Selesai",
                    "value" => ProjectMst::select('id')->where('status_code_id', 6)->where($where_has)->get()->count()
                ),
                "constructionAndOperation" => array(
                    "ids"    => 7,
                    "label" => "Konstruksi dan Telah Mulai Beroperasi",
                    "value" => ProjectMst::select('id')->where('status_code_id', 7)->where($where_has)->get()->count()
                ),
            ),
            "status" => true,
            "message" => "Success"
        );

        // dd($this->data);


        return $this->res;
    }
    
    private function fund_indication_charts(){

        if ( isset($_POST['sectorFt']) && isset($_POST['pjpFt']) ) {

            $exsearch['sectorFt'] = $_POST['sectorFt'];
            $exsearch['pjpFt'] = $_POST['pjpFt'];

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
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_pjp, $exsearch) {

                $ds->where('sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $sum_apbnd = ProjectMst::select(Capsule::raw('SUM(total_fund_apbnd) AS sum_apbnd'))->where($where_has)->first();
        
        $sum_bumnd = ProjectMst::select(Capsule::raw('SUM(total_fund_bumnd) AS sum_bumnd'))->where($where_has)->first();
        
        $sum_swasta = ProjectMst::select(Capsule::raw('SUM(total_fund_swasta) AS sum_swasta'))->where($where_has)->first();
        

        $this->res = array(
            "data" => array(
                "apbnd" => array(
                    "label" => "APBN/APBD",
                    "value" => ($sum_apbnd->sum_apbnd == null)?0:$sum_apbnd->sum_apbnd
                ),
                "bumnd" => array(
                    "label" => "BUMN/BUMD",
                    "value" => ($sum_bumnd->sum_bumnd == null)?0:$sum_bumnd->sum_bumnd
                ),
                "swasta" => array(
                    "label" => "Swasta",
                    "value" => ($sum_swasta->sum_swasta == null)?0:$sum_swasta->sum_swasta
                ),
            ),
            "status" => true,
            "message" => "Success"
        );

        // dd($this->data);


        return $this->res;
    }

    
    private function issue_charts(){

        if ( isset($_POST['sectorFt']) && isset($_POST['pjpFt']) ) {

            $exsearch['sectorFt'] = $_POST['sectorFt'];
            $exsearch['pjpFt'] = $_POST['pjpFt'];

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
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_pjp, $exsearch) {

                $ds->where('project_mst.sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('project_mst.pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $this->res = array(
            "data" => array(
                "construction" => array(
                    "ids"    => 1,
                    "label" => "Konstruksi",
                    "value" => IssueMst::join('project_mst', 'project_mst.id', '=', 'issue.project_mst_id')
                                ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                                ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                                ->select('issue.id')
                                ->where('issue_type_id', 1)->where($where_has)->get()->count()
                ),
                "licensing" => array(
                    "ids"    => 2,
                    "label" => "Perijinan",
                    "value" => IssueMst::join('project_mst', 'project_mst.id', '=', 'issue.project_mst_id')
                                ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                                ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                                ->select('issue.id')
                                ->where('issue_type_id', 2)->where($where_has)->get()->count()
                ),
                "fund" => array(
                    "ids"    => 3,
                    "label" => "Pendanaan",
                    "value" => IssueMst::join('project_mst', 'project_mst.id', '=', 'issue.project_mst_id')
                                ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                                ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                                ->select('issue.id')
                                ->where('issue_type_id', 3)->where($where_has)->get()->count()
                ),
                "landacquisition" => array(
                    "ids"    => 4,
                    "label" => "Pembebasan Lahan",
                    "value" => IssueMst::join('project_mst', 'project_mst.id', '=', 'issue.project_mst_id')
                                ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                                ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                                ->select('issue.id')
                                ->where('issue_type_id', 4)->where($where_has)->get()->count()
                ),
                "planning" => array(
                    "ids"    => 5,
                    "label" => "Perencanaan dan Penyiapan",
                    "value" => IssueMst::join('project_mst', 'project_mst.id', '=', 'issue.project_mst_id')
                                ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                                ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                                ->select('issue.id')
                                ->where('issue_type_id', 5)->where($where_has)->get()->count()
                ),
            ),
            "status" => true,
            "message" => "Success"
        );

        // dd($this->data);


        return $this->res;
    }

    
    private function project_detail_list(){


        if ( isset($_POST['sectorFt']) && isset($_POST['pjpFt']) ) {

            $exsearch['sectorFt'] = $_POST['sectorFt'];
            $exsearch['pjpFt'] = $_POST['pjpFt'];

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
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_pjp, $exsearch) {

                $ds->where('sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        // dd($_POST);

        $status_code_name = '';

        $where_has_limiter = $this->template->limiter_access();

        $get_issue = ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                        ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                        ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                        ->leftJoin('status_code', 'status_code.id', '=', 'project_mst.status_code_id')
                        ->select('*', 'project_mst.id as project_id')
                        ->whereHas('pjp', $where_has_limiter)
                        ->where($where_has)
                        ->where('status_code_id', $_POST['statusCode'])->get();
        
        // dd($get_issue);

        if ( $get_issue->count() > 0 ) {
            
            foreach ($get_issue as $key => $value) {

                $status_code_name = $value->status_code_name;
                $province_name = $value->province_name;
            
                $this->data[$key]['id'] = $value->project_id;
                $this->data[$key]['external_code'] = $value->external_code;
                $this->data[$key]['project'] = $value->project_name;
                $this->data[$key]['sector'] = $value->sector_name;
                $this->data[$key]['pjp'] = $value->pjp_name;

                $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($value->fund_indication_id))->get();
                
                $fund_indication_temp = array();

                foreach ($get_fund_indication as $key_fund => $value_fund) {
                    
                    $fund_indication_temp[$key_fund]['name'] = $value_fund->fund_indication_name;
                    
                }

                $this->data[$key]['fundNameArr'] = $fund_indication_temp;

                // $this->data[$key]['totalFundApbnd'] = $value->total_fund_apbnd;
                // $this->data[$key]['totalFundBumnd'] = $value->total_fund_bumnd;
                // $this->data[$key]['totalFundSwasta'] = $value->total_fund_swasta;
                $this->data[$key]['totalFund'] = $value->total_fund;
                
            }

            $this->res = array(
                'status' => true,
                'message' => 'Success',
                'headerTitle' => $status_code_name,
                'headerProvince' => $province_name,
                'data' => $this->data
            );
            
        } else {
            
            $this->res = array(
                'status' => false,
                'message' => 'Failed',
                'headerTitle' => '',
                'data' => array()
            );

        }
        

        return $this->res;
    }
    
    private function project_detail_issue(){

        // dd($_POST);

        if ( isset($_POST['sectorFt']) && isset($_POST['pjpFt']) ) {

            $exsearch['sectorFt'] = $_POST['sectorFt'];
            $exsearch['pjpFt'] = $_POST['pjpFt'];

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
            
            
            $where_has = function($ds) use($oprt_sector, $oprt_pjp, $exsearch) {

                $ds->where('project_mst.sector_id', $oprt_sector, $exsearch['sectorFt'])
                    ->where('project_mst.pjp_id', $oprt_pjp, $exsearch['pjpFt']);
                
            };


        } else {
            
            $where_has = function () {};

        }

        $issue_type_name = '';

        $get_issue = IssueMst::join('project_mst', 'project_mst.id', '=', 'issue.project_mst_id')
                        ->leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                        ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                        ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                        // ->leftJoin('status_code', 'status_code.id', '=', 'project_mst.status_code_id')
                        // ->select('*', 'project_mst_id as project_id')
                        ->leftJoin('issue_type', 'issue_type.id', '=', 'issue.issue_type_id')
                        ->select('*')
                        ->where($where_has)
                        ->where('issue_type_id', $_POST['statusCode'])->get();
        
        if ( $get_issue->count() > 0 ) {
            
            foreach ($get_issue as $key => $value) {

                $issue_type_name = $value->issue_type_name;
                $province_name = $value->province_name;
            
                $this->data[$key]['id'] = $value->project_mst_id;
                 $this->data[$key]['external_code'] = $value->external_code;
                $this->data[$key]['project'] = $value->project_name;
                $this->data[$key]['sector'] = $value->sector_name;
                $this->data[$key]['pjp'] = $value->pjp_name;

                $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($value->fund_indication_id))->get();
                
                $fund_indication_temp = array();

                foreach ($get_fund_indication as $key_fund => $value_fund) {
                    
                    $fund_indication_temp[$key_fund]['name'] = $value_fund->fund_indication_name;
                    
                }

                $this->data[$key]['fundNameArr'] = $fund_indication_temp;

                // $this->data[$key]['totalFundApbnd'] = $value->total_fund_apbnd;
                // $this->data[$key]['totalFundBumnd'] = $value->total_fund_bumnd;
                // $this->data[$key]['totalFundSwasta'] = $value->total_fund_swasta;
                $this->data[$key]['totalFund'] = $value->total_fund;
                
            }

            $this->res = array(
                'status' => true,
                'message' => 'Success',
                'headerTitle' => $issue_type_name,
                'headerProvince' => $province_name,
                'data' => $this->data
            );
            
        } else {
            
            $this->res = array(
                'status' => false,
                'message' => 'Failed',
                'headerTitle' => '',
                'data' => array()
            );

        }
        

        return $this->res;
    }

    private function resume_project(){

        $where_has_limiter = $this->template->limiter_access();
        
        
        $get_resume = ProjectMst::with(['sector', 'unit', 'pjp', 'province', 'status_code'])
                        ->whereHas('pjp', $where_has_limiter)->where('id', $_POST['dt'])->first();
        
        
        // var_dump($_POST['dt']);
        // dd($get_resume);
        // dd($get_resume->count());
        // dd(count($get_resume));
        if ( count($get_resume) > 0 ) {


            $this->data['id'] = $get_resume->id;
            $this->data['external_code'] = $get_resume->external_code;
            $this->data['project_name'] = $get_resume->project_name;
            $this->data['sector_id'] = $get_resume->sector_id;
            $this->data['sector_name'] = $get_resume->sector->sector_name;

            $get_fund_indication = FundIndicationMst::select('*')->whereIn('id', json_decode($get_resume->fund_indication_id))->get();

            $fund_indication_temp = '';
            $fund_indication_temp_array = array();

            foreach ($get_fund_indication as $key_fund => $value_fund) {

                $fund_indication_temp .= '- ' . $value_fund->fund_indication_name . '<br />';
                $fund_indication_temp_array[$key_fund]['id'] = $value_fund->id;
                $fund_indication_temp_array[$key_fund]['name'] = $value_fund->fund_indication_name;

            }

            $this->data['fund_indication_name'] = nl2br($fund_indication_temp);
            $this->data['fund_indication_array'] = $fund_indication_temp_array;
            $this->data['currency'] = $get_resume->currency;
            $this->data['total_fund'] = $get_resume->total_fund;
            $this->data['pjp_id'] = $get_resume->pjp->id;
            $this->data['pjp_name'] = $get_resume->pjp->pjp_name;
            $this->data['contact_person'] = $get_resume->contact_person;
            $this->data['status_code_name'] = $get_resume->status_code->status_code_name;
            $this->data['output'] = $get_resume->output;
            $this->data['unit_id'] = $get_resume->unit_id;
            $this->data['unit_name'] = $get_resume->unit->unit_name;
            $this->data['description'] = $get_resume->description;
            $this->data['status'] = $get_resume->status;
            $this->data['total_fund_apbnd'] = $get_resume->total_fund_apbnd;
            $this->data['total_fund_bumnd'] = $get_resume->total_fund_bumnd;
            $this->data['total_fund_swasta'] = $get_resume->total_fund_swasta;
            $this->data['province_id'] = $get_resume->province_id;
            $this->data['province_name'] = $get_resume->province->province_name;
            $this->data['island_id'] = $get_resume->island_id;
            $this->data['island_name'] = $get_resume->island->island_name;
            $this->data['transaction_date'] = date('m/d/Y', strtotime($get_resume->transaction_date));
            $this->data['construction_date'] = date('m/d/Y', strtotime($get_resume->construction_date));
            $this->data['operation_date'] = date('m/d/Y', strtotime($get_resume->operation_date));
            $this->data['start_date'] = date('m/d/Y', strtotime($get_resume->start_date));
            $this->data['start_date'] = date('m/d/Y', strtotime($get_resume->start_date));
            $this->data['end_date'] = date('m/d/Y', strtotime($get_resume->end_date));


            $this->res = array(
                'status' => true,
                'message' => 'Success',
                'data' => $this->data
            );


        } else {


            $this->res = array(
                'status' => false,
                'message' => 'Failed',
                'data' => array()
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

}
