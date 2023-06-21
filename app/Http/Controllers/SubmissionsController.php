<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Models\SubmissionsModel;
use App\Models\DocumentsModel;

class SubmissionsController extends Controller
{
    public function signeeIndex(){
        $data = SubmissionsModel::where('signee_id', Auth::user()->id)
            ->orderBy('updated_at', 'DESC')->get();
        return view('Dashboard.Signee.submission', compact('data'));
    }

    public function signeeCreate(Request $request){
        $data = new SubmissionsModel();
        $docs = new DocumentsModel();

        $data->id = Uuid::uuid4();
        $data->signee_id = Auth::user()->id;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->created_at = Carbon::now();
        $data->updated_at = Carbon::now();
        $data->status = 1;

        
        $docs->id = Uuid::uuid4();
        $docs->submission_id = $data->id;
        $docs->unique = $docs->id.Uuid::uuid4().$data->id; 
        if ($request->hasFile('document')){
            $path = $request->file('document')->store('assets/docs', ['disk' => 'my_files']);
            $docs->file_name = $path;
            $docs->file_mime = '.pdf';
            $docs->file_path = $path;
        }
        $docs->created_at = Carbon::now();
        $docs->updated_at = Carbon::now();
        $docs->status = 1;

        $data->save();
        $docs->save();

        return redirect('/signee/submissions')->with('msg', 'Pengajuan Berkas Berhasil');
    }
}
