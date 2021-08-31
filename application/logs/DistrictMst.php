<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class DistrictMst extends Model {
  protected $table = "district";
  protected $fillable = ["*"];
  public $timestamps = false;

}
