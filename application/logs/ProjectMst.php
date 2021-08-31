<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ProjectMst extends Model {
  protected $table = "project_master";
  protected $fillable = ["*"];
  public $timestamps = false;

}
