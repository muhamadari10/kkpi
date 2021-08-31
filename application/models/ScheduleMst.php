<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ScheduleMst extends Model {
  protected $table = "schedule";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function project_mst()
  {
    return $this->belongsTo(ProjectMst::class, 'project_mst_id', 'id');
  }

  public function pjp()
  {
    return $this->belongsTo(PjpMst::class, 'pjp_id', 'id');
  }

  public function sector()
  {
    return $this->belongsTo(SectorMst::class, 'sector_id', 'id');
  }

}
