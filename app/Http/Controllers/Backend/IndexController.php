<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct(){
        if(!auth()->check()){
            return redirect()->route('admin.login');
        }

    }
    public function index(){
        if(auth()->check()){
            return view('backend.index');
             }
             return redirect()->route('admin.login');
            
        }
        
}
