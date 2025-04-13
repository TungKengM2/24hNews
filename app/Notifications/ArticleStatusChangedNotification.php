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

    public function __construct($article, $detectedWord)
    {
        $this->article = $article;
        $this->detectedWord = $detectedWord;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Bài viết '{$this->article->title}' đã bị report vì lý do: '{$this->detectedWord}'",
            'article_id' => $this->article->id,
            'link' => route('author.articles.index', $this->article->id)
        ];
    }
}
