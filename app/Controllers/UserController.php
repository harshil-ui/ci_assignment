<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            $user = new UserModel();

            $query = $this->request->getGet('query');

            $users = $user->orderBy('id', 'DESC')
                ->where('user_type', 'Dealer');

            if (!empty($query)) {
                $users = $users->like('zip_code', $query);
            }

            $users = $users->paginate(10);

            $data = [
                'users' => $users,
                'pager' => $user->pager,
            ];

            return view('client/index', $data);
        }

        return redirect('login');
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
                'errors' => 'Failed to register the user'
            ]);
        }
    }

    public function logOut()
    {
        if (session()->get('isLoggedIn')) {
            session()->destroy();
            return redirect('/');
        }

        return redirect('login');
    }

    public function postLogin()
    {
        $email = $this->request->getPost('email');

        $db = \Config\Database::connect();

        $builder = $db->table('users');

        $builder->where('email', $email);

        $query = $builder->get();

        $userExists = $query->getRowArray();

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

    public function edit($id)
    {
        if (session()->get('isLoggedIn')) {

            $user = new UserModel();
            $data['user'] = $user->find($id);

            if (!$data['user']) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
            }

            return view('client/edit', ['user' => $data['user']]);
        }

        return redirect('login');
    }

    public function update()
    {
        $user = new UserModel();
        $id = $this->request->getPost('id');

        $validation = service('validation');
        $rules = [
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required'
        ];

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }


        $data = [
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip_code' => $this->request->getPost('zip_code')
        ];

        if ($user->update($id, $data)) {

            return $this->response->setStatusCode(200)->setJSON([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'errors' => 'Failed to update the user'
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
        session()->regenerate(true);
    }
}
