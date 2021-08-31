<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class User_menu extends Model {
    protected $table = "T_USER_MENU";
    protected $fillable = ["*"];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function menu() {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

}
