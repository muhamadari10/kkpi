<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class StatusCodeMst extends Model {
  protected $table = "status_code";
  protected $fillable = ["*"];
  public $timestamps = false;

}
