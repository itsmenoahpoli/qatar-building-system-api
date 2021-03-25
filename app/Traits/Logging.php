<?php

namespace App\Traits;

use App\Models\LogUserSession;

trait Logging {
	public function saveLog(array $log) {
		LogUserSession::create([
			'user_id' => $log['user_id'],
			'message' => $log['message']
		]);
	}
}