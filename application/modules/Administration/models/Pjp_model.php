<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;

use PjpMst as PjpMst;

use Navij\Libraries\Template as Template;


class Pjp_model extends Eloquent{

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

    private function pjp_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];

        
        $where_has_limiter = $this->template->limiter_access();

        $q_data = PjpMst::select('*')->where($where_has_limiter);
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
            $this->data[$key]['pjp_name'] = $value->pjp_name;
            $this->data[$key]['pjp_address'] = $value->pjp_address;
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = PjpMst::select('*')
            ->where($where_has_limiter)
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
                PjpMst::select('*')->where($where_has_limiter)->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                PjpMst::select('*')->where($where_has_limiter)->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_pjp()
    {
        
        // dd($_POST);

        try {

            $check_pjp_exist = PjpMst::select('id')
                                    ->where('pjp_name', $_POST['pjpName'])
                                    ->get();

            if ( $check_pjp_exist->count() < 1 ) {

                $pjp_store = new PjpMst();
                $pjp_store->pjp_name = $_POST['pjpName'];
                $pjp_store->pjp_address = $_POST['pjpAddress'];
                
                if ($pjp_store->save()) {
                    
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

    private function update_pjp()
    {
        
        // dd($_POST);

        try {

            // $check_pjp_exist = PjpMst::select('id')
            //                         ->where('pjp_description', $_POST['pjpDescription'])
            //                         ->get();

            // if ( $check_pjp_exist->count() < 1 ) {

                $pjp_store = PjpMst::find($_POST['pjpId']);
                $pjp_store->pjp_name = $_POST['pjpName'];
                $pjp_store->pjp_address = $_POST['pjpAddress'];
                
                if ($pjp_store->save()) {
                    
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

    private function delete_pjp()
    {

        try {
            $pjp_del = PjpMst::find($_POST['id']);
            $pjp_del->delete();
            $this->res = array("status" => true, "message" => "Data berhasil dihapus." );

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Data PJP sedang digunakan."
            );

        }

        
        return  $this->res;
    }
    

}
