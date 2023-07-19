<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\SettingModel;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;
use File;

class SettingController extends Controller
{
    public function index(){
        $data = SettingModel::first();
        return view('Dashboard.Signer.setting', compact('data'));
    }

    public function save(Request $request){
        
        $data = SettingModel::first();
        if (!$data) {
            $data = new SettingModel();
            $data->id =  Uuid::uuid4();
        }

        if ($request->hasFile('signature')){
            $file = $request->file('signature')->store('assets/setting', ['disk' => 'my_files']);
            $data->signature = $file;
        }
        if ($request->hasFile('paraf')){
            $file = $request->file('paraf')->store('assets/setting', ['disk' => 'my_files']);
            $data->paraf = $file;
        }
        
        if ($request->setting_data){
            $data->signer_name = $request->signer_name;
            $data->location = $request->location;
            $data->department = $request->department;
        }

        $data->save();

        return redirect('/signer/setting')->with('success', 'Data Berhasil diupdate');
    }
}
