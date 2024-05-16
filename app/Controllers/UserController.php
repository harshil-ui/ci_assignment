<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends BaseController
{
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect('/');
        }

        return view('Auth/register');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->back();
        }

        return view('Auth/login');
    }

    public function postRegister()
    {
        $validation = service('validation');

        $validation->setRules([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'user_type' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $user = new UserModel();

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'user_type' => $this->request->getPost('user_type')
        ];

        if ($user->save($data)) {
            $data['id'] = $user->insertID();
            $this->setUserSession($data);

            return $this->response->setStatusCode(200)->setJSON([
                'success' => true,
                'message' => 'User registered successfully'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to register the user'
            ]);
        }
    }

    public function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'user_type' => $user['user_type'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
    }

    public function logOut()
    {
        session()->destroy();
        return redirect('/');
    }

    // public function postLogin()
    // {
    //     $user = new UserModel();

    //     $userExists = $user->where('email', $this->request->getPost('email'))->first();

    //     var_dump($userExists);
    //     exit;
    // }
}
