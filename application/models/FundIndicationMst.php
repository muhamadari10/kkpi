<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class FundIndicationMst extends Model {
  protected $table = "fund_indication";
  protected $fillable = ["*"];
  public $timestamps = false;

}
