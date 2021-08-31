<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class CustomerMst extends Model {
  protected $table = "customer";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function createdBy()
  {
    return $this->belongsTo(EmployeeMst::class, 'created_by', 'id');
  }
  
  public function updateBy()
  {
    return $this->belongsTo(EmployeeMst::class, 'update_by', 'id');
  }

}
