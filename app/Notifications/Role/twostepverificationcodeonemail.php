<?php

namespace App\Notifications\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class twostepverificationcodeonemail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {

        $this->data=$data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        try {
//            $msg="Your verification code for login sent to registered email ";
//            \App\Http\Controllers\TwilioController::sendMessage(auth()->user()->phone,$msg,$this->data);
        }catch (\Exception $e){

        }
        return (new MailMessage)
            ->subject("Verification Code")
            ->greeting('Hello! '.$this->data['user']->name)
            ->line(isset($this->data['message'])?$this->data['message']:"Your Verification Code For Login is ".$this->data['code'])
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
