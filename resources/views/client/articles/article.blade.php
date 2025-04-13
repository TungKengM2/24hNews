@extends('master')

@section('tieudetrang')
    Article
@endsection

@section('content')

<div class="container mx-auto mt-4 px-4">
    <div class="flex flex-wrap -mx-4">
        <!-- Bài viết chính -->
        <div class="w-full lg:w-2/3 px-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-4">
                <div class="container mx-auto mt-4 px-4 flex justify-between items-center text-gray-600">
                    <div>
                        <a href="#" class="text-gray-500 hover:underline">Danh Mục</a> > <span class="text-blue-600">Thể Thao</span>
                    </div>
                    <div>
                        <img src='https://cdnphoto.dantri.com.vn/mnRLNiGJ-ET_1N2OBqh376CTxSM=/zoom/120_120/2022/04/16/anh-but-danh-1-crop-1650078064298.jpeg' class='w-8 h-8 rounded-full inline-block mr-2' alt='Avatar'> <strong>Phạm Hoàng</strong> • Thứ bảy, 22/02/2025 - 10:00
                    </div>
                </div>
                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="w-full h-[450px] p-4 object-cover" alt="{{ $article->title }}">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-2">{{ $article->title }}</h2>

                    <div class="mt-3 prose max-w-full">{!! $article->content !!}</div>


                    <div class="container mx-auto mt-4 px-4 text-gray-600 flex items-center space-x-2">
                        <p><i class="fas fa-eye"></i> Lượt xem: {{ $article->views }} | <i class="fas fa-user"></i> Tác giả: luanaz123</p>
                        <div class="flex items-center bg-gray-100 p-2 rounded-full cursor-pointer" id="likeContainer">
                            <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                <i class="fas fa-thumbs-up" id="likeIcon"></i>
                            </div>
                            (<span class="ml-2 text-gray-700" id="likeText">Thích</span>
                            <span class="ml-2 text-gray-700" id="likeCount">{{ $article->likes ?? 0 }}</span>)
                        </div>
                        <div class="flex items-center bg-gray-100 p-2 rounded-full cursor-pointer ml-4" id="saveContainer">
                            <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                <i class="fas fa-bookmark" id="saveIcon"></i>
                            </div>
                            <span class="ml-2 text-gray-700" id="saveText">Lưu</span>
                        </div>
                        <div class="flex items-center bg-gray-100 p-2 rounded-full cursor-pointer ml-4" id="shareContainer">
                            <div class="bg-purple-500 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                <i class="fas fa-share-alt"></i>
                            </div>
                        </div>

                    </div>
                    <div class="max-w-4xl mx-auto mt-2">
                        <span class="font-bold text-gray-800">#Hashtag:</span>
                        <div class="inline-flex space-x-2 ml-2">
                            <span class="px-3 py-1 bg-blue-200 text-red-400 rounded-lg text-sm">Indonesia</span>
                            <span class="px-3 py-1 bg-blue-200 text-red-400 rounded-lg text-sm">hashtag</span>
                            <span class="px-3 py-1 bg-blue-200 text-red-400 rounded-lg text-sm">cư dân mạng</span>
                            <span class="px-3 py-1 bg-blue-200 text-red-400 rounded-lg text-sm">đám bom</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quảng cáo & Bài viết liên quan -->
        <div class="w-full lg:w-1/3 px-4">
            <div class="mb-4 text-center">
                <a href="https://shop.mixigaming.com/">
                    <img src="https://th.bing.com/th/id/R.638f0378be501384598c313b9254a074?rik=4q27eEjjmHzVeA&riu=http%3a%2f%2fintemnhandecal.net%2fwp-content%2fuploads%2f2019%2f07%2fcac-mau-in-poster-quang-cao.jpg&ehk=xEa19xG1SoAREwQ5DcFB6e7uJVPbPgG6cHVQGMLTuvA%3d&risl=&pid=ImgRaw&r=0" class="w-full rounded-lg" alt="Quảng cáo">
                </a>
            </div>

            <!-- Bài viết liên quan -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white p-3 font-semibold">Bài viết liên quan</div>
                <ul class="divide-y divide-gray-200">
                    @foreach ($relatedArticles as $related)
                        <li class="flex items-center p-3">
                            <img src="{{ asset('storage/' . $related->thumbnail_url) }}" class="w-48 h-32 object-cover rounded mr-3" alt="{{ $related->title }}">
                            <a href="{{ route('client.articles.article', $related->article_id) }}" class="text-gray-800 hover:text-blue-600">{{ $related->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Button to scroll to top -->
<button id="scrollToTopButton" class="scroll-to-top">
    ↑
</button>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let likeContainer = document.getElementById("likeContainer");
        let likeCount = document.getElementById("likeCount");
        let likeText = document.getElementById("likeText");
        let liked = false;

        likeContainer.addEventListener("click", function() {
            if (!liked) {
                liked = true;
                likeCount.textContent = parseInt(likeCount.textContent) + 1;
                likeText.textContent = "Đã Thích";
            }
        });

        let saveContainer = document.getElementById("saveContainer");
        let saveText = document.getElementById("saveText");
        let saved = false;

        saveContainer.addEventListener("click", function() {
            if (!saved) {
                saved = true;
                saveText.textContent = "Đã Lưu";
            }
        });

        let scrollToTopButton = document.getElementById("scrollToTopButton");

        window.addEventListener("scroll", function() {
            if (window.scrollY > 200) {
                scrollToTopButton.style.display = "flex";
            } else {
                scrollToTopButton.style.display = "none";
            }
        });

        scrollToTopButton.addEventListener("click", function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>

@endsection
