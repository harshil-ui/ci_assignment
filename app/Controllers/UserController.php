<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends BaseController
{

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('user_type', 'Dealer');
        $query = $builder->get();
        $data = $query->getResultArray();

        return view('client/index', ['users' => $data]);
    }

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
            return redirect('/');
        }

        return view('Auth/login');
    }

    public function postRegister()
    {
        $validation = service('validation');

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'user_type' => 'required',
        ];

        if ($this->request->getPost('user_type') == 'Dealer') {
            $rules['city'] = 'required';
            $rules['state'] = 'required';
            $rules['zip_code'] = 'required';
        }

        $validation->setRules($rules);

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
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'user_type' => $this->request->getPost('user_type')
        ];

        if ($this->request->getPost('user_type') == 'Dealer') {
            $data['city'] = $this->request->getPost('city');
            $data['state'] = $this->request->getPost('state');
            $data['zip_code'] = $this->request->getPost('zip_code');
        }

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

    public function logOut()
    {
        session()->destroy();
        return redirect('/');
    }

    public function postLogin()
    {
        $email = $this->request->getPost('email');

        $db = \Config\Database::connect();

        // $builder = $db->table('users')->select('*')->where('email', $email);
        // $query = $builder->get();
        // $userExists = $query->getRow();

        $builder = $db->table('users');

        $builder->where('email', $email); // Adjust for custom primary key

        $query = $builder->get();
        $userExists = $query->getRowArray();
        // echo "<pre>";
        // print_r($userExists['password']);
        // echo "</pre>";
        // exit;

        if ($userExists && password_verify($this->request->getPost('password'), $userExists['password'])) {

            $this->setUserSession($userExists);

            return $this->response->setStatusCode(200)->setJSON([
                'success' => true,
                'message' => 'User logged in successfully',
                'data' => $userExists
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid credentials!'
        ]);
    }

    public function setUserSession($user)
    {
        // echo "<pre>";
        // print_r($user);
        // echo "</pre>";
        // exit;

        $data = [
            'id' => $user['id'],
            'user_type' => $user['user_type'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
        session()->regenerate(true);
    }

    public function edit($id)
    {
        // echo "<pre>";
        // print_r($id);
        // echo "</pre>";
        // exit;

        $user = new UserModel();
        $data['user'] = $user->find($id);

        // echo "<pre>";
        // print_r($data['user']);
        // echo "</pre>";
        // exit;
        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        return view('client/edit', ['user' => $data['user']]);
    }
}
