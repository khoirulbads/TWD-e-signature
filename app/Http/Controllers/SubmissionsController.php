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
        $data = SubmissionsModel::withCount('documents')
            ->where('signee_id', Auth::user()->id)
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

        return redirect('/signee/submissions')->with('success', 'Pengajuan Berkas Berhasil');
    }

    public function signeeUpdate(Request $request, $id){
        $data = SubmissionsModel::where('id', $id)->first();
        
        $data->title = $request->title;
        $data->description = $request->description;
        $data->updated_at = Carbon::now();
        
        if ($request->hasFile('document')){
            DocumentsModel::where('submission_id', $id)->delete();
            $docs = new DocumentsModel();
            $docs->id = Uuid::uuid4();
            $docs->submission_id = $data->id;
            $docs->unique = $docs->id.Uuid::uuid4().$data->id; 
        
            $path = $request->file('document')->store('assets/docs', ['disk' => 'my_files']);
            
            $docs->file_name = $path;
            $docs->file_mime = '.pdf';
            $docs->file_path = $path;
            $docs->status = 1;

            $docs->save();
        }
        $data->save();

        return redirect('/signee/submissions')->with('warning', 'Pengajuan Berkas telah diupdate!');
    
    }


    public function signeeDelete($id){
        $data = SubmissionsModel::where('id', $id)->delete();
        $docs = DocumentsModel::where('submission_id', $id)->delete();
   
        return redirect('/signee/submissions')->with('danger', 'Pengajuan Berkas telah dihapus!');
    }

    public function Detail($id){
        $data = SubmissionsModel::with('signee', 'documents')
            ->where('id', $id)->first();
        
        if (Auth::user()->role == 3) {
            return view('Dashboard.Signee.detail', compact('data'));
        }
        return redirect('/signee/submissions')->with('warning', 'Pengajuan Berkas telah diupdate!');
    
    }
}
