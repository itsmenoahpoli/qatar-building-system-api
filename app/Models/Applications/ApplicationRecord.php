<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function property_data() {
        return $this->hasOne('App\Models\Application\ApplicationPropertyData');
    }

    public function owner_data() {
        return $this->hasOne('App\Models\Application\ApplicationOwnerData');
    }

    public function applicant_data() {
        return $this->hasOne('App\Models\Application\ApplicationApplicantData');
    }

    public function project_data() {
        return $this->hasOne('App\Models\Application\ApplicationProjectData');
    }

    public function others_data() {
        return $this->hasOne('App\Models\Application\ApplicationOthersData');
    }

    public function attachement_data() {
        return $this->hasOne('App\Models\Application\ApplicationAttachementData');
    }

    public function review_data() {
        return $this->hasOne('App\Models\Application\ApplicationReviewData');
    }
}
