<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateUser;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService ; 

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        if(auth()->user())
            return redirect()->route('guide');
        else
            return view('login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $credentials['status'] = 1;

        if (Auth::attempt($credentials,true)) {
            return redirect()->intended('/');
        }
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function list(Request $request)
    {
    //    $this->authorize('list', \App\User::class);       
        $users = $this->userService->list($request);
        return response()->json($users);
    }

    public function delete(Request $request)
    {        
        $this->userService->delete($request->id);
        return response()->json([ 'status' => "ok"]);
    }

    public function getRoles()
    {
        $roles = \App\Role::all();
        return response()->json($roles);
    }

    public function create(CreateUser $request)
    {
        $this->userService->create($request);
        return response()->json([ 'status' => "ok"]);
    }

    public function show(Request $request)
    {
        $user = $this->userService->show($request->id);
        return response()->json($user);
    }

    public function getOffices()
    {
        $offices = \App\Office::all('id', 'name');
        return $offices;
    }

    public function getWorkers()
    {
        $users = \App\User::whereHas('role', function($query){
            $query->where('type', 'worker');
        })->select('id', 'name')->get();
        return $users;
    }

    public function listUserPerFile()
    {
        $users = $this->userService->listUserPerFile();
        return response()->json($users);
    }
    

}
