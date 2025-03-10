<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveImage($image, $path = 'public')
    {
      if (!$image) {
        return null;
      }

      $filename = time().'.png';
      // save image
      \Storage::disk($path)->put($filename, base64_decode($image));

      // return the path
      // URL is the base url exp: localhost:8000
      return URL::to('/').'/storage/'.$path.'/'.$filename;
    }

    public function saveImageEmployee($image, $path = 'public')
    {
      if (!$image) {
        return null;
      }
      // save image
      \Storage::disk($path)->put($image);

      // return the path
      // URL is the base url exp: localhost:8000
      return URL::to('/').'/storage/'.$path.'/';
    }
}
