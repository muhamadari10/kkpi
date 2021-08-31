<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class SeverityLevelMst extends Model {
  protected $table = "severity_level";
  protected $fillable = ["*"];
  public $timestamps = false;
  
}
