<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class UserGroupPermission extends Model {
  protected $table = "user_group_permission";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function menu()
  {
      return $this->belongsTo(Menu::class, 'menu_id');
  }

  public function user_group()
  {
      return $this->belongsTo(UserGroup::class, 'user_group_id');
  }

}
