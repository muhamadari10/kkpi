<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class Menu extends Model {
    protected $table = "menu";
    protected $fillable = ["*"];
    public $timestamps = false;
}
