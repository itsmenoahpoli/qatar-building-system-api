<?php

namespace App\Traits;

use App\Models\LogUserSession;

trait Logging {
	public function saveAuthLog(array $log) {
		LogUserSession::create([
			'user_id' => $log['user_id'],
			'message' => $log['message']
		]);
	}
}