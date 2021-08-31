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
use FundIndicationMst as FundIndicationMst;

use Navij\Libraries\Template as Template;


class Map_project_model extends Eloquent{

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
    
    private function project_location(){

        $province = $_POST['province'];

        $where_with = function ($q) use($province) {
            $q->where('province.province_name', 'LIKE', '%'. $province. '%');
        };

        $this->res = array(
            "data" => array(
                "design" => array(
                    "label" => "Perencanaan",
                    "province" => $province,
                    "statusCode" => 1,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 1)->get()->count()
                ),
                "preparation" => array(
                    "label" => "Persiapan",
                    "province" => $province,
                    "statusCode" => 2,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 2)->get()->count()
                ),
                "transaction" => array(
                    "label" => "Transaksi",
                    "province" => $province,
                    "statusCode" => 3,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 3)->get()->count()
                ),
                "constructionAfter2019" => array(
                    "label" => "Konstruksi dan Akan Mulai Beroperasi setelah 2019",
                    "province" => $province,
                    "statusCode" => 4,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 4)->get()->count()
                ),
                "constructionOperation2019" => array(
                    "label" => "Konstruksi dan Akan Mulai Beroperasi di 2019",
                    "province" => $province,
                    "statusCode" => 5,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 5)->get()->count()
                ),
                "constructionOperation2018" => array(
                    "label" => "Konstruksi dan Akan Mulai Beroperasi di 2018",
                    "province" => $province,
                    "statusCode" => 6,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 6)->get()->count()
                ),
                "constructionAndOperation" => array(
                    "label" => "Konstruksi dan Telah Mulai Beroperasi",
                    "province" => $province,
                    "statusCode" => 7,
                    "value" => ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                                        ->select('*')->where($where_with)->where('status_code_id', 7)->get()->count()
                ),
            ),
            "status" => true,
            "message" => "Success"
        );

        return $this->res;
    }

    private function project_detail_list(){

        // dd($_POST);

        $status_code_name = '';

        $get_issue = ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                        ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                        ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                        ->leftJoin('status_code', 'status_code.id', '=', 'project_mst.status_code_id')
                        ->select('*', 'project_mst.id as project_id')
                        ->where('status_code_id', $_POST['statusCode'])->where('province.province_name' , 'LIKE', '%'.$_POST['province'] . '%' )->get();
        
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

    private function project_detail_list_national(){

        $label_color = array(
            'label-danger',
            'label-success',
            'label-info',
            'label-warning',
            'label-primary',
            'label-secondary',
            'label-default'
        );

        // dd($_POST);

        $status_code_name = '';

        $get_project_det = ProjectMst::leftJoin('province', 'province.id', '=', 'project_mst.province_id')
                        ->leftJoin('sector', 'sector.id', '=', 'project_mst.sector_id')
                        ->leftJoin('pjp', 'pjp.id', '=', 'project_mst.pjp_id')
                        ->leftJoin('status_code', 'status_code.id', '=', 'project_mst.status_code_id')
                        ->select('*', 'project_mst.id as project_id')
                        // ->select('*')
                        ->where('province.province_name' , 'LIKE', '%Nasional%' )->get();
        
        if ( $get_project_det->count() > 0 ) {
            
            foreach ($get_project_det as $key => $value) {

                $status_code_name = $value->status_code_name;
                $province_name = $value->province_name;
            
                $this->data[$key]['id'] = $value->project_id;
                $this->data[$key]['external_code'] = $value->external_code;
                $this->data[$key]['project'] = $value->project_name;
                $this->data[$key]['sector'] = $value->sector_name;
                $this->data[$key]['pjp'] = $value->pjp_name;
                $this->data[$key]['statusCodeName'] = $value->status_code_name;

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

    
    private function resume_project(){

        $where_has_limiter = $this->template->limiter_access();
        
        
        $get_resume = ProjectMst::with(['sector', 'unit', 'pjp', 'province', 'status_code'])
                        ->whereHas('pjp', $where_has_limiter)->where('id', $_POST['dt'])->first();
        
        
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

}
