<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class PjpMst extends Model {
  protected $table = "pjp";
  protected $fillable = ["*"];
  public $timestamps = false;

}
