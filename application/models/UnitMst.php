<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class UnitMst extends Model {
  protected $table = "unit";
  protected $fillable = ["*"];
  public $timestamps = false;

}
