<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function applicant_user() {
      return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function property_data() {
        return $this->hasOne('App\Models\Applications\ApplicationPropertyData');
    }

    public function owner_data() {
        return $this->hasOne('App\Models\Applications\ApplicationOwnerData');
    }

    public function applicant_data() {
        return $this->hasOne('App\Models\Applications\ApplicationApplicantData');
    }

    public function project_data() {
        return $this->hasOne('App\Models\Applications\ApplicationProjectData');
    }

    public function others_data() {
        return $this->hasOne('App\Models\Applications\ApplicationOthersData');
    }

    public function attachement_data() {
        return $this->hasMany('App\Models\Applications\ApplicationAttachementData');
    }

    public function review_data() {
        return $this->hasMany('App\Models\Applications\ApplicationReviewData');
    }

    public function payments() {
      return $this->hasMany('App\Models\Applications\ApplicationRecordPayment');
    }

    public function stripe_payment_reference() {
      return $this->hasMany('App\Models\Payments\PaymentRecord');
    }

    public function trail() {
      return $this->hasMany('App\Models\Applications\ApplicationRecordTrail');
    }
}
