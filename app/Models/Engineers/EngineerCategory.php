<?php

namespace App\Models\Engineers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineerCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
      return $this->hasMany('App\Models\User');
    }
}
