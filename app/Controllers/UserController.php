<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\HTTP\RequestInterface;

class UserController extends BaseController
{

    public function index()
    {
        $user = new User();

        $data['user_data'] = $user->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $user->pager;

        return view('user/index', $data);

    }


    public function add()
    {
        return view('add_data');
    }


    public function add_validation()
    {

        helper(['form', 'url']);

        $error = $this->validate([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'gender' => 'required'
        ]);


        if (!$error) {

            echo view('add_data', [
                'error' => $this->validator
            ]);

        } else {

            $user = new User();

            $user->save([
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'gender' => $this->request->getVar('gender'),
            ]);

            $session = \Config\Services::session();

            $session->setFlashdata('success', 'User Data Added');

            return $this->response->redirect(site_url('/crud'));

        }

    }

    // show single user
    function fetch_single_data($id = null)
    {
        $crudModel = new User();

        $data['user_data'] = $crudModel->where('id', $id)->first();

        return view('edit_data', $data);
    }

    public function edit_validation()
    {
        helper(['form', 'url']);

        $error = $this->validate([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'gender' => 'required'
        ]);

        $user = new User();

        $id = $this->request->getVar('id');

        if (!$error) {
            $data['user_data'] = $user->where('id', $id)->first();
            $data['error'] = $this->validator;
            echo view('edit_data', $data);
        } else {
            $data = [
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'gender' => $this->request->getVar('gender'),
            ];

            $user->update($id, $data);

            $session = \Config\Services::session();

            $session->setFlashdata('success', 'User Data Updated');

            return $this->response->redirect(site_url('/crud'));
        }
    }

    public function delete($id)
    {

        $user = new User();

        $user->where('id', $id)->first();

        $user->delete();

    }

}
