<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ContactPersonMst extends Model {
  protected $table = "contact_person";
  protected $fillable = ["*"];
  public $timestamps = false;

}
