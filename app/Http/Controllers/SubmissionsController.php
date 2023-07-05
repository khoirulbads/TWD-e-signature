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
use PDF;
use QrCode;
use \ConvertApi\ConvertApi;
use File;
use Illuminate\Support\Facades\Storage;

class SubmissionsController extends Controller
{
    public function signeeIndex(){
        $data = SubmissionsModel::withCount('documents')
            ->where('signee_id', Auth::user()->unique_id)
            ->orderBy('updated_at', 'DESC')->get();
        return view('Dashboard.Signee.submission', compact('data'));
    }

    public function signeeCreate(Request $request){
        $data = new SubmissionsModel();
        $docs = new DocumentsModel();

        $data->id = Uuid::uuid4();
        $data->signee_id = Auth::user()->unique_id;
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
    
    public function signeeReupload(Request $request, $id){
        $data = SubmissionsModel::where('id', $id)->first(); 
        $data->updated_at = Carbon::now();
        $data->status = 1;
        
        if ($request->hasFile('document')){
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

        return redirect('/signee/submissions/'.$id)->with('success', 'Berhasil upload berkas terbaru');
    
    }

    public function signeeDelete($id){
        $data = SubmissionsModel::where('id', $id)->delete();
        $docs = DocumentsModel::where('submission_id', $id)->delete();
   
        return redirect('/signee/submissions')->with('danger', 'Pengajuan Berkas telah dihapus!');
    }

    public function detail($id){
        $data = SubmissionsModel::with('signee', 'documents')
            ->where('id', $id)->first();
        
        if (Auth::user()->role == 3) {
            return view('Dashboard.Signee.detail', compact('data'));
        }
        
        return view('Dashboard.Signee.detail', compact('data'));
    }
    
    public function reject(Request $request, $submission_id){
        $data = SubmissionsModel::where('id', $submission_id)->first();
        $doc = DocumentsModel::where('submission_id', $submission_id)
            ->latest()->first();
        
        $data->status = 3;
        $doc->status = 3;
        $doc->notes = $request->notes;

        $data->save();
        $doc->save();

        return redirect('/signer/submissions/'.$submission_id)->with('danger', 'Pengajuan ditolak!!');    
    }
    public function approve($submission_id){
        $data = SubmissionsModel::where('id', $submission_id)->first();
        $doc = DocumentsModel::where('submission_id', $submission_id)
            ->latest()->first();
        
        $doc->status = 2;
        $data->status = 2;

        $data->save();
        $doc->save();

        $docs = new DocumentsModel();
        $docs->id = Uuid::uuid4();
        $docs->submission_id = $data->id;
        $docs->unique = $docs->id.Uuid::uuid4().$data->id;         
        $docs->file_name = 'assets/docs/'.$data->id.'-signed.pdf';
        $docs->file_mime = '.pdf';
        $docs->file_path = $docs->file_name;
        $docs->status = 5;
        $docs->save();

        $path = public_path().'/assets/docs/'.$doc->id;
        File::makeDirectory($path, $mode = 0777, true, true);
        
        ConvertApi::setApiSecret('IAelmlCkH8XXBqje');
        $result = ConvertApi::convert('png', [
                'File' => public_path('/'.$doc->file_name),
            ], 'pdf'
        );

        $result->saveFiles(public_path().'/assets/docs/'.$doc->id);
       
        $countFiles = count(File::files(public_path('assets/docs/'.$doc->id)));
        $data->qrcode = base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($docs->unique));
        $data->old_name = $doc->file_name;
        $data->count = $countFiles;
        $data->folder = $doc->id;
        
        PDF::loadView('/Dashboard/docs', compact('data'))->save('assets/docs/'.$data->id.'-signed.pdf');
        
        return redirect('/signer/submissions/'.$submission_id)->with('success', 'Pengajuan telah disetujui');
    }

    public function signerIndex(Request $request){
        $data = SubmissionsModel::withCount('documents', 'signee');

        if ($request->q_status == 1) {
            $data = $data->whereIn('status', [1,3]);
        }
        if ($request->q_status == 2) {
            $data = $data->whereIn('status', [2,4]);
        }
        $data = $data->orderBy('updated_at', 'DESC')->get();
        return view('Dashboard.Signer.submission-pengajuan', compact('data'));
    }
}
