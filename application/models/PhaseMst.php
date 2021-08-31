<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class PhaseMst extends Model {
  protected $table = "phase";
  protected $fillable = ["*"];
  public $timestamps = false;

}
