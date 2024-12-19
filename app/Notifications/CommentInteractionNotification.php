<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentInteractionNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $interactor;

    public function __construct($comment, $interactor)
    {
        $this->comment = $comment;
        $this->interactor = $interactor;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Interaction on Your Comment')
            ->line("{$this->interactor->name} replied to your comment.")
            ->action('View Comment', url('/comments/' . $this->comment->id));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->interactor->name} replied to your comment.",
            'comment_id' => $this->comment->id,
        ];
    }
}
