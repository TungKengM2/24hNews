<?php

namespace App\Notifications;

use App\Models\ArticleEditRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewArticleEditRequest extends Notification implements ShouldQueue
{
    use Queueable;

    protected $articleEditRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ArticleEditRequest $articleEditRequest)
    {
        $this->articleEditRequest = $articleEditRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        $article = $this->articleEditRequest->article;
        $author = $this->articleEditRequest->author;

        return [
            'id' => $this->articleEditRequest->id,
            'article_id' => $article->article_id,
            'article_title' => $article->title,
            'author_id' => $author->user_id,
            'author_name' => $author->name,
            'reason' => $this->articleEditRequest->reason,
            'message' => "Tác giả {$author->name} đã yêu cầu chỉnh sửa bài viết: {$article->title}",
            'type' => 'new_edit_request',
            'link' => route('admin.article-edit-requests.index')
        ];
    }
}
