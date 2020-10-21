<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Common;
use App\ContentManage;
use App\User;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ContentManageController extends Controller
{
    public function edit(Request $request)
    {
    	return view('admin.content_manage.content_manage');
    }

    public function update(Request $request)
    {
    	echo "<pre>";
    	print_r($request->toArray());
    	exit();
    }
}
