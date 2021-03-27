<?php

namespace App\Traits;

use App\Models\Trails\TrailUser;
use App\Models\Trails\TrailApplication;

trait AuditTrail {
	public function user_trail(array $log) {
        TrailUser::create([
            'user_id' => $log['user_id'],
            'message' => $log['message']
        ]);
	}

	public function application_trail(array $log) {
		
	}
}