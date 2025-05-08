<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewPostNotification extends Notification
{
    use Queueable;

    /**
     * The post instance.
     *
     * @var \App\Models\Post
     */
    protected $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Default to database, add mail if needed
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Post Published: ' . $this->post->title)
            ->line('A new post has been published.')
            ->action('View Post', url('/fixtures/' . $this->post->fixture_id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        try {
            return [
                'post_id' => $this->post->id,
                'title' => $this->post->title ?? 'New Post',
                'author' => $this->post->user->name ?? 'A user',
                'message' => 'A new post "' . ($this->post->title ?? 'New Post') . '" was published',
                'fixture_id' => $this->post->fixture_id ?? null
            ];
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating NewPostNotification data', [
                'error' => $e->getMessage(),
                'post_id' => $this->post->id ?? 'unknown'
            ]);

            // Return basic data to prevent complete failure
            return [
                'message' => 'A new post was published',
                'type' => 'new_post'
            ];
        }
    }
}
