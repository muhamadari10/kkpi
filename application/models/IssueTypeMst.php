<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class IssueTypeMst extends Model {
    protected $table = "issue_type";
    protected $fillable = ["*"];
    public $timestamps = false;
}
