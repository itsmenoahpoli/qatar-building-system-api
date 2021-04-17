<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function application_record_payment() {
      return $this->hasOne('App\Models\Applications\ApplicationRecordPayment');
    }
}
