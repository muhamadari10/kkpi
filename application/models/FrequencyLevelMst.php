<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class FrequencyLevelMst extends Model {
  protected $table = "frequency_level";
  protected $fillable = ["*"];
  public $timestamps = false;
  
}
