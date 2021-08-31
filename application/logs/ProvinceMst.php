<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ProvinceMst extends Model {
  protected $table = "province";
  protected $fillable = ["*"];
  public $timestamps = false;

}
