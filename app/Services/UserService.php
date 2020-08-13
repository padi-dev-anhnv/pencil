<?php
namespace App\Services;

use App\Repository\UserRepository;
use Illuminate\Http\Request;

class UserService
{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function create(Request $request)
    {
        $this->userRepo->create($request->all());
    }

    public function list(Request $request)
    {
        return $this->userRepo->list($request);
    }

    public function delete($id)
    {
        return $this->userRepo->delete($id);
    }

    public function show($id)
    {
        return $this->userRepo->show($id);
    }

    public function listUserPerFile()
    {
        return $this->userRepo->listUserPerFile();
    }
    
}