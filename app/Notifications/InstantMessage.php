<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstantMessage extends Notification
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
        $mail=new MailMessage();

                   $mail->subject($this->data['subject'])
                    ->greeting($this->data['greeting'])
                    ->line($this->data['message'])
                    ->line('Thank you for using our application!');
        if (count($this->data['files'])>0)
        {

            foreach ($this->data['files'] as $file)
            {
               // $file=str_replace("https","http",$file);

                $mail->attach($file);
            }
        }
        if (isset($this->data['data_files']) && count($this->data['data_files'])>0)
        {

            foreach ($this->data['data_files'] as $file)
            {
                $mail->attachData($file['data'],$file['name']);
            }
        }
                   return $mail;
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
