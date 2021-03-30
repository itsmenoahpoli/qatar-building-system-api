<?php

namespace App\Traits;

use App\Models\Logs\LogUserSession;

trait Logging {
	public function save_authentication_log(array $log) {
		LogUserSession::create([
			'user_id' => $log['user_id'],
			'message' => $log['message']
		]);
	}
}