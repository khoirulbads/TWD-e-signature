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
use App\Models\SettingModel;
use PDF;
use QrCode;
use \ConvertApi\ConvertApi;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubmitEmail;
use setasign\Fpdi\Fpdi;

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
       
        $data->signee = User::where('unique_id', $data->signee_id)->first();

        // \Mail::to($data->signee->email)->send(new \App\Mail\SubmitEmail($data));
        // \Mail::to(User::select('email')->where('role', 2)->first()->email)->send(new \App\Mail\SubmitSignerEmail($data));
       
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
        
        \Mail::to(User::select('email')->where('role',2)->first()->email)->send(new \App\Mail\ReuploadEmail($data));
       
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
        
        \Mail::to($data->signee->email)->send(new \App\Mail\RejectEmail($data));
       
        return redirect('/signer/submissions/'.$submission_id)->with('danger', 'Pengajuan ditolak!!');    
    }
    public function approve($submission_id, Request $request){
        
        $data = SubmissionsModel::where('id', $submission_id)->first();
        $doc = DocumentsModel::where('submission_id', $submission_id)
            ->where('status', 1)
            ->latest()->first();
        $setting = SettingModel::first();
        
        $docs = new DocumentsModel();
        $docs->id = Uuid::uuid4();
        $docs->submission_id = $data->id;
        $docs->unique = $docs->id.Uuid::uuid4().$data->id;         
        $docs->file_name = 'assets/docs/'.$data->id.'-signed.pdf';
        $docs->file_mime = '.pdf';
        $docs->file_path = $docs->file_name;
        $docs->action_taken_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->toDateTimeString();
        $docs->status = 5;
        $docs->save();
        // $pdfData->qrcode = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate($docs->unique));
        
        
        // Path ke PDF yang ada
        $existingPdfPath = public_path($doc->file_name);
        
        // Path untuk menyimpan PDF yang sudah diubah
        $outputPdfPath = public_path('assets/docs/'.$data->id.'-signed.pdf');

        // Load existing PDF dengan FPDI
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($existingPdfPath);
        $pageNo = $request->page;
       
        // Pilih halaman yang ingin diubah (misalnya halaman ke-2)
        for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
            $templateId = $pdf->importPage($pageNumber);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);

            if($pageNumber == $pageNo && $request->is_signature == 'yes'){
                $imagePath = public_path($setting->signature);
                $x = $request->x;
                $y = $request->y;
                $size = $request->size;
                $pdf->Image($imagePath, $x, $y, $size, 0, 'PNG');        
            }
            
            $pdf->SetFont('Arial', '', 8);
            $pdf->Text(10, 287, $docs->action_taken_at.' WIB');
            $parafPath = public_path($setting->paraf);
            $pdf->Image($parafPath, 10, 275, 40, 0, 'PNG');        
//             

        }
        
        // Simpan PDF yang sudah diubah
        $pdf->Output($outputPdfPath, 'F');

        // return response()->download($outputPdfPath);
    
        $data->status = 2;
        $data->save();
        $doc->status = 2;
        $doc->save();
       
        $data->approved = $docs;
        \Mail::to($data->signee->email)->send(new \App\Mail\ApproveEmail($data));
        \Mail::to(Auth::user()->email)->send(new \App\Mail\ApproveSalinanEmail($data));
        \Mail::to(SettingModel::select('legal_email')->first()->legal_email)->send(new \App\Mail\ApproveSalinanEmail($data));

        // if ($request->is_signature == 'yes') {
        //     return response('success');
        // }
        return redirect('/signer/submissions/'.$submission_id)->with('success', 'Pengajuan telah disetujui');
    }

    public function process($submission_id){
        $data = SubmissionsModel::where('id', $submission_id)->first();
        $doc = DocumentsModel::where('submission_id', $submission_id)
            ->where('status', 1)
            ->latest()->first();
        // dd($doc);

        $path = public_path().'/assets/docs/'.$doc->id;

        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        
            ConvertApi::setApiSecret(config('app.convert_api_secret'));
            ConvertApi::$connectTimeout = 10;
            
            try {
                $result = ConvertApi::convert('png', ['File' => public_path('/'.$doc->file_name)], 'pdf');
                $result->saveFiles(public_path().'/assets/docs/'.$doc->id);
            } catch (\ConvertApi\Error\Api $error) {
                echo "Got API error code: " . $error->getCode() . "\n";
                echo $error->getMessage();
                echo "<br /><a href='/signer/submissions?q_status=1'>Kembali ke awal.</a>";
                return false;
            }        
        } 
        
        $countFiles = count(File::files(public_path('assets/docs/'.$doc->id)));
        $pdfData = $data->replicate();
        $pdfData->count = $countFiles;
        $pdfData->old_name = $doc->file_name;
        $pdfData->folder = $doc->id;
        $pdfData->setting = SettingModel::first();
        
        // dd($pdfData);
        return view('/Dashboard/Signer/process', compact('data', 'doc', 'pdfData'));
    
    }

    public function save(Request $request, $submission_id)
    {
        $data = SubmissionsModel::where('id', $submission_id)->first();
        $doc = DocumentsModel::where('submission_id', $submission_id)
            ->where('status', 1)
            ->latest()->first();
        $setting = SettingModel::first();
        
        $docs = new DocumentsModel();
        $docs->id = Uuid::uuid4();
        $docs->submission_id = $data->id;
        $docs->unique = $docs->id.Uuid::uuid4().$data->id;         
        $docs->file_name = 'assets/docs/'.$data->id.'-signed.pdf';
        $docs->file_mime = '.pdf';
        $docs->file_path = $docs->file_name;
        $docs->action_taken_at = Carbon::now(new \DateTimeZone('Asia/Jakarta'))->toDateTimeString();
        $docs->status = 5;
        $docs->save();
        // $pdfData->qrcode = base64_encode(QrCode::format('svg')->size(80)->errorCorrection('H')->generate($docs->unique));
        
        
        // Path ke PDF yang ada
        $existingPdfPath = public_path($doc->file_name);
        
        // Path untuk menyimpan PDF yang sudah diubah
        $outputPdfPath = public_path('assets/docs/'.$data->id.'-signed.pdf');

        // Load existing PDF dengan FPDI
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($existingPdfPath);
        $pageNo = $request->page;
        
        // Pilih halaman yang ingin diubah (misalnya halaman ke-2)
        for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
            $templateId = $pdf->importPage($pageNumber);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);

            if($pageNumber == $pageNo){
                $imagePath = public_path($setting->signature);
                $x = $request->x;
                $y = $request->y;
                $size = $request->size;
                $pdf->Image($imagePath, $x, $y, $size, 0, 'PNG');        
            }
            
            $pdf->SetFont('Arial', '', 8);
            $pdf->Text(10, 290, $docs->action_taken_at.' WIB');

            $parafPath = public_path($setting->paraf);
            $pdf->Image($parafPath, 45, 283, 13, 0, 'PNG');        
            
        }
        
        // Simpan PDF yang sudah diubah
        $pdf->Output($outputPdfPath, 'F');

        $data->status = 2;
        $data->save();
        $doc->status = 2;
        $doc->save();
       
        $data->approved = $docs;
        \Mail::to($data->signee->email)->send(new \App\Mail\ApproveEmail($data));
        \Mail::to(Auth::user()->email)->send(new \App\Mail\ApproveSalinanEmail($data));
        \Mail::to(SettingModel::select('legal_email')->first()->legal_email)->send(new \App\Mail\ApproveSalinanEmail($data));

        return response()->download($outputPdfPath);
    
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

    public function adminIndex(Request $request){
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

    public function subEmail($sub_id){
        $data = SubmissionsModel::where('id', $sub_id)->first();
        
        \Mail::to($data->signee->email)->send(new \App\Mail\SubmitEmail($data));
       
        dd("Email sudah terkirim.");
        // return view('emails.reject', compact('data'));
        
    }

    public function rejectEmail($sub_id){
        $data = SubmissionsModel::where('id', $sub_id)->first();
        
        \Mail::to($data->signee->email)->send(new \App\Mail\RejectEmail($data));
       
        dd("Email sudah terkirim.");
    
        // return view('emails.reject', compact('data'));
        
    }
    
    public function approveEmail($sub_id){
        $data = SubmissionsModel::where('id', $sub_id)->first();
        $data->approved = DocumentsModel::where('submission_id', $sub_id)->where('status', 5)->first();
        
        \Mail::to($data->signee->email)->send(new \App\Mail\ApproveEmail($data));
       
        // dd("Email sudah terkirim.");
    
        return view('emails.approve-salinan', compact('data'));
        
    }
    
    public function checkDoc($unique)
    {
        // Check if the data exists based on $qrData
        $data = DocumentsModel::where('unique', $unique)
            ->where('status',5)->first();
    
        if ($data) {
            return response()->json(['exists' => true, 'data' => $data]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    
}
