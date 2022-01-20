<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PhotoGalleryController extends Controller
{
    public function view()
    {
        return view('photo-gallery');
    }

    public function getFileList(Request $request)
    {
        $photo_path = [];
        $filesInFolder = File::files('gallery');
        $folders = json_decode($request->folders);

        foreach ($folders as $file) {
            if (!file_exists(public_path('gallery') . $file->url)) {
                if (!mkdir(public_path('gallery') . $file->url, 0777, true)) {
                    return 'Fallo al crear las carpetas...';
                }
            }
        }
        foreach ($filesInFolder as $path) {
            $photo_path[] = pathinfo($path);
        }
        return $photo_path;
    }

    public function deleteFile(Request $request)
    {
        $query = $request->image;
        if ($query and file_exists(public_path() . $query)) {
            unlink(public_path() . $query);
        }
    }

    public function moveFile(Request $request)
    {
        if ($request->folderNameCheck == 1) {
            $newFileName = $request->fileName;
            $newFileName = explode('/gallery', $request->fileName);
            $newFileName = implode($newFileName);
            $newFileName = explode('/', $newFileName);
            $newFileName = implode($newFileName);
            $newFileName = explode('.', $newFileName);
            $folderDirectory = 'gallery' . $request->newPath;
            $filesInFolder = File::files($folderDirectory);
            $count = (count($filesInFolder) < 10 ? '0' . (count($filesInFolder) + 1) : count($filesInFolder) + 1);
            $newFileName[0] =  $request->folderName . '_' . $count . '.';
            $newFileName = implode($newFileName);
        }
        if ($request->folderNameCheck == 2) {
            if ($request->customNameCheck == 1) {
                if ($request->newFileName && $request->newFileName != '' && $request->newFileName != null && $request->newFileName != $request->fileName) {
                    $newFileName = $request->newFileName;
                } else {
                    $newFileName = $request->fileName;
                    $newFileName = explode('/gallery', $request->fileName);
                    $newFileName = implode($newFileName);
                    $newFileName = explode('/', $newFileName);
                    $newFileName = implode($newFileName);
                }
            } else {
                $newFileName = $request->fileName;
                $newFileName = explode('/gallery', $request->fileName);
                $newFileName = implode($newFileName);
                $newFileName = explode('/', $newFileName);
                $newFileName = implode($newFileName);
            }
        }
        $currentFileName = public_path() . $request->fileName;
        $destinationPath = $request->newPath;
        $moveFile = public_path('gallery') . $destinationPath . '/' . $newFileName;
        File::move($currentFileName, $moveFile);
        return $moveFile;
    }
}
