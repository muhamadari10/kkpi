<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class CategoryMst extends Model {
  protected $table = "category";
  protected $fillable = ["*"];
  public $timestamps = false;

}
