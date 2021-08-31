<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class MethodAccess extends Model {
  protected $table = "method_access";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function group()
  {
      return $this->belongsTo(Group::class, 'group_id');
  }

}
