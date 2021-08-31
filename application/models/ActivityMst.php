<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ActivityMst extends Model {
  protected $table = "activity";
  protected $fillable = ["*"];
  public $timestamps = false;

}
