<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class IslandMst extends Model {
  protected $table = "island";
  protected $fillable = ["*"];
  public $timestamps = false;

}
