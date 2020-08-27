<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileService;
use App\Repository\FileRepository;
use App\Http\Requests\UploadFile;
use App\File;

class FileController extends Controller
{
    protected $fileService;
    protected $fileRepo ;

    public function __construct(FileService $fileService, FileRepository $fileRepository)
    {
        $this->fileService = $fileService;
        $this->fileRepo = $fileRepository;
    }

    public function search(Request $request)
    {
        return $this->fileRepo->search($request->all());
    }

    public function show(Request $request)
    {
        return $this->fileRepo->show($request->id);
    }

    public function create(UploadFile $request)
    {
        // upload file
        if(empty($request->id) || $request->fileUpload){
            $file_upload = $this->upload($request);
            foreach($file_upload as $key => $file)
            {
                $request->request->set($key,$file);
            }
        }
        $file = $this->fileRepo->create($request->all());
        return response()->json($file);
    }

    
    public function upload(Request $request)
    {
        $extAllow = File::$extAllow;
        $validatedData = $request->validate([
            'fileUpload' => 'required|file|mimes:'. join(",", $extAllow)
        ]);
        $file_uploaded = $this->fileService->uploadFile($request->file('fileUpload'));
        return $file_uploaded;
    }
/*
    public function upload_multi(Request $request)
    {
        foreach($request->files as $file)
        {
            $file
        }
        
    }
*/

    public function download(Request $request)
    {
        return $this->fileService->download($request->id);
    }

    public function delete(Request $request)
    {
        $result = $this->fileRepo->delete($request);
        return response()->json($result);
    }
}
