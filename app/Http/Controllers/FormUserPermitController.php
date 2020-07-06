<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormUserPermitController extends Controller
{
    public function index(){
        return view('form_user_permit.index');
    }

    public function create(){
        return view('form_user_permit.create');
    }

    public function store(){

    }
}
