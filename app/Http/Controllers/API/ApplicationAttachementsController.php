<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationAttachementData;
use Storage;

class ApplicationAttachementsController extends Controller
{
    /**
     * Store file into storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function upload_attachements(Request $request) {
      try {
        if($request->hasFile('file')) {
          $fileWithExtension = $request->file('file')->getClientOriginalName();
          $fileExtension = $request->file('file')->getClientOriginalExtension();
          $filename = pathinfo($fileWithExtension, PATHINFO_FILENAME);

          $attachement_filename = time().$fileWithExtension;

          $file_path = $request->file('file')->storeAs('public/application-attachements', $attachement_filename);
          $storage_path = $attachement_filename;
          
          // Tag attachement under application record
          ApplicationAttachementData::create([
            'application_record_id' => $request->application_record_id,
            'attachement_type' => $request->attachement_type,
            'file_path' => $file_path,
            'file_name' => $filename
          ]);

          return response()->json($file_path, 201);
        }
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }
}
