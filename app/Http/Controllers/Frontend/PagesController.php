<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * API documentation pages
     */
    public function api_index(Request $request) {
        $authorized_access_token = $request->get('aat');
    }
}
