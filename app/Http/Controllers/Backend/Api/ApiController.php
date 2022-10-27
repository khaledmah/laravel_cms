<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
class ApiController extends Controller
{
    public function comments_chart(){

        $comments=Comment::select(DB::raw('COUNT(*) as count'),DB::raw('MONTH(created_at) as month'))->whereYear('created_at',date('Y'))->groupBY(DB::raw('MONTH(created_at)'))->pluck('count','month');
    }
}
