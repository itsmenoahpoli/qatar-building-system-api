<?php
namespace App\Traits;

trait FileUpload {
  public function upload_application_attachement($file) {
    try {
      return 'File uploaded';
    } catch (Exception $e) {
      throw new Exception('Failed to upload attachement file');
    }
  }
}