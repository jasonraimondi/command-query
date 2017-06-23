<?php
namespace Jmondi\Auth\Http\Controllers;

class ImplicitController extends Controller
{
    public function index()
    {
        return $this->renderView('@frontend/pages/home', []);
    }
}
