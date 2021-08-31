<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;

use IslandMst as IslandMst;

use Navij\Libraries\Template as Template;


class Island_model extends Eloquent{

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

    private function island_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];

        $q_data = IslandMst::select('*');
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
            $this->data[$key]['island_name'] = $value->island_name;
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = IslandMst::select('*')
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
                IslandMst::select('*')->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                IslandMst::select('*')->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_island()
    {
        
        // dd($_POST);

        try {

            $check_island_exist = IslandMst::select('id')
                                    ->where('island_name', $_POST['islandName'])
                                    ->get();

            if ( $check_island_exist->count() < 1 ) {

                $island_store = new IslandMst();
                $island_store->island_name = $_POST['islandName'];
                
                
                if ($island_store->save()) {
                    
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

    private function update_island()
    {
        
        // dd($_POST);

        try {

            // $check_island_exist = IslandMst::select('id')
            //                         ->where('island_description', $_POST['islandDescription'])
            //                         ->get();

            // if ( $check_island_exist->count() < 1 ) {

                $island_store = IslandMst::find($_POST['islandId']);
                $island_store->island_name = $_POST['islandName'];
                
                if ($island_store->save()) {
                    
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

    private function delete_island()
    {

        $island_del = IslandMst::find($_POST['id']);
        $island_del->delete();
        $this->res = array("status" => true, "message" => "Data berhasil dihapus." );
        
        return  $this->res;
    }
    

}
