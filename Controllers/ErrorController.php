<?php

namespace App\Controllers;

class ErrorController extends Controller
{
    function index()
    {
        $this->render('error/index', [], 'defaultError');
    }
}