<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class UserRegionMst extends Model {
  protected $table = "user_region";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function user_group()
  {
      return $this->belongsTo(UserGroup::class, 'user_group_id');
  }

  public function province()
  {
      return $this->belongsTo(ProvinceMst::class, 'province_id');
  }

  public function district()
  {
      return $this->belongsTo(DistrictMst::class, 'district_id');
  }

}
