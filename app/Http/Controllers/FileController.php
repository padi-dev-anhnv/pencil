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
        $file = $this->fileRepo->create($request->all());
        return response()->json($file);
    }

    public function upload(Request $request)
    {
        $extAllow = File::$extAllow;
        $validatedData = $request->validate([
            'file' => 'required|file|mimes:'. join(",", $extAllow)
        ]);
        $file_uploaded = $this->fileService->uploadFile($request);
        return $file_uploaded;
    }

    public function download(Request $request)
    {
        return $this->fileService->download($request->id);
    }
}
