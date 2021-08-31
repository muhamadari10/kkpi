<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class OrderMst extends Model {
  protected $table = "order_mst";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function customerMst()
  {
    return $this->belongsTo(CustomerMst::class, 'customer_id', 'id');
  }
  
  public function createdBy()
  {
    return $this->belongsTo(EmployeeMst::class, 'created_by', 'id');
  }
  
  public function updateBy()
  {
    return $this->belongsTo(EmployeeMst::class, 'update_by', 'id');
  }

}
