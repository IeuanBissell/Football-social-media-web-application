<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, Comment $comment)
    {
        $this->post = $post;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // Use 'database' for in-app notifications, 'mail' for email
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('fixtures.show', $this->post->fixture_id) . '#comment-' . $this->comment->id;

        return (new MailMessage)
            ->subject('New Comment on Your Post')
            ->line($this->comment->user->name . ' commented on your post.')
            ->line('Comment: "' . \Str::limit($this->comment->content, 100) . '"')
            ->action('View Comment', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
            'user_id' => $this->comment->user_id,
            'user_name' => $this->comment->user->name,
            'comment' => \Str::limit($this->comment->content, 50),
            'fixture_id' => $this->post->fixture_id,
        ];
    }
}
