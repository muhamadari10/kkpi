<?php

/*
 *  Author : Jivanly Vrincent
 *  Created :  05.02.2018
*/

defined("BASEPATH") OR exit("No direct script access allowed");

// ------------------ Eloquent Model -------------------- //
use \Illuminate\Database\Eloquent\Model as Eloquent;

use UserGroup as UserGroup;
use Group as Group;
use User as User;
use Permission as Permission;
use UserGroupPermission as UserGroupPermission;

use Navij\Libraries\Template as Template;

class Rule_access_model extends Eloquent{

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

    private function user_option() {
        
        if (isset($_POST['q'])) {
            
            if ($_POST['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_POST['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = UserGroup::with(['user', 'group'])
                        ->whereHas('user', function($q) use($oprt, $value) {
                            $q->where('full_name', $oprt, $value);
                        })
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->user->full_name;

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

    private function permission_menu_option() {
        
        if (isset($_POST['q'])) {
            
            if ($_POST['q'] == '') {
                $oprt = '!=';
                $value = '';
            } else {
                $oprt = 'like';
                $value = '%' . $_POST['q'] . '%';
            }

        } else {
            $oprt = '!=';
            $value = '';
        }

        $get_data = Permission::with(['menu'])->whereHas('menu', function( $q ) use($oprt, $value){
						$q->where('name', $oprt, $value)->where('active', 1);
                    })
                    ->where('group_id', $this->template->get_session('group_id') )->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->menu_id;
            $this->data[$key]['text'] = $value->menu->name;

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

    private function rule_access_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];
        $val = $_GET['search']['value'];
        $val_data = $_GET['extra_search']['userId'];

        if ( isset($val_data) ) {
            
            $oprt = '=';
            $data = $val_data;

        } else {
            
            $oprt = '<>';
            $data = '';

        }
        

        $q_data = UserGroupPermission::with(['menu', 'user_group.user', 'user_group'])->where('user_group_id', $oprt, $data);
        

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
            $this->data[$key]['user_group_name'] = $value->user_group->user->full_name;
            $this->data[$key]['user_group_id'] = $value->user_group_id;
            $this->data[$key]['menu_id'] = $value->menu_id;
            $this->data[$key]['menu_name'] = $value->menu->name;
            $this->data[$key]['create'] = ($value->create == 1)?'<button type="button" value="'.$value->id.'" class="btn btn-success btn-flat create">YES</button>':'<button type="button" value="'.$value->id.'" class="btn btn-danger btn-flat create">NO</button>';
            $this->data[$key]['read'] = ($value->read == 1)?'<button type="button" value="'.$value->id.'" class="btn btn-success btn-flat read">YES</button>':'<button type="button" value="'.$value->id.'" class="btn btn-danger btn-flat read">NO</button>';
            $this->data[$key]['update'] = ($value->update == 1)?'<button type="button" value="'.$value->id.'" class="btn btn-success btn-flat update">YES</button>':'<button type="button" value="'.$value->id.'" class="btn btn-danger btn-flat update">NO</button>';
            $this->data[$key]['delete'] = ($value->delete == 1)?'<button type="button" value="'.$value->id.'" class="btn btn-success btn-flat delete">YES</button>':'<button type="button" value="'.$value->id.'" class="btn btn-danger btn-flat delete">NO</button>';
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = UserGroupPermission::with(['menu', 'user_group'])->where('user_group_id', $oprt, $data)
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
                UserGroupPermission::with(['menu', 'user_group'])->where('user_group_id', $oprt, $data)->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                UserGroupPermission::with(['menu', 'user_group'])->where('user_group_id', $oprt, $data)->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function create_rule_access()
    {

        // dd($_POST);

        try {

            $check_rule_access_exist = UserGroupPermission::where('menu_id', $_POST['permissionMenuOpt'])
                                        ->where('user_group_id', $_POST['userOpt'])->get();

            if ( $check_rule_access_exist->count() < 1 ) {

                $permission_store = new UserGroupPermission();
                $permission_store->user_group_id = $_POST['userOpt'];
                $permission_store->menu_id = $_POST['permissionMenuOpt'];
                
                if ( $permission_store->save() ) {
                        
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

    private function update_rule_access()
    {
        
        // dd($_POST);

        try {

            $check_rule_access_exist = UserGroupPermission::where('id', $_POST['id'])->get();

            if ( $check_rule_access_exist->count() > 0 ) {

                $permission_store = UserGroupPermission::find($_POST['id']);
                $permission_store->user_group_id = $_POST['userOpt'];
                $permission_store->menu_id = $_POST['permissionMenuOpt'];
                
                if ( $permission_store->save() ) {
                        
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
                    'message' => 'Data tersebut belum tersimpan, mohon insert data baru.',
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

    private function delete_rule_access()
    {

        try {

            $rule_access_del = UserGroupPermission::find($_POST['id']);
            $rule_access_del->delete();
            $this->res = array("status" => true, "message" => "Data berhasil dihapus." );

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Server Error."
            );

        }

        
        return  $this->res;
    }

    private function create_permission()
    {

        try {

            $check_permission_menu = UserGroupPermission::where('id', $_POST['id'])->first();

            // dd($check_permission_menu);

            $create_val = ($check_permission_menu->create == 1)?0:1;

            $permission_rule = UserGroupPermission::find($_POST['id']);
            $permission_rule->create = $create_val;

            if ( $permission_rule->save() ) {

                $this->res = array(
                    'status' => 200,
                    'message' => 'Data berhasil diubah.',
                    'data' => $this->data
                );
                    

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data gagal diubah.',
                    'data' => $this->data
                );

            }
            

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Server Error."
            );

        }

        
        return  $this->res;
    }

    private function read_permission()
    {

        try {

            $check_permission_menu = UserGroupPermission::where('id', $_POST['id'])->first();

            $read_val = ($check_permission_menu->read == 1)?0:1;

            $permission_rule = UserGroupPermission::find($_POST['id']);
            $permission_rule->read = $read_val;

            if ( $permission_rule->save() ) {

                $this->res = array(
                    'status' => 200,
                    'message' => 'Data berhasil diubah.',
                    'data' => $this->data
                );
                    

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data gagal diubah.',
                    'data' => $this->data
                );

            }

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Server Error."
            );

        }

        
        return  $this->res;
    }

    private function update_permission()
    {

        try {

            $check_permission_menu = UserGroupPermission::select('*')->where('id', $_POST['id'])->first();


            // dd($check_permission_menu);
            $update_val = ($check_permission_menu->update == 1)?0:1;

            $permission_rule = UserGroupPermission::find($_POST['id']);
            $permission_rule->update = $update_val;

            if ( $permission_rule->save() ) {

                $this->res = array(
                    'status' => 200,
                    'message' => 'Data berhasil diubah.',
                    'data' => $this->data
                );
                    

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data gagal diubah.',
                    'data' => $this->data
                );

            }

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Server Error."
            );

        }

        
        return  $this->res;
    }

    private function delete_permission()
    {

        try {

            $check_permission_menu = UserGroupPermission::where('id', $_POST['id'])->first();

            $delete_val = ($check_permission_menu->delete == 1)?0:1;

            $permission_rule = UserGroupPermission::find($_POST['id']);
            $permission_rule->delete = $delete_val;

            if ( $permission_rule->save() ) {

                $this->res = array(
                    'status' => 200,
                    'message' => 'Data berhasil diubah.',
                    'data' => $this->data
                );
                    

            } else {

                $this->res = array(
                    'status' => 404,
                    'message' => 'Data gagal diubah.',
                    'data' => $this->data
                );

            }

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Server Error."
            );

        }

        
        return  $this->res;
    }
    

}
