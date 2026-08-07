<?php

namespace App\Notifications\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendPhoneVerificationCode extends Notification
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
            $msg="Phone Verification code is ".$this->data['code'];
            \App\Http\Controllers\TwilioController::sendMessage($this->data['phone'],$msg,[]);
        }catch (\Exception $e){

        }
        return (new MailMessage)
            ->subject("Phone Verification Code")
            ->greeting('Hello! '.$this->data['user']->name)
            ->line('Phone Verification Process is started with '.$this->data['phone'].' take security actions if this is not you')
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
