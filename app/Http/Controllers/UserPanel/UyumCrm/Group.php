<?php

namespace App\Http\Controllers\UserPanel\UyumCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Group extends Controller
{
    public function Index()
    {
        return view('pages.uyum-crm.group.index');
    }
}
