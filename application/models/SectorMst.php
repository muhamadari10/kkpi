<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class SectorMst extends Model {
  protected $table = "sector";
  protected $fillable = ["*"];
  public $timestamps = false;

}
