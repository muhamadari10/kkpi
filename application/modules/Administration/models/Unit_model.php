<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;

use UnitMst as UnitMst;

use Navij\Libraries\Template as Template;


class Unit_model extends Eloquent{

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

    private function unit_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];

        $q_data = UnitMst::select('*');
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
            $this->data[$key]['unit_name'] = $value->unit_name;
            $this->data[$key]['simbol'] = $value->simbol;
            $this->data[$key]['description'] = $value->description;
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = UnitMst::select('*')
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
                UnitMst::select('*')->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                UnitMst::select('*')->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_unit()
    {
        
        // dd($_POST);

        try {

            $check_unit_exist = UnitMst::select('id')
                                    ->where('unit_name', $_POST['unitName'])
                                    ->get();

            if ( $check_unit_exist->count() < 1 ) {

                $unit_store = new UnitMst();
                $unit_store->unit_name = $_POST['unitName'];
                $unit_store->simbol = $_POST['simbol'];
                $unit_store->description = $_POST['description'];
                
                if ($unit_store->save()) {
                    
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

    private function update_unit()
    {
        
        // dd($_POST);

        try {

            // $check_unit_exist = UnitMst::select('id')
            //                         ->where('unit_description', $_POST['unitDescription'])
            //                         ->get();

            // if ( $check_unit_exist->count() < 1 ) {

                $unit_store = UnitMst::find($_POST['unitId']);
                $unit_store->unit_name = $_POST['unitName'];
                $unit_store->simbol = $_POST['simbol'];
                $unit_store->description = $_POST['description'];
                
                if ($unit_store->save()) {
                    
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

    private function delete_unit()
    {

        $unit_del = UnitMst::find($_POST['id']);
        $unit_del->delete();
        $this->res = array("status" => true, "message" => "Data berhasil dihapus." );
        
        return  $this->res;
    }
    

}
