<?php

namespace App\Http\Controllers\SP;

use App\Http\Controllers\Controller;
use App\Jobs\PM\PMTaskCommentAddJob;
use App\Jobs\SP\SPTicketCommentAddedJob;
use App\Models\PM\Project\PMMyTask;
use App\Models\PM\Project\PMTask;
use App\Models\PM\Project\PMTaskComment;
use App\Models\PM\Project\PMTaskLog;
use App\Models\SP\SPTicket;
use App\Models\SP\SPTicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SPTicketCommentController extends Controller
{
        public function index(Request $request)
    {
        $input=$request->all();
        $data['comments']=SPTicketComment::where([
            'ticket_id'=>$request->task_id
        ])
        ->when(!empty($input['last_id']),function($lq)use($input){
            $lq->where('id', '<', $input['last_id']);
        })
        ->when(!empty($input['exact__id']),function($lq)use($input){
            $lq->where('id', '=', $input['exact__id']);
        })
            ->orderByDesc('id')  // First get last two by ID
            ->limit(15)
            ->get()
            ->sortBy('id')       // Then sort them in ascending order
            ->values();
        $data['html']=view('sp.tickets.ajax.comments',$data)->render();
        if(!empty($input['exact__id']))
        {
          $data['last_id']='NA';
        }else
        {
         $data['last_id']=$data['comments']->first()->id ?? 0;
        }

         return response()->json($data);
    }

    public function add(Request $request)
    {

        $data=$request->except('_token');


        $mytask=(new SPController())->process()->find($data['task_id']);
        try{
            DB::beginTransaction();
            $pt=SPTicketComment::create([
                'comment'=>$data['comment'],
                'tagged_comment_id'=>$data['tagged_comment_id']??'',
                'ticket_id'=>$data['task_id'],
                'created_by_id'=>auth_user_id(),
                'user_id'=>auth_user_id(),
            ]);
            $attachment = $request->file('attachment');

                if ($attachment) {
                    $data['attachment']=fun_save_file($attachment,'uploads');
                    $pt->app_file_id=$data['attachment']->id;
                    $pt->save();
                }
                //asdasd
            DB::commit();
            foreach($mytask->members as $mem)
            {
               if($mem->user->id!=auth_user_id())
               {
             $mailData['email']=$mem->user->email;
            $mailData['ticket_id']=$mytask->id;
            $mailData['name']=$mem->user->name;
            $mailData['comment']=$data['comment'];
            $mailData['comment_id']=$pt->id;
            $mailData['user_id']=$mem->user->id;
            $mailData['task_title']='#'.unique_encrypt($mytask->id).' '.$mytask->subject;
            $mailData['redirect_url']=route('sp.tickets.chat',unique_encrypt($mytask->id));
            SPTicketCommentAddedJob::dispatch($mailData);
               }
            }
            if($mytask->user_id!=auth_user_id())
            {
            $mailData['email']=$mytask->user->email;
            $mailData['ticket_id']=$mytask->id;
            $mailData['name']=$mytask->user->name;
            $mailData['comment']=$data['comment'];
            $mailData['comment_id']=$pt->id;
            $mailData['user_id']=$mytask->user->id;
            $mailData['task_title']='#'.unique_encrypt($mytask->id).' '.$mytask->subject;
            $mailData['redirect_url']=route('sp.tickets.chat',unique_encrypt($mytask->id));
            SPTicketCommentAddedJob::dispatch($mailData);
            }

            // $members=$mytask->task->project->members;
            // if(!empty($mytask->assignee) && $mytask->assignee->id!=auth()->user()->id)
            //  {
            // $mailData['email']=$mytask->assignee->email;
            // $mailData['task_id']=$mytask->id;
            // $mailData['name']=$mytask->assignee->name;
            // $mailData['comment']=$data['comment'];
            // $mailData['comment_id']=$pt->id;
            // $mailData['user_id']=$mytask->assignee->id;
            // $mailData['task_title']='#'.$mytask->task_no.' '.$mytask->task->title;
            // $mailData['redirect_url']=route('pm.p.tasks.update',$mytask->id).'?back_url='.route('pm.p.tasks.view');
            // SPTicketCommentAddedJob::dispatch($mailData);
            //  }
            // if(!empty($members))
            // {
            // foreach($members as $m)
            // {
            //  if($m->user->id!=auth()->user()->id)
            //  {
            // $mailData['email']=$m->user->email;
            // $mailData['name']=$m->user->name;
            // $mailData['comment']=$data['comment'];
            // $mailData['comment_id']=$pt->id;
            // $mailData['task_id']=$mytask->id;
            // $mailData['user_id']=$m->user->id;
            // $mailData['task_title']='#'.$mytask->task_no.' '.$mytask->task->title;
            // $mailData['redirect_url']=route('pm.p.tasks.update',$mytask->id).'?back_url='.route('pm.p.tasks.view');
            // PMTaskCommentAddJob::dispatch($mailData);
            //  }
            // }
            // }


         return response()->json(['code'=>1,'message'=>"Comment added successfully!",'item'=>$pt]);
        }catch(\Exception $e)
        {
            dd($e);
            DB::rollBack();
           return response()->json(['code'=>0,'message'=>$e->getMessage()]);
        }

    }



}
