<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class UserGroup extends Model {
  protected $table = "user_group";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function group()
  {
      return $this->belongsTo(Group::class, 'group_id');
  }

  public function user()
  {
      return $this->belongsTo(User::class, 'user_id');
  }

}
