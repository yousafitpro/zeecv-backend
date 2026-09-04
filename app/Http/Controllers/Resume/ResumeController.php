<?php

namespace App\Http\Controllers\Resume;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WebAuthController;
use App\Models\Resume\Contact;
use App\Models\Resume\Experience;
use App\Models\Resume\Resume;
use App\Models\Resume\Summary;
use App\Models\Resume\Template;
use App\Models\User;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function updateSortOrder(Request $request){
        $order = $request->input('order', []);

         foreach ($order as $item) {

            Experience::where('id', $item['id'])
                  ->where('resume_id', unique_decrypt($request->resume_id))
                  ->update([
                     'sort_order' => $item['sort_order']
                  ]);
         }

         return response()->json([
            'success' => true,
            'message' => 'Experience order updated successfully'
         ]);
    }
    public function emailTest(Request $request){
      (new WebAuthController())->createEmailVerification(auth()->user()->id);
      dd(auth()->user()->email);
    }
    public function preview(Request $request){
      $resume=Resume::find(unique_decrypt($request->resume_id));
         Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($request->resume_id),
            'user_id'=>$resume->user_id
         ]
      );
      $data['cv']=Resume::where([
         'user_id'=>$resume->user_id,
         'id'=>unique_decrypt($request->resume_id)
         ])
      ->with([
         'experiences',
         'summary'
      ])->first();
      $template=!empty($data['cv']->template->template)?$data['cv']->template->template:'default';
      return view('pdfs.resume.'.$template.'.resume',$data);
    }
    public function rawPDF(Request $request,$id){
         Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>auth_user_id()
         ]
      );
      $data['cv']=Resume::where([
         'user_id'=>auth_user_id(),
         'id'=>unique_decrypt($id)
         ])
      ->with([
         'experiences',
         'summary'
      ])->first();
      $template=!empty($data['cv']->template->template)?$data['cv']->template->template:'default';
      $data['r_id']=$id;
      return view('mobile-app.pdf_iframe',$data);
    }
    public function create()
    {
      if(Resume::where(['user_id'=>auth_user_id()])->count()>10){
                return back()
            ->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' =>"You cannot add resume more than 10",
                    'type' => 'danger',
                ]
            ]);
      }
       $res= Resume::updateOrCreate([
        'user_id'=>auth_user_id()
       ]);
       $data['contact']=Contact::create(
         [
            'resume_id'=>$res->id,
            'user_id'=>auth_user_id()
         ]
      );
      $templates=zeecv_templates();
       $data['template']=Template::create(
         [
            'resume_id'=>$res->id,
            'user_id'=>auth_user_id(),
            'template'=>'default',
            'default_color'=>$templates['default']['color'],
            'color'=>$templates['default']['color'],
            'default_template'=>'default'
         ]
      );
       return redirect()->route('resume.edit',unique_encrypt($res->id));
    }
    public function pdf(Request $request,$id){
      if(!auth()->check() && !empty($request->resume_token)){
         $user=User::where('login_token',$request->resume_token)->first();
         auth()->login($user);
      }
      
         $data['cv']=Resume::where([
               // 'user_id'=>auth_user_id(),
               'id'=>unique_decrypt($id)
               ])
            ->with([
               'experiences',
               'summary'
            ])->first();
      $template=!empty($data['cv']->template->template)?$data['cv']->template->template:'default';  
      $pdf = Pdf::loadView('pdfs.resume.'.$template.'.resume', $data);
      $pdf->setOptions([
         'isHtml5ParserEnabled' => true,
         'isRemoteEnabled' => true,
         'defaultPaperSize' => 'a4',  // Add this line
      ]);
      //   dd($data['cv']);
      // return $pdf->stream('resume.pdf');
      return $pdf->download($data['cv']->contact->desired_job_title.'.pdf');
    }
    public function pdfPreview(Request $request,$id){
       $input=$request->all();
      if(!auth()->check() && !empty($input['resume_token'])){
         $user=User::where('login_token',$request->resume_token)->first();
         auth()->login($user);
      }
         $data['cv']=Resume::where([
               // 'user_id'=>auth_user_id(),
               'id'=>unique_decrypt($id)
               ])
            ->with([
               'experiences',
               'summary'
            ])->first();
      $template=!empty($data['cv']->template->template)?$data['cv']->template->template:'default';  
      $pdf = Pdf::loadView('pdfs.resume.'.$template.'.resume', $data);
      $pdf->setOptions([
         'isHtml5ParserEnabled' => true,
         'isRemoteEnabled' => true,
         'defaultPaperSize' => 'a4',  // Add this line
      ]);
      //   dd($data['cv']);
      return $pdf->stream('resume-'.now().'.pdf');
      return $pdf->download($data['cv']->contact->desired_job_title.'.pdf');
    }
    public function pdfPreview2(Request $request,$id){
       $input=$request->all();
      if(!auth()->check() && !empty($input['resume_token'])){
         $user=User::where('login_token',$request->resume_token)->first();
         auth()->login($user);
      }
         $data['cv']=Resume::where([
               // 'user_id'=>auth_user_id(),
               'id'=>unique_decrypt($id)
               ])
            ->with([
               'experiences',
               'summary'
            ])->first();
      $template=!empty($data['cv']->template->template)?$data['cv']->template->template:'default';  
      $pdf = Pdf::loadView('pdfs.resume.'.$template.'.resume', $data);
      $pdf->setOptions([
         'isHtml5ParserEnabled' => true,
         'isRemoteEnabled' => true,
         'defaultPaperSize' => 'a4',  // Add this line
      ]);
      //   dd($data['cv']);
      return $pdf->stream('resume-'.now().'.pdf');
      return $pdf->download($data['cv']->contact->desired_job_title.'.pdf');
    }
    public function updateTemplate(Request $request){
        $resume=$this->process()->where('id',unique_decrypt($request->resume_id))->first();
        $template=zeecv_templates()[$request->template];
        Template::where('resume_id',$resume->id)->update(
         [
            'template'=>$request->template,
            'default_color'=>$template['color'],
            'color'=>$template['color']
         ]
      );
        return response()->json(['code'=>1,'message'=>'updated successfully']);
    }
    public function edit($id)
    {
      $resume=Resume::find(unique_decrypt($id));
      $data['contact']=Contact::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>$resume->user_id
         ]
      );
      $data['summary']=Summary::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>$resume->user_id
         ]
      );
      $data['template']=Template::updateOrCreate(
         [
            'resume_id'=>unique_decrypt($id),
            'user_id'=>$resume->user_id
         ]
      );
       $data['templates']=zeecv_templates();
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
   public function process(){
       return Resume::query()
       ->when(!is_admin(),function ($query) {
         return $query->where('user_id',auth_user_id());
       });
       
    }
 

}
