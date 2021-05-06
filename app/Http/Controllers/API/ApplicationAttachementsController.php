<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Applications\ApplicationAttachementData;
use Response;
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
            'file_path' => 'application-attachements/'.$attachement_filename,
            'file_name' => $filename,
            'file_extension' => '.'.$fileExtension
          ]);

          return response()->json($file_path, 201);
        }
      } catch(Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    /**
     * Return file from public storage folder
     *
     * @return \Illuminate\Http\Response
     */
    public function download_attachement($fileId)
    {
      $attachement = ApplicationAttachementData::findOrFail($fileId);


      $file = './storage/'.$attachement->file_path;
      $headers = array('Content-Type: application/*',);

      $downloadFileName = $attachement->file_name.$attachement->file_extension;

      return Response::download($file, $downloadFileName, $headers);
    }
}
