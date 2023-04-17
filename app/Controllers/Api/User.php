<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Shield\Models\UserModel;

class User extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $users = new UserModel();

        return $this->respond(
            [
                'users' => $users->findAll(),
                'you'   => auth()->user(),
            ],
            200
        );
    }
}
