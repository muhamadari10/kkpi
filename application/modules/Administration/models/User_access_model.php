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

use Navij\Libraries\Template as Template;


class User_access_model extends Eloquent{

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

    private function user_access_list(){

        $columns = $_GET['columns'];
        $search = $_GET['search']['value'];
        $val = $_GET['search']['value'];

        $q_data = UserGroup::with(['group', 'user', 'pjp'])->where('default_user', 1);
        

        // dd($q_data);
        if(!empty($val))
            $q_data->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true' 
                        && $v['data'] != 'action'
                        ) {

                            if ( $v['data'] == 'pjp_name' ) {
                                
                                $ds->whereHas('pjp', function($q) use($v, $search){
                                    $q->orWhere('pjp_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'username' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('username', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'active_status' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){

                                    $status = ($search == 'ACTIVE')?1:0;

                                    $q->orWhere('active', $status);

                                });

                            } else if ( $v['data'] == 'full_name' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('full_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'group_desc' ) {
                                
                                $ds->whereHas('group', function($q) use($v, $search){
                                    $q->orWhere('description', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'phone_number' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('phone_number', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'email' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('email', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'address' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('address', 'LIKE', '%'.$search.'%');
                                });

                            } else {

                                $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                            }
                            
                            
                        }

                }
            });

        $data_in = $q_data->where(function($ds) use($columns,$search){
            foreach ($columns as $i => $v) {
                $ds->whereHas('user', function($q) use($v, $search){
                    $q->where('active', 1);
                });
            }
        })->take($_GET['length'])->offset($_GET['start'])->get();

        foreach ($data_in as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['active_status'] = ($value->user->active == 1)?'ACTIVE':'INACTIVE';
            $this->data[$key]['user_id'] = $value->user->id;
            $this->data[$key]['full_name'] = $value->user->full_name;
            $this->data[$key]['username'] = $value->user->username;
            // $this->data[$key]['password'] = $value->user->password;
            $this->data[$key]['group_name'] = $value->group->name;
            $this->data[$key]['group_desc'] = $value->group->description;
            $this->data[$key]['group_id'] = $value->group->id;
            $this->data[$key]['pjp_id'] = $value->pjp->id;
            $this->data[$key]['pjp_name'] = $value->pjp->pjp_name;
            $this->data[$key]['phone_number'] = $value->user->phone_number;
            $this->data[$key]['email'] = $value->user->email;
            $this->data[$key]['address'] = $value->user->address;
            $this->data[$key]['action'] = '<div class="btn-group">
                <button type="button" class="btn btn-warning btn-flat update-row"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-flat delete-row"><i class="fa fa-trash"></i></button>
            </div>';
            

        }

        // dd($data_in);

        $val   = $_GET['search']['value'];
        if(!empty($val))
            $count = UserGroup::with(['group', 'user', 'pjp'])->where('default_user', 1)
            ->where(function($ds) use($columns,$search){
                foreach ($columns as $i => $v) {
                    if(!empty($v['data']) 
                        && $v['searchable']=='true'
                        && $v['data'] != 'action') {
                            
                            if ( $v['data'] == 'pjp_name' ) {
                                
                                $ds->whereHas('pjp', function($q) use($v, $search){
                                    $q->orWhere('pjp_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'username' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('username', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'active_status' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){

                                    $status = ($search == 'ACTIVE')?1:0;

                                    $q->orWhere('active', $status);

                                });

                            } else if ( $v['data'] == 'full_name' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('full_name', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'group_desc' ) {
                                
                                $ds->whereHas('group', function($q) use($v, $search){
                                    $q->orWhere('description', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'phone_number' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('phone_number', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'email' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('email', 'LIKE', '%'.$search.'%');
                                });

                            } else if ( $v['data'] == 'address' ) {
                                
                                $ds->whereHas('user', function($q) use($v, $search){
                                    $q->orWhere('address', 'LIKE', '%'.$search.'%');
                                });

                            } else {

                                $ds->orWhere($v['data'], 'LIKE', '%'.$search.'%');
                            
                            }
                            
                        }

                }
            });

        $this->res = array(
            'recordsTotal' => isset($count)?$count->count():intval(
                UserGroup::with(['group', 'user', 'pjp'])->where('default_user', 1)->count()
            ),
            'recordsFiltered' => isset($count)?$count->count():intval(
                UserGroup::with(['group', 'user', 'pjp'])->where('default_user', 1)->count()
            ),
            'data' => $this->data
        );

        return $this->res;
    }

    private function group_option()
    {

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

        $get_data = Group::where('name', $oprt, $value)
                        ->orderBy('id', 'asc')
                        ->get();

        foreach ($get_data as $key => $value) {
            
            $this->data[$key]['id'] = $value->id;
            $this->data[$key]['text'] = $value->description;

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
        
        if (isset($_GET['group'])) {
            
            if ( ($_GET['group'] == 1) || ($_GET['group'] == 2) ) {
                $oprt_p = '=';
                $value_p = 1;
                $oprt_d = '<>';
                $value_d = '';
            } else {
                $oprt_p = '<>';
                $value_p = '';
                $oprt_d = '<>';
                $value_d = 'ALL';
            }

        } else {
            $oprt_p = '=';
            $value_p = '';
            $oprt_d = '=';
            $value_d = '';
        }

        // var_dump($oprt_p);
        // dd($value_p);

        $get_data = PjpMst::where('id', $oprt_p, $value_p)
                        ->where('pjp_name', $oprt_d, $value_d)
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

    private function create_user_access()
    {

        // dd($_POST);

        try {

            $name = $_POST['name'];

            $check_user_access_exist = UserGroup::select('id')
                                    ->whereHas('user', function($q) use($name) {
                                        $q->where('full_name', $name);
                                    })->get();

            if ( $check_user_access_exist->count() < 1 ) {

                $user_store = new User();
                $user_store->username = $_POST['username'];
                $user_store->password = sha1($_POST['password']);
                $user_store->email = $_POST['email'];
                $user_store->created_on = date('Y-m-d H:i:s');
                $user_store->active = 1;
                $user_store->full_name = $_POST['name'];
                $user_store->phone_number = $_POST['phoneNumber'];
                $user_store->address = $_POST['address'];
                $user_store->group_id = $_POST['groupOpt'];
                
                if ( $user_store->save() ) {
                    
                    $user_access_store = new UserGroup();
                    $user_access_store->user_id = $user_store->id;
                    $user_access_store->group_id = $_POST['groupOpt'];
                    $user_access_store->pjp_id = $_POST['pjpOpt'];
                    $user_access_store->default_user = 1;
                    $user_access_store->created_on = date('Y-m-d H:i:s');
                    $user_access_store->created_by = $this->template->get_session('user_id');
                    $user_access_store->update_by = $this->template->get_session('user_id');
                    
                    if ($user_access_store->save()) {
                        
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

    private function update_user_access()
    {
        
        // dd($_POST);

        try {

            $check_user_access_exist = UserGroup::select('id')
                                    ->where('id', $_POST['id'])
                                    ->get();

            if ( $check_user_access_exist->count() > 0 ) {

                $default_user_group_check = UserGroup::select('id')
                                            ->where('id', $_POST['id'])
                                            ->where('group_id', $_POST['groupOpt'])
                                            ->get();


                if ( $default_user_group_check->count() > 0 ) {

                    $user_access_store = UserGroup::find($_POST['id']);
                    $user_access_store->group_id = $_POST['groupOpt'];
                    $user_access_store->pjp_id = $_POST['pjpOpt'];
                    $user_access_store->default_user = 1;
                    $user_access_store->created_on = date('Y-m-d H:i:s');
                    $user_access_store->created_by = $this->template->get_session('user_id');
                    $user_access_store->update_by = $this->template->get_session('user_id');
                    

                } else if ( $default_user_group_check->count() < 1 ) {
                    
                    $user_access_store = new UserGroup();
                    $user_access_store->user_id = $default_user_group_check->user_id;
                    $user_access_store->group_id = $_POST['groupOpt'];
                    $user_access_store->pjp_id = $_POST['pjpOpt'];
                    $user_access_store->default_user = 1;
                    $user_access_store->created_on = date('Y-m-d H:i:s');
                    $user_access_store->created_by = $this->template->get_session('user_id');
                    $user_access_store->update_by = $this->template->get_session('user_id');


                }
                
                if ($user_access_store->save()) {

                    $user_store = User::find($user_access_store->id);
                    $user_store->username = $_POST['username'];
                    $user_store->password = sha1($_POST['password']);
                    $user_store->email = $_POST['email'];
                    $user_store->created_on = date('Y-m-d H:i:s');
                    $user_store->active = 1;
                    $user_store->full_name = $_POST['name'];
                    $user_store->phone_number = $_POST['phoneNumber'];
                    $user_store->address = $_POST['address'];
                    $user_store->group_id = $_POST['groupOpt'];
                    
                    if ( $user_store->save() ) {
                        
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

    private function delete_user_access()
    {

        try {

            $user_access_del = User::find($_POST['id']);
            $user_access_del->active = 0;
            $user_access_del->save();
            $this->res = array("status" => true, "message" => "Data berhasil dinonaktifkan." );

        } catch (Exception $e) {
            
            $this->res = array(
                'status' => 500,
                'message' => "Data PJP sedang digunakan."
            );

        }

        
        return  $this->res;
    }
    

}
