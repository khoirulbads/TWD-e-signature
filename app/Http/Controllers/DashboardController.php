<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\DocumentsModel;

use Ramsey\Uuid\Uuid;

class DashboardController extends Controller
{
    public function index(){
        return view('Dashboard.home');
    }

    public function docs($unique){
        $data = DocumentsModel::where('unique', $unique)->first();

        return view('Dashboard.docs', compact('data'));
    }
}
