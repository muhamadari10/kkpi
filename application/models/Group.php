<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class Group extends Model {
  protected $table = "group";
  protected $fillable = ["*"];
  public $timestamps = false;

}
