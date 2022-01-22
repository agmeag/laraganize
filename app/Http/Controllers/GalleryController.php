<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function view()
    {
        return view('gallery');
    }

    public function getFileList(Request $request)
    {
        $photo_path = [];
        $folders = json_decode($request->folders);
        $current_folder = ($request->current_folder);
        if ($current_folder != null && $current_folder != '') {
            if ($current_folder == 'gallery') {
                $filesInFolder = File::files($current_folder);
            } else {
                $filesInFolder = File::files('gallery' . $current_folder);
            }
        } else {
            $filesInFolder = File::files('gallery');
        }



        foreach ($folders as $file) {
            if ($file->url != 'gallery') {
                if (!file_exists(public_path('gallery') . $file->url)) {
                    if (!mkdir(public_path('gallery') . $file->url, 0777, true)) {
                        return 'Fallo al crear las carpetas...';
                    }
                }
            }
        }
        foreach ($filesInFolder as $path) {
            $photo_path[] = pathinfo($path);
        }
        return $photo_path;
    }
}
