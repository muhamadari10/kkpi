<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class SemesterMst extends Model {
  protected $table = "T_SEMESTER";
  protected $fillable = ["*"];
  public $timestamps = false;

}
