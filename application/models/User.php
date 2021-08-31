<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class User extends Model {
  protected $table = "user";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function group()
  {
      return $this->belongsTo(Group::class, 'group_id');
  }

  public function fisherman()
  {
      return $this->belongsTo(FishermanMst::class, 'user_id_fk', 'id');
  }

}
