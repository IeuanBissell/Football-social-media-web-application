<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostInteractionNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $interactor;

    public function __construct($post, $interactor)
    {
        $this->post = $post;
        $this->interactor = $interactor;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Interaction on Your Post')
            ->line("{$this->interactor->name} interacted with your post.")
            ->action('View Post', url('/posts/' . $this->post->id));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->interactor->name} interacted with your post.",
            'post_id' => $this->post->id,
        ];
    }
}
