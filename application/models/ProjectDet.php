<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class ProjectDet extends Model {
  protected $table = "project_det";
  protected $fillable = ["*"];
  public $timestamps = false;
  
  public function project_mst()
  {
    return $this->belongsTo(ProjectMst::class, 'project_mst_id', 'id');
  }

  public function sector()
  {
    return $this->belongsTo(SectorMst::class, 'sector_id', 'id');
  }

  public function pjp()
  {
    return $this->belongsTo(PjpMst::class, 'pjp_id', 'id');
  }

  public function contact_person()
  {
    return $this->belongsTo(ContactPersonMst::class, 'contact_person_id', 'id');
  }

  public function fund_indication()
  {
    return $this->belongsTo(FundIndicationMst::class, 'fund_indication_id', 'id');
  }

  public function status_code()
  {
    return $this->belongsTo(StatusCodeMst::class, 'status_code_id', 'id');
  }

  public function unit()
  {
    return $this->belongsTo(UnitMst::class, 'unit_id', 'id');
  }

  public function province()
  {
    return $this->belongsTo(ProvinceMst::class, 'province_id', 'id');
  }

  public function island()
  {
    return $this->belongsTo(IslandMst::class, 'island_id', 'id');
  }

}
