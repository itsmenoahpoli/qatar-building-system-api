<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationReviewData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function application_record() {
      return $this->belongsTo('App\Models\Applications\ApplicationRecord');
    }
}
