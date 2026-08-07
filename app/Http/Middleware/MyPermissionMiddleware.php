<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MyPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$permissions)
    {

        $or_permissions=explode('|',$permissions);
        $and_permissions=explode('&',$permissions);
        $operator='none';
        $md_permissions=[];
        if(count($and_permissions)>1)
        {
            $operator='and';
            $md_permissions=$and_permissions;
        }
        elseif(count($or_permissions)>1)
        {
            $operator='or';
            $md_permissions=$or_permissions;
        }else
        {
            $md_permissions=[$permissions];
            $operator='and';
        }

        if(!my_has_permission($md_permissions,$operator))
        {
            if(request_type()=='api')
            {
              return response()->json(["code"=>"401","message"=>"401 | Unauthorized"],401);
            }else
            {
                abort(401);
            }

        }
        return $next($request);
    }
}
