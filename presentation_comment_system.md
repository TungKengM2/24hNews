# Quy Trình Hoạt Động Bình Luận Của User
## Dự án 24hNews

---

## 1. Tổng Quan Về Tính Năng

- Hệ thống cho phép người dùng bình luận trên các bài viết
- Hỗ trợ bình luận đa cấp (bình luận gốc và trả lời bình luận)
- Người dùng có thể thích (like) bình luận
- Hệ thống kiểm duyệt tự động nội dung bình luận bằng AI
- Người dùng có thể báo cáo bình luận không phù hợp
- Người dùng có thể xem lịch sử bình luận của mình

---

## 2. Cấu Trúc Cơ Sở Dữ Liệu

### Bảng `comments`
```php
Schema::create('comments', function (Blueprint $table) {
    $table->id('comment_id');
    $table->foreignId('article_id')->constrained('articles', 'article_id');
    $table->foreignId('user_id')->constrained('users', 'user_id');
    $table->text('content');
    $table->integer('likes')->default(0);
    $table->integer('dislikes')->default(0);
    $table->enum('status', ['draft', 'approved', 'rejected'])->default('draft');
    $table->foreignId('parent_id')->nullable()->constrained('comments', 'comment_id');
    $table->integer('depth')->default(0);
    $table->timestamps();
});
```

### Bảng `comment_likes`
```php
Schema::create('comment_likes', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('comment_id');
    $table->unsignedBigInteger('user_id');
    $table->timestamps();

    $table->unique(['comment_id', 'user_id']); // Không cho like 2 lần
    $table->foreign('comment_id')->references('comment_id')->on('comments')->onDelete('cascade');
});
```

### Bảng `comment_reactions`
```php
Schema::create('comment_reactions', function (Blueprint $table) {
    $table->id('reaction_id');
    $table->foreignId('comment_id')->constrained('comments', 'comment_id');
    $table->foreignId('user_id')->constrained('users', 'user_id');
    $table->boolean('is_like')->default(true);
    $table->timestamp('reacted_at')->useCurrent();
});
```

---

## 3. Quy Trình Gửi Bình Luận Gốc

### Khi người dùng gửi bình luận:
1. Hệ thống kiểm tra xem người dùng đã đăng nhập chưa
   ```php
   $user = auth()->user();
   if (!$user) {
       return response()->json([
           'success' => false,
           'message' => 'Người dùng chưa đăng nhập!'
       ], 401);
   }
   ```

2. Kiểm tra xem người dùng có bị cấm bình luận không
   ```php
   if ($user->banned_until && now()->lessThan($user->banned_until)) {
       return response()->json([
           'success' => false,
           'message' => 'Bạn đã bị tạm khóa bình luận đến ' . $user->banned_until->format('H:i d/m/Y')
       ], 403);
   }
   ```

3. Kiểm duyệt nội dung bình luận bằng AI (Gemini API)
   ```php
   $content = $request->content;
   if (!$moderationService->checkComment($content)) {
       return response()->json([
           'success' => false,
           'message' => 'Bình luận không được chấp nhận vì chứa từ ngữ không phù hợp.'
       ], 403);
   }
   ```

4. Lưu bình luận vào cơ sở dữ liệu
   ```php
   $comment = new Comment([
       'article_id' => $request->article_id,
       'user_id'    => $user->user_id,
       'content'    => nl2br(e($content)),
       'parent_id'  => $request->parent_id,
       'status'     => 'approved',
       'depth'      => 0,
   ]);
   $comment->save();
   ```

5. Trả về thông báo thành công
   ```php
   return response()->json([
       'success' => true,
       'message' => 'Bình luận của bạn đã được đăng thành công!'
   ]);
   ```

---

## 4. Quy Trình Trả Lời Bình Luận

### Khi người dùng trả lời bình luận:
1. Kiểm tra đăng nhập và quyền bình luận (tương tự bình luận gốc)

2. Tính toán độ sâu của bình luận trả lời (tối đa là 2)
   ```php
   $parentComment = Comment::find($parentId);
   $depth = $parentComment ? min($parentComment->depth + 1, 2) : 0;
   ```

3. Kiểm duyệt nội dung bình luận trả lời
   ```php
   if (!$moderationService->checkComment($content, null, $userId, $articleId)) {
       Log::warning("🚫 Bình luận trả lời bị từ chối: " . $content);

       return response()->json([
           'success' => false,
           'message' => 'Bình luận không được chấp nhận vì chứa từ ngữ không phù hợp.',
       ], 403);
   }
   ```

4. Lưu bình luận trả lời vào cơ sở dữ liệu
   ```php
   Comment::create([
       'article_id' => $articleId,
       'user_id'    => $userId,
       'content'    => nl2br(e($content)),
       'parent_id'  => $parentId,
       'depth'      => $depth,
       'status'     => 'approved',
   ]);
   ```

5. Trả về thông báo thành công
   ```php
   return response()->json([
       'success' => true,
       'message' => 'Bạn đã trả lời bình luận thành công!',
   ]);
   ```

---

## 5. Quy Trình Thích Bình Luận

### Khi người dùng thích bình luận:
1. Xử lý sự kiện click nút thích bằng JavaScript
   ```javascript
   likeButtons.forEach(button => {
       button.addEventListener('click', function() {
           button.disabled = true;

           const commentId = button.getAttribute('data-comment-id');
           const url = `/comments/${commentId}/like`;
           const csrfToken = document.querySelector('meta[name="csrf-token"]')
               .getAttribute('content');

           fetch(url, {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': csrfToken,
                       'Accept': 'application/json'
                   },
                   body: JSON.stringify({})
               })
               .then(response => response.json())
               .then(data => {
                   if (data.message === 'Success') {
                       const likeText = button.querySelector('.like-text');
                       const likeCountElem = document.getElementById(`like-count-${commentId}`);

                       if (data.liked) {
                           likeText.classList.add('text-primary');
                           likeCountElem.classList.add('liked');
                       } else {
                           likeText.classList.remove('text-primary');
                           likeCountElem.classList.remove('liked');
                       }

                       if (data.likes > 0) {
                           likeCountElem.innerHTML = `<i class="fas fa-thumbs-up"></i> ${data.likes}`;
                       } else {
                           likeCountElem.innerHTML = '';
                       }
                   }
                   button.disabled = false;
               })
               .catch(error => {
                   console.error('Error:', error);
                   button.disabled = false;
               });
       });
   });
   ```

2. Xử lý yêu cầu thích bình luận trên server
   ```php
   // Kiểm tra xem người dùng đã thích bình luận này chưa
   $alreadyLiked = DB::table('comment_likes')
       ->where('comment_id', $comment->comment_id)
       ->where('user_id', $userId)
       ->exists();

   if ($alreadyLiked) {
       // Bỏ like: đảm bảo lượt like không âm
       if ($comment->likes > 0) {
           $comment->decrement('likes');
       }
       DB::table('comment_likes')
           ->where('comment_id', $comment->comment_id)
           ->where('user_id', $userId)
           ->delete();
       $liked = false;
   } else {
       // Thêm like
       DB::table('comment_likes')->insert([
           'comment_id' => $comment->comment_id,
           'user_id' => $userId,
           'created_at' => now(),
           'updated_at' => now(),
       ]);

       $comment->increment('likes');
       $liked = true;
   }

   return response()->json([
       'message' => 'Success',
       'likes' => $comment->likes,
       'liked' => $liked,
   ]);
   ```

---

## 6. Quy Trình Báo Cáo Bình Luận

### Khi người dùng báo cáo bình luận không phù hợp:
1. Xử lý sự kiện báo cáo bằng JavaScript
   ```javascript
   // Gửi request đến route: /articles/{article_id}/comments/{comment_id}/report
   fetch(`/articles/${articleId}/comments/${commentId}/report`, {
           method: "POST",
           headers: {
               "Content-Type": "application/json",
               "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                   .getAttribute("content")
           },
           body: JSON.stringify({
               reason: reason
           })
       })
       .then(response => response.json())
       .then(data => {
           if (data.success) {
               alert("Repost thành công!");
               location.reload();
           } else {
               alert("Repost thất bại: " + data.message);
           }
       })
       .catch(error => {
           console.error("Lỗi fetch:", error);
           alert("Có lỗi xảy ra khi repost!");
       });
   ```

2. Xử lý yêu cầu báo cáo trên server
   ```php
   // Validate dữ liệu: chỉ cần kiểm tra 'reason' nếu có (article_id và comment_id lấy từ route)
   $request->validate([
       'reason' => 'nullable|string'
   ]);

   // Lưu báo cáo vào cơ sở dữ liệu
   // Thông báo cho quản trị viên hoặc người kiểm duyệt
   // Trả về thông báo thành công cho người dùng
   ```

---

## 7. Hiển Thị Bình Luận Trong Bài Viết

### Quy trình lấy và hiển thị bình luận:
1. Lấy danh sách bình luận gốc
   ```php
   $comments = Comment::where('article_id', $article->article_id)
       ->where('status', 'approved')
       ->whereNull('parent_id')
       ->with([
           'user:user_id,username,image',
           'reactions',
       ])
       ->withCount([
           'reactions as like_count' => fn($query) => $query->where('is_like', true),
           'reactions as dislike_count' => fn($query) => $query->where('is_like', false),
       ])
       ->orderBy('created_at', 'desc')
       ->paginate(4);
   ```

2. Hiển thị bình luận gốc và các trả lời
   ```html
   @foreach ($comments as $comment)
       <div class="comment-item">
           <!-- Hiển thị thông tin người bình luận -->
           <div class="user-info">
               <img src="{{ asset('storage/' . $comment->user->image) }}" alt="{{ $comment->user->username }}">
               <span>{{ $comment->user->username }}</span>
               <div class="comment-time">
                   <?= time_ago($comment->created_at) ?>
               </div>
           </div>
           
           <!-- Hiển thị nội dung bình luận -->
           <div class="comment-content">
               {!! $comment->content !!}
           </div>
           
           <!-- Hiển thị số lượt thích -->
           <span id="like-count-{{ $comment->comment_id }}"
               class="like-count @if ($comment->likesUsers->contains(auth()->id())) liked @endif">
               @if ($comment->likes > 0)
                   <i class="fas fa-thumbs-up"></i> {{ $comment->likes }}
               @endif
           </span>
           
           <!-- Hiển thị các trả lời -->
           <div class="replies mt-3" data-reply-count="<?= count($comment->replies) ?>">
               <?php foreach ($comment->replies as $reply): ?>
                   <!-- Hiển thị thông tin trả lời -->
               <?php endforeach; ?>
           </div>
       </div>
   @endforeach
   ```

3. Hiển thị form bình luận
   ```html
   <form class="comment-form" method="POST" action="{{ route('articles.comment', ['article_id' => $article->article_id]) }}">
       @csrf
       <textarea name="content" placeholder="Viết bình luận của bạn"></textarea>
       <input type="hidden" name="article_id" value="{{ $article->article_id }}">
       <button type="submit">Gửi bình luận</button>
   </form>
   ```

---

## 8. Kiểm Duyệt Bình Luận

### Quy trình kiểm duyệt tự động bình luận:
1. Sử dụng Gemini API để kiểm tra nội dung bình luận
   ```php
   public function checkComment(string $text, int $commentId = null, int $userId = null, int $articleId = null): bool
   {
       try {
           $response = $this->client->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key={$this->apiKey}", [
               'json' => [
                   'contents' => [[
                       'parts' => [[
                           'text' => "Hãy phân tích câu sau và trả về JSON với định dạng {\"toxic\": true/false}.
                           Nếu bình luận có nội dung xúc phạm, thô tục, hãy đặt \"toxic\": true. Nếu không, đặt \"toxic\": false.
                           Bình luận: \"{$text}\""
                       ]]
                   ]],
                   'generationConfig' => [
                       'temperature' => 0,
                       'response_mime_type' => 'application/json'
                   ]
               ],
               'timeout' => 8,
           ]);

           $responseData = json_decode($response->getBody(), true);
           $aiResponse = json_decode($responseData['candidates'][0]['content']['parts'][0]['text'], true);
           $isToxic = $aiResponse['toxic'];

           return !$isToxic; // Nếu toxic = true, chặn bình luận
       } catch (Exception $e) {
           Log::error("Lỗi kiểm duyệt bình luận: " . $e->getMessage());
           return false; // Mặc định chặn nếu có lỗi
       }
   }
   ```

2. Xử lý kết quả kiểm duyệt
   - Nếu bình luận không phù hợp: Từ chối và thông báo cho người dùng
   - Nếu bình luận phù hợp: Cho phép đăng và hiển thị

---

## 9. Hiển Thị Lịch Sử Bình Luận Của Người Dùng

### Quy trình hiển thị lịch sử bình luận:
1. Controller xử lý:
   ```php
   public function getUserComments($userId)
   {
       $user = User::find($userId);

       if (!$user) {
           return response()->json(['message' => 'User not found'], 404);
       }

       // Lấy bình luận của user có kèm bài viết
       $comments = Comment::where('user_id', $userId)
           ->whereNotNull('article_id') // Đảm bảo có bài viết
           ->with('article') // Load bài viết liên quan
           ->orderBy('created_at', 'desc')
           ->paginate(10);
           
       return view('website.profiles.users.comments', compact('user', 'comments'));
   }
   ```

2. View hiển thị:
   ```html
   <table class="table table-bordered mb-0" style="width:100%">
       <thead>
           <tr>
               <th>STT</th>
               <th>Bài viết</th>
               <th>Nội dung</th>
               <th>Thời Gian</th>
               <th>Chi Tiết</th>
           </tr>
       </thead>
       <tbody>
           @foreach ($comments as $index => $comment)
               <tr>
                   <td>{{ $loop->iteration + ($comments->currentPage() - 1) * $comments->perPage() }}</td>
                   <td>
                       @if ($comment->article)
                           {{ $comment->article->title }}
                       @else
                           <span class="text-danger">Bài viết không tồn tại</span>
                       @endif
                   </td>
                   <td>{!! Str::limit(strip_tags($comment->content), 100, '...') !!}</td>
                   <td>{{ $comment->created_at->diffForHumans() }}</td>
                   <td>
                       <a href="{{ route('article.detail', ['slug' => $comment->article->slug]) }}" class="btn btn-primary btn-sm">
                           <i class="fas fa-eye"></i>
                       </a>
                   </td>
               </tr>
           @endforeach
       </tbody>
   </table>
   ```

---

## 10. Xử Lý Vi Phạm Và Cấm Bình Luận

### Quy trình xử lý vi phạm:
1. Khi người dùng vi phạm quy định bình luận:
   ```php
   // Tăng số lần vi phạm của người dùng
   $user = User::find($comment->user_id);
   
   if ($user) {
       $daysSinceLast = $user->last_violation_at ? now()->diffInDays($user->last_violation_at) : 0;
       $realViolation = max(0, $user->violation_count - $daysSinceLast);
       $realViolation += 1;

       $user->violation_count = $realViolation;
       $user->last_violation_at = now();

       // Áp dụng hình phạt tùy theo số lần vi phạm
       if ($realViolation >= 5) {
           $user->banned_until = now()->addDays(3); // Cấm 3 ngày
       } elseif ($realViolation >= 3) {
           $user->banned_until = now()->addHours(24); // Cấm 24 giờ
       }
       $user->save();
   }
   ```

2. Thông báo cho người dùng về vi phạm:
   ```php
   $usersToNotify = User::whereIn('violation_count', [3, 5])->get();
   foreach ($usersToNotify as $user) {
       $user->notify(new UserViolationAlert($user));
   }
   ```

---

## 11. Kết Luận

- Tính năng bình luận là một phần quan trọng của hệ thống 24hNews
- Được thiết kế để hỗ trợ bình luận đa cấp và tương tác giữa người dùng
- Tích hợp hệ thống kiểm duyệt tự động để đảm bảo nội dung phù hợp
- Cung cấp trải nghiệm người dùng tốt với AJAX và thông báo trực quan
- Cho phép người dùng quản lý và theo dõi lịch sử bình luận của mình
- Hệ thống xử lý vi phạm giúp duy trì môi trường bình luận lành mạnh
