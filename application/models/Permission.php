<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class Permission extends Model {
    protected $table = "permission";
    protected $fillable = ["*"];
    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

}
