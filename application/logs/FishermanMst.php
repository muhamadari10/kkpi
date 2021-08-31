<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Illuminate\Database\Eloquent\Model as Model;

class FishermanMst extends Model {
  protected $table = "fisherman";
  protected $fillable = ["*"];
  public $timestamps = false;

  public function province()
  {
      return $this->belongsTo(ProvinceMst::class, 'province_id', 'id');
  }

  public function district()
  {
      return $this->belongsTo(DistrictMst::class, 'district_id', 'id');
  }

//   public function majorMst()
//   {
//       return $this->belongsTo(MajorMst::class, 'major_id', 'id');
//   }

//   public function categoryMst()
//   {
//       return $this->belongsTo(CategoryMst::class, 'category_id', 'id');
//   }

}
