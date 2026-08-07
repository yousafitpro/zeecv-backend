<?php

namespace App\Listeners;

use App\Events\userLogged;
class userLoggedListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\userLogged  $event
     * @return void
     */
    public function handle(userLogged $event)
    {

      //  send_instant_message(auth()->user()->email,'New login to '.config('app.name2'),"Hi ".auth()->user()->name,"We noticed a login to your account ".auth()->user()->email." from a new device. If this wasn't you, please contact us at support@zpayd.com");



    }
}
