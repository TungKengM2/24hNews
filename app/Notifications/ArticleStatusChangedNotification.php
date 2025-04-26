<?php 

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ArticleStatusChangedNotification extends Notification
{
    use Queueable;

    protected $article;
    protected $detectedWord;
    protected $adminReason;

    public function __construct($article, $detectedWord, $adminReason)
    {
        $this->article      = $article;
        $this->detectedWord = $detectedWord;
        $this->adminReason  = $adminReason;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message'    => "Bài viết '{$this->article->title}' đã bị chúng tôi xử lý vì báo cáo người dùng: '{$this->detectedWord}' Chúng tôi quyết định giải quyết vì: '{$this->adminReason}'",
            'article_id' => $this->article->id,
            'link'       => route('author.articles.index', $this->article->id),
        ];
    }
}

