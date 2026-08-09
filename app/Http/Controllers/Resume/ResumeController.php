<?php

namespace App\Http\Controllers\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Resume\Contact;
use App\Models\Resume\Resume;
use App\Models\Resume\Summary;
use App\Models\Resume\Template;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function preview(Request $request){
         Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($request->resume_id),
            'user_id'=>auth_user_id()
         ]
      );
      $data['cv']=Resume::where([
         'user_id'=>auth_user_id(),
         'id'=>unique_decrypt($request->resume_id)
         ])
      ->with([
         'experiences',
         'summary'
      ])->first();
      return view('pdfs.resume.default.resume',$data);
    }
    public function create()
    {
       $res= Resume::create([
        'status'=>'In Progress',
        'user_id'=>auth_user_id()
       ]);
       return redirect()->route('resume.edit',unique_encrypt($res->id));
    }
    public function pdf($id){
         $data['cv']=Resume::where([
               'user_id'=>auth_user_id(),
               'id'=>unique_decrypt($id)
               ])
            ->with([
               'experiences',
               'summary'
            ])->first();
            
      $pdf = Pdf::loadView('pdfs.resume.default.resume', $data);
      $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);
      //   dd($data['cv']);
      return $pdf->stream('resume.pdf');
      return $pdf->download($data['cv']->contact->desired_job_title.'.pdf');
    }
    public function edit($id)
    {
      $data['contact']=Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>auth_user_id()
         ]
      );
      $data['summary']=Summary::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>auth_user_id()
         ]
      );
      $data['template']=Template::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>auth_user_id()
         ]
      );
       return view('zeecv.resume.edit',$data);
    }
    public function payAndUnlock(){
       return view('zeecv.resume.payandunlock');
    }
    public function delete($id)
    {
       $resume= Resume::find(unique_decrypt($id));
       $resume->delete();
       return back()
            ->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => $resume->contact->desired_job_title." deleted successfully",
                    'type' => 'success',
                ]
            ]);
    }
 

}
