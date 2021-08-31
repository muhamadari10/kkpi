<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class EmployeeMst extends Model {
  protected $table = "employee";
  protected $fillable = ["*"];
  public $timestamps = false;

}
