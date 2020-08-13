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
        return redirect()->route('guide');
    }

    public function index()
    {
        return view('pages.guide.index');
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
    
    public function create(Request $request)
    {
        $id = intval($request->id);
        if($id == 0 || isset($request->guide['clone_id']))
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

    public function search(Request $request)
    {
        
        $guides = $this->guideRepo->search($request->all());
        return response($guides);
    }

    public function delete(Request $request)
    {
        $this->guideRepo->delete($request->id);
        return response()->json(['success' => true]);
    }

    public function clone(Request $request)
    {
        $this->guideRepo->clone($request->id);
        return response()->json(['success' => true]);
    }
}
