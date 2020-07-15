<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function postLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials,true)) {
            return redirect()->intended('/');
        }
        return redirect()->back();
    }

    public function list()
    {
    //    $this->authorize('list', \App\User::class);
        /*
        $user = auth()->user();
        $users = \App\User::find(1);
        if ($user->can('list', $user)) {
            dd("Người dùng được quyền xem");
          } else {
            dd("Người dùng không được quyền xem.");
          }
          */
        $users = \App\User::orderBy('id', 'desc')->with('role')->paginate(10);
        return view('pages.user.index', compact('users'));
    }
}
