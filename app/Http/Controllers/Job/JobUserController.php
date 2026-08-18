<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\App\AppGoogleRecaptchaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Job\Models\JobApplication;
use App\Http\Controllers\Job\Models\JobCareer;
use App\Http\Controllers\Job\Models\UploadedResume;
use App\Http\Controllers\Resume\ResumeController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class JobUserController extends Controller
{
   public function index()
   {
     $data['record']=auth()->user();
     $data['url']= url('profile');
     return view('home.user.profile',$data);
   }
    public function customResumeUpload(Request $request){
        $input=$request->all();
        $item=UploadedResume::updateOrCreate([
            'user_id'=>auth_user_id()
        ]
        );
        $resume = $request->file('resume');
            if ($resume) {
                    $data['resume']=fun_save_file($resume,'zeecv/uploaded-resumes');
                    $item->resume_file_id=$data['resume']->id;
                    $item->save();
                }
        return redirect()->back()->with([
                'toast' => [
                    'heading' => 'Message',
                    'message' => 'Resume Updated successfully',
                    'type' => 'success',
                ]
            ]);
    }
    public function resumes(Request $request)
    {
        $data['resumes']=(new ResumeController())->process()->get();
        $data['custom_resumes']=(new ResumeController())->process()->get();
        return view('home.user.resumes',$data);
    }
    public function updateProfile(Request $request)
    {


        $user = auth()->user();
        $data = $request->only('name', 'phone', 'city', 'address', 'zipcode', 'about');
        $image = $request->file('avatar');

        if ($image) {
            $data['avatar'] =$saved_file=fun_save_file($image,'uploads')->id;
        }


        $user->update($data);

        $changes = $user->getChanges();
        $changes=array_keys($changes);
        $message='Profile has been updated with ';
        $c='';
        foreach ($changes as $v =>$it)
        {
            if($it!='updated_at')
            {
                $c=$c.','.$it;
            }

        }
        $message=$message.$c;



        if ($request->expectsJson)
        {
            return response()->json(['message'=>'Profile Updated']);
        }

         return redirect()
             ->back()
             ->with([
                 'toast' => [
                     'heading' => 'Message',
                     'message' => 'profile is updated',
                     'type' => 'success',
                 ]
             ]);

    }
}
