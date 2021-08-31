<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class OrderDet extends Model {
  protected $table = "order_det";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function orderMst()
  {
    return $this->belongsTo(OrderMst::class, 'order_id', 'id');
  }

}
