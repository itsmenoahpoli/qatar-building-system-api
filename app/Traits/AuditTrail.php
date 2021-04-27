<?php

namespace App\Traits;

use App\Models\Trails\TrailUser;
use App\Models\Trails\TrailApplication;
use App\Models\Applications\ApplicationRecordTrail;

trait AuditTrail {
	public function user_trail(array $log) {
        TrailUser::create([
            'user_id' => $log['user_id'],
            'message' => $log['message']
        ]);
	}

	public function application_trail(array $log) {
		ApplicationRecordTrail::create([
      'application_record_id' => $log['application_record_id'],
      'content' => $log['content']
    ]);
	}
}