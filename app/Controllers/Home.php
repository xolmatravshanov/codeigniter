<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;

class Home extends BaseController
{

    public function index()
	{
		return view('welcome_message');
	}


    public function create()
    {
        return view('welcome_message');
    }


    public function update()
    {
        return view('welcome_message');
    }


    public function delete()
    {
        return view('welcome_message');
    }



}
