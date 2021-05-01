<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class ApplicationAttachementsController extends Controller
{
    /**
     * Store file into storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function upload_attachement(Request $request) {
      try {
        if($request->hasFile('file')) {
          $fileWithExtension = $request->file('file')->getClientOriginalName();
          $fileExtension = $request->file('file')->getClientOriginalExtension();
          $filename = pathinfo($fileWithExtension, PATHINFO_FILENAME);

          $attachement_filename = time().$fileWithExtension;

          $file_path = $request->file('file')->storeAs('public/application-attachements', $attachement_filename);
          $storage_path = $attachement_filename;

          return response()->json($file_path, 201);
        }
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    /**
     * Retrieve file from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retrieve_attachement($filename) {
      try {
        
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }
}
