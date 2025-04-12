<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;
use App\Models\User;

class NewArticleFromFollowedAuthor extends Notification implements ShouldQueue
{
    use Queueable;

    public $article;
    public $author;

    public function __construct(Article $article, User $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    public function via($notifiable)
    {
        return ['database']; // Thêm 'mail' nếu muốn gửi email
    }

    public function toDatabase($notifiable)
    {
        // Xác định tên hiển thị theo thứ tự ưu tiên
        $authorName = $this->author->fullname
                   ?? $this->author->username; // Không có trường hợp ẩn danh theo yêu cầu

        return [
            'title'         => 'Bài viết mới từ tác giả bạn theo dõi',
            'type'          => 'new_article',
            'message'      => "{$authorName} vừa đăng bài viết mới: {$this->article->title}",
            'article_id'    => $this->article->id,
            'article_slug' => $this->article->slug, // Required for URL construction
            'author_id'     => $this->author->user_id, // Sửa thành user_id để khớp DB
            'author_name'   => $authorName,
            'author_avatar' => $this->author->image ?? asset('images/default-avatar.png'), // Sử dụng trường 'image' từ DB
            'published_at'  => now()->toDateTimeString(),
            'thumbnail_url' => $this->article->thumbnail_url ?? asset('images/default-thumbnail.jpg'),
            'url'          => route('articles.show', $this->article->slug)
        ];
    }

    // Bổ sung nếu muốn gửi email
    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject("Bài viết mới từ {$this->author->name}")
            ->line("{$this->author->name} vừa đăng bài: {$this->article->title}")
            ->action('Xem ngay', url("/articles/{$this->article->slug}"));
    }
}
