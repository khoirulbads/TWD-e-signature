<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\DocumentsModel;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use \ConvertApi\ConvertApi;
use Illuminate\Support\Facades\Storage;
use File;

class DashboardController extends Controller
{
    public function index(){
        return view('Dashboard.home');
    }

    public function subDocs(){
        $data = DocumentsModel::first();
        $path = \Storage::disk('local')->path($data->file_name);
        

        return view('Dashboard.subDocs', compact('path'));
    }

    public function docs(Request $req){
        $data = DocumentsModel::where('unique', 'f631180f-5077-4900-b1f0-9bc0dfa93fff11f9bc64-5da2-4f50-9582-89fd1105ab565b407eb9-7a2f-43db-a1a7-7f8f40a99b92')
            ->first();
        // $file = fopen(public_path('/'.$data->file_name), 'rb');
        
        ConvertApi::setApiSecret('IAelmlCkH8XXBqje');
        $result = ConvertApi::convert('png', [
                'File' => public_path('/'.$data->file_name),
            ], 'pdf'
        );

        
        return $result->getFile();
        // $response = env('APP_URL').'/'.$data->file_name;
    
        // return $storagePath;
        // return public_path();
        
    }

}
