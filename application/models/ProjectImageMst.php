<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ProjectImageMst extends Model {
  protected $table = "project_image";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function project_mst()
  {
    return $this->belongsTo(ProjectMst::class, 'project_mst_id', 'id');
  }

}
