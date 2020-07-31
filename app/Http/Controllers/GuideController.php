<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\GuideRepository;
use App\Http\Requests\CreateGuide;

class GuideController extends Controller
{

    public function __construct(GuideRepository $guideRepo)
    {
        $this->guideRepo = $guideRepo;
    }

    public function homepage()
    {
        return redirect()->route('guide.index');
    }

    public function index()
    {
        return view('index');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        return view('index', ['id' => $id]);
    }

    public function listSuppliers()
    {
        return $this->guideRepo->listSuppliers();
    }
    
    public function create(CreateGuide $request)
    {
        $id = intval($request->id);
        if($id == 0 )
            $newGuide =  $this->guideRepo->create($request->all());
        else
            $newGuide =  $this->guideRepo->edit($request->all());
        return response()->json(['success' => true]);
    }

    public function getGuide(Request $request)
    {
        $guide = $this->guideRepo->get($request->id);
        return response()->json(['success' => true, 'data' => $guide]);
    }
}
