<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class RiskMst extends Model {
  protected $table = "risk";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function project_mst()
  {
    return $this->belongsTo(ProjectMst::class, 'project_mst_id', 'id');
  }

  public function frequency_level()
  {
    return $this->belongsTo(FrequencyLevelMst::class, 'frequency_level_id', 'id');
  }

  public function severity_level()
  {
    return $this->belongsTo(SeverityLevelMst::class, 'severity_level_id', 'id');
  }

  public function activity()
  {
    return $this->belongsTo(ActivityMst::class, 'activity_id', 'id');
  }

  public function phase()
  {
    return $this->belongsTo(PhaseMst::class, 'phase_id', 'id');
  }

  public function province()
  {
    return $this->belongsTo(ProvinceMst::class, 'province_id', 'id');
  }
  
  public function issue_type()
  {
    return $this->belongsTo(IssueTypeMst::class, 'issue_type_id', 'id');
  }

}
