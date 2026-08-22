<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Models\zErrorLog\zErrorLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];
    public function report(Throwable $e)
    {


        if ($this->isNotFoundException($e) || $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return; // Skip logging
        }

        if (str_contains($e->getMessage(), 'method is not supported')) {
            return; // Skip logging
        }
        //adasd
        Log::channel('error_log')->error("Handler Error");
        Log::channel('error_log')->error($e->getMessage());
        Log::channel('error_log')->error($e);

           $user=null;
          try{
             if(auth()->check())
           {
            $user=auth()->id();
           }
           if(request()->header('client-id') && request()->header("api-key"))
           {
           }
           if(!empty($user))
           {
            Log::channel('error_log')->error("User ID : ".$user);
           }
           if($this->isHttpException($e)){

           }else
           {
            // if(zErrorLog::whereDate('created_at',today_date())->get()->count()<=200)
            // {
            //     // zErrorLog::create([
            //     //     'code'=>$e->getCode(),
            //     //     'message'=>$e->getMessage(),
            //     //     'user_id'=>$user,
            //     //     'payload'=>$e,
            //     //  ]);
            // }

           }

           return response()->json([
            'error' => 'biller_communication_error',
            'message' => 'Non-response - Biller Communication Error'
        ], 500);
          }catch(\Exception $e){}

    }
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    protected function isNotFoundException(Throwable $e)
    {
        // Check if the exception is a NotFoundHttpException (404 Not Found)
        return $e instanceof NotFoundHttpException;
    }
    public function register()
    {


    }
    public function render($request, Throwable $exception)
        {
            if ($exception instanceof AuthenticationException) {

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthenticated.',
                    ], 401);
                }

                return redirect(url('login'));
            }

            return parent::render($request, $exception);
        }
}
