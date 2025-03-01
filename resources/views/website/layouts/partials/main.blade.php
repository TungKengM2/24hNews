<main>
    <!-- Hiển thị 3 bài viết mới nhất theo thời gian -->
    <span class="max-w-7xl mx-auto p-4 grid grid-cols-12 gap-4 mb-20 min-h-[75vh]">
        <div class="col-span-12 flex flex-col space-y-4">
            <h1 class="text-3xl font-bold">Bài viết mới nhất</h1>
            @foreach ($latestArticles as $article)
                <article class="flex items-center bg-white p-4 shadow rounded-lg">
                    <a href="{{ route('client.articles.article', ['article_id' => $article->article_id]) }}"
                        class="flex flex-1 pr-4 no-underline hover:text-blue-500">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">{{ $article->created_at->diffForHumans() }}</p>
                            <h2 class="text-base font-bold mb-1">{{ implode(' ', array_slice(explode(' ', strip_tags($article->title)), 0, 40)) }}</h2>
                            <p class="text-sm text-gray-600">{{ $article->preview_content }}</p>
                        </div>
                    </a>
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh bài viết"
                        class="w-48 h-32 object-cover ">
                </article>
            @endforeach
        </div>
<<<<<<< HEAD
    </span>
=======
    </div>
</section>
<!-- ====== end breaking news ====== -->
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459

    {{-- Hiển thị 7 bài viết tiêu biểu theo danh mục   --}}

    <span class="max-w-7xl mx-auto mt-[-6rem] p-4 grid grid-cols-12 gap-4  min-h-[75vh] ">
        <div class="col-span-12 flex flex-col space-y-4">
            <h1 class="text-3xl font-bold">Bài viết tiêu biểu</h1>
        </div>

        <div class="col-span-3 flex flex-col justify-between h-[32rem]  ">

            <!-- Cột trái -->
            @foreach ($categoryArticles->slice(0, 2) as $article)
                <article class="bg-white p-4      h-1/2 w-full mb-0">
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh bài viết"
                        class="w-full h-3/4 object-cover  mb-2">
                    <div class="p-2 w-full h-1/4">
                        <h2 class="text-sm font-medium mb-1">{{ implode(' ', array_slice(explode(' ', strip_tags($article->title)), 0, 20)) }}</h2>
                        <p class="text-sm font-medium text-gray-600">{{ $article->preview_content }}</p>
                    </div>


                </article>
            @endforeach
        </div>
        <div class="col-span-6 grid grid-rows-1 gap-4 h-[32rem]">
            <!-- Cột giữa -->


            @if ($categoryArticles->count() > 2)
                <article class="bg-white p-4      h-full flex flex-col">
                    <img src="{{ asset('storage/' . $categoryArticles[2]->thumbnail_url) }}" alt="Hình ảnh bài viết"
                        class="w-full h-3/4 object-cover  mb-2">
                    <div class="p-4 flex flex-col h-1/4 justify-center">
                        <h2 class="text-lg font-medium mb-2">{{ implode(' ', array_slice(explode(' ', strip_tags($article->title)), 0, 40)) }}</h2>
                        <p class="text-sm text-gray-600">{{ $categoryArticles[2]->preview_content }}</p>
                    </div>
                </article>
            @endif
        </div>
        <div class="col-span-3 flex flex-col justify-between h-[32rem]">
            <!-- Cột phải -->
            @foreach ($categoryArticles->slice(3, 7) as $article)
                <article class="bg-white p-4  h-1/4 w-full mb-0 flex">
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh bài viết"
                        class="w-1/2 h-full object-cover  mb-2">
                    <div class="p-2 w-1/2 h-full flex flex-col justify-center">
                        <h2 class="text-xs font-medium   mb-1">{{ implode(' ', array_slice(explode(' ', strip_tags($article->title)), 0, 16)) }}</h2>
                        <p class="text-xs font-medium  text-gray-600">{{ $article->preview_content }}</p>
                    </div>
                </article>
            @endforeach
        </div>

    </span>
    {{-- Danh Mục 1 (Phải có ít nhất 4 bài viết) --}}
    <div class="max-w-7xl mx-auto p-4 grid grid-cols-4  gap-4 mb-4  min-h-[38vh]">
        <h1 class="text-3xl font-bold col-span-4">Danh Mục 1    </h1>

        <!-- Bài viết 1 -->
        <div class="mx-auto">
            <img src="http://127.0.0.1:8000/storage/thumbnails/nsem7ANx55nOMKO0ieXYF3pA9VEbQ1xBmOHaeEJ6.jpg" alt="News Image" class="w-full h-40 object-cover ">
            <h3 class="text-sm font-bold">Cảnh báo thủ đoạn cắt ghép hình ảnh, tạo nội dung nhạy cảm để tống tiền</h3>
        </div>
        <!-- Bài viết 2 -->
        <div class="mx-auto">
            <img src="http://127.0.0.1:8000/storage/thumbnails/nsem7ANx55nOMKO0ieXYF3pA9VEbQ1xBmOHaeEJ6.jpg" alt="News Image" class="w-full h-40 object-cover ">
            <h3 class="text-sm font-bold">Người phụ nữ mua 5.000 bông thuốc được cắm khắp phòng, dân mạng mê mẩn</h3>
        </div>
        <!-- Bài viết 3 -->
        <div class="mx-auto">
            <img src="http://127.0.0.1:8000/storage/thumbnails/nsem7ANx55nOMKO0ieXYF3pA9VEbQ1xBmOHaeEJ6.jpg" alt="News Image" class="w-full h-40 object-cover ">
            <h3 class="text-sm font-bold">Bộ Y tế yêu cầu Bệnh viện Phụ sản T.Ư báo cáo sự cố y khoa</h3>
        </div>
        <!-- Bài viết 4 -->
        <div class="mx-auto">
            <img src="http://127.0.0.1:8000/storage/thumbnails/nsem7ANx55nOMKO0ieXYF3pA9VEbQ1xBmOHaeEJ6.jpg" alt="News Image" class="w-full h-40 object-cover ">
            <h3 class="text-sm font-bold">Siết dạy thêm, học thêm: 'Xóa sổ' những bất hợp lý trong giáo dục</h3>
        </div>
    </div>
    {{-- Danh Mục 2 (Phải có ít nhất 9 bài viết) --}}
    <span class="max-w-6xl mx-auto grid grid-cols-12 gap-4 ">

        <div class="col-span-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Danh Mục 2</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Space Shuttle" class="w-full h-auto ">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Bức ảnh đầu tiên của máy bay vũ trụ tuyệt mật Mỹ trên quỹ đạo</h2>
                    <p class="text-gray-700 mt-2">Lực lượng Không gian Mỹ hôm 20/2 chia sẻ bức ảnh hiếm hoi về máy bay vũ trụ X-37B trên quỹ đạo, chụp bằng camera tích hợp khi phương tiện đang bay phía trên châu Phi.</p>
                    <p class="text-gray-500 text-sm mt-2">53' trước  |  Vũ trụ</p>
                </div>
            </div>
            <hr class="my-6 border-gray-300">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex mt-8">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Hồ tròn" class="w-1/2 h-auto ">
                    <div class="w-1/2 pl-2">
                        <h3 class="text-sm  text-gray-900">Miệng hố tròn hoàn hảo thách thức mọi lý giải khoa học</h3>
                    </div>
                </div>
                <div class="flex mt-8">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Khoan dầu" class="w-1/2 h-auto ">
                    <div class="w-1/2 pl-2">
                        <h3 class="text-sm  text-gray-900">Trung Quốc hoàn thành khoan giếng thẳng đứng sâu nhất châu Á</h3>
                    </div>
                </div>
                <div class="flex mt-8">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Sa mạc" class="w-1/2 h-auto ">
                    <div class="w-1/2 pl-2">
                        <h3 class="text-sm  text-gray-900">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</h3>
                    </div>
                </div>
                <div class="flex mt-8">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Sa mạc" class="w-1/2 h-auto ">
                    <div class="w-1/2 pl-2">
                        <h3 class="text-sm  text-gray-900">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</h3>
                    </div>
                </div>
                <div class="flex mt-8">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Sa mạc" class="w-1/2 h-auto ">
                    <div class="w-1/2 pl-2">
                        <h3 class="text-sm  text-gray-900">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</h3>
                    </div>
                </div>
                <div class="flex mt-8">
                    <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Sa mạc" class="w-1/2 h-auto ">
                    <div class="w-1/2 pl-2">
                        <h3 class="text-sm  text-gray-900">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-4 flex flex-col gap-4 mt-8">
            <div>
                <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Hành tinh" class="w-full h-3/4 ">
                <h3 class="text-lg  text-gray-900 mt-2">Phát hiện hành tinh mới có thể chứa sự sống</h3>
            </div>
            <div>
                <img src="http://127.0.0.1:8000/storage/thumbnails/sbgkendixuEkULSdAP2dtHn8IQ2w3SltH6yX9KBI.jpg" alt="Năng lượng mặt trời" class="w-full h-3/4 ">
                <h3 class="text-lg  text-gray-900 mt-2">Công nghệ năng lượng mặt trời đột phá mới</h3>
            </div>
        </div>

<<<<<<< HEAD
        <hr class="my-6 border-gray-300 col-span-12">
    </span>
     {{-- Danh Mục 3 (Phải có ít nhất 9 bài viếtviết) --}}
    <span class="max-w-6xl mx-auto grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <h1 class="text-2xl font-bold mb-4">Danh Mục 3</h1>
        </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Miệng hố tròn hoàn hảo thách thức mọi lý giải khoa học</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Trung Quốc hoàn thành khoan giếng thẳng đứng sâu nhất châu Á</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <div class="col-span-4 flex">
             <img src="http://127.0.0.1:8000/storage/thumbnails/ZPoe3VbHUEn7f33ZxJd2SBDl8aoXetVnxubqGRcL.jpg" alt="News Image" class="w-1/3 object-cover">
             <p class="ml-4">Thiết bị thu thập nước trên sa mạc nóng khô nhất thế giới</p>
         </div>
         <hr class="my-6 border-gray-300 col-span-12">
=======
            <div class="col-lg-3">
                <div class="tc-side-widgets">
                    <!-- widget-social -->
                    <div class="tc-widget-social-style1">
                        <p class="color-000 text-uppercase mb-30 ltspc-1 lh-2"> stay connected </p>
                        <div class="content">
                            <a href="home-default.html#" class="social-card">
                                <div class="icon facebook-icon">
                                    <i class="lab la-facebook-f"></i>
                                </div>
                                <h6>1,5M</h6>
                            </a>
                            <a href="home-default.html#" class="social-card">
                                <div class="icon twitter-icon">
                                    <i class="lab la-twitter"></i>
                                </div>
                                <h6>920K</h6>
                            </a>
                            <a href="home-default.html#" class="social-card">
                                <div class="icon insta-icon">
                                    <i class="lab la-instagram"></i>
                                </div>
                                <h6>25,7K</h6>
                            </a>
                            <a href="home-default.html#" class="social-card mb-0">
                                <div class="icon youtube-icon">
                                    <i class="lab la-youtube"></i>
                                </div>
                                <h6>1,5M</h6>
                            </a>
                            <a href="home-default.html#" class="social-card mb-0">
                                <div class="icon spotify-icon">
                                    <i class="lab la-spotify"></i>
                                </div>
                                <h6>1,5M</h6>
                            </a>
                        </div>
                    </div>
                    <!-- widget-podcast -->
                    <div class="tc-widget-podcast">
                        <p class="color-000 text-uppercase mb-30 ltspc-1 lh-2"> new podcasts <i
                                class="la la-angle-right ms-1"></i> </p>
                        <div class="main-card">
                            <div class="img img-cover">
                                <img src="client/img/pdc1.png" alt="">
                            </div>
                            <div class="info pt-10">
                                <small>2 Hours ago</small>
                                <h5>
                                    <a href="home-default.html#" class="title">
                                        Start A New Day with A Smile
                                    </a>
                                </h5>
                            </div>
                            <audio controls class="audio">
                                <source src="client/img/audio1.mp3" type="audio/mpeg">
                            </audio>
                        </div>
                        <div class="podcast-list">
                            <div class="item">
                                <a href="home-default.html#" class="img">
                                    <img src="client/img/pdc1.png" alt="">
                                </a>
                                <div class="info">
                                    <small> 3 Hours ago </small>
                                    <h6 class="title">
                                        <a href="home-default.html#">
                                            Release energy and activity
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <div class="item">
                                <a href="https://www.youtube.com/watch?v=pGbIOC83-So&t=21s"
                                    data-fancybox="video" class="img img-vid">
                                    <img src="client/img/pdc2.png" alt="">
                                    <i class="ion-arrow-right-b play-icon"></i>
                                </a>
                                <div class="info">
                                    <small> 3 Hours ago </small>
                                    <h6 class="title">
                                        <a href="home-default.html#">
                                            Cafe, Chill and focus to study
                                        </a>
                                    </h6>
                                </div>
                            </div>
                            <div class="item mb-0">
                                <a href="home-default.html#" class="img">
                                    <img src="client/img/pdc3.png" alt="">
                                </a>
                                <div class="info">
                                    <small> 3 Hours ago </small>
                                    <h6 class="title">
                                        <a href="home-default.html#">
                                            A long day mood
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- widget-sponsored -->
                    <div class="tc-widget-sponsored-style1">
                        <div class="img img-cover">
                            <img src="client/img/sponsored/1.png" alt="">
                        </div>
                        <div class="info pt-10">
                            <div class="spon-cat"> Sponsored Content </div>
                            <h6 class="title">
                                <a href="home-default.html#">
                                    Dile & Kamine Soap from pure natura 100%
                                </a>
                            </h6>
                            <a href="home-default.html#">
                                <small>dileandkamina.com <i
                                        class="las la-external-link-square-alt ms-2"></i></small>
                            </a>
                        </div>
                    </div>
                    <!-- popular posts -->
                    <div class="tc-widget-popular-style1">
                        <p class="color-000 text-uppercase mb-20 ltspc-1"> popular posts </p>
                        <div class="main-card">
                            <div class="img th-300 img-cover">
                                <img src="client/img/wid_popular/1.png" alt="">
                                <div class="tags">
                                    <a href="home-default.html#">business</a>
                                </div>
                            </div>
                            <div class="content">
                                <h4 class="title">
                                    <a href="page-single-post-creative.html">Big Title for featured post with double</a>
                                </h4>
                                <div class="meta-bot">
                                    <ul class="d-flex">
                                        <li class="date me-4">
                                            <a href="home-default.html#"><i class="la la-calendar me-1"></i> Dec 14, 2022</a>
                                        </li>
                                        <li class="comment">
                                            <a href="home-default.html#"><i class="la la-comment me-1"></i> 55 </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tc-widget-popular-list">
                            <a href="page-single-post-creative.html" class="item">
                                <div class="img img-cover">
                                    <img src="client/img/wid_popular/2.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="title">
                                        Joe Biden did not participate in the war
                                    </h6>
                                </div>
                            </a>
                            <a href="page-single-post-creative.html" class="item">
                                <div class="img img-cover">
                                    <img src="client/img/wid_popular/3.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="title">
                                        Mindset to Succesful, Become Lion King
                                    </h6>
                                </div>
                            </a>
                            <a href="page-single-post-creative.html" class="item">
                                <div class="img img-cover">
                                    <img src="client/img/wid_popular/4.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="title">
                                        Experience ballon balls in Turkey
                                    </h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- widget-adbox -->
                    <div class="tc-widget-adbox-style1">
                        <a href="home-default.html#" class="img">
                            <img src="client/img/banner12.png" alt="" class="">
                        </a>
                    </div>
                    <!-- widget-survey -->
                    <div class="tc-widget-survey-style1">
                        <p class="color-000 text-uppercase mb-20 ltspc-1"> quick survey </p>
                        <div class="ques-title lh-4">
                            How was your experience on Newzin?
                        </div>
                        <div class="ansr-content">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="quesCheck" id="quesCheck1">
                                <label class="form-check-label" for="quesCheck1">
                                    Awesome, I’m satisfied!
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="quesCheck" id="quesCheck2">
                                <label class="form-check-label" for="quesCheck2">
                                    Normal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="quesCheck" id="quesCheck3">
                                <label class="form-check-label" for="quesCheck3">
                                    Bad! Need improve more
                                </label>
                            </div>
                        </div>
                        <div class="btns">
                            <a href="home-default.html#" class="btn active me-2">
                                Submit
                            </a>
                            <a href="home-default.html#" class="btn">
                                Result
                            </a>
                        </div>
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459

                        <small class="pl-num">
                            <span class="color-000">24,562 </span> Peoples joined
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== end must read ====== -->

<!-- ====== start hot videos ====== -->
<section class="tc-hot-videos-style1 pt-30 pb-50 parallaxie">
    <div class="container">
        <div class="content">
            <div class="section-head">
                <p class="text-white text-uppercase ltspc-1"> hot videos LAST WEEK <i
                        class="la la-angle-right ms-1"></i> </p>
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-Popular-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-Popular" type="button" role="tab"
                            aria-controls="pills-Popular" aria-selected="true">
                            Popular
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-Latest-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-Latest" type="button" role="tab" aria-controls="pills-Latest"
                            aria-selected="false">
                            Latest
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-Popular" role="tabpanel"
                    aria-labelledby="pills-Popular-tab">
                    <div class="row">
                        <div class="col-lg-9 border-1 border-end brd-light">
                            <div class="tc-video-slider1">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="slider-content">
                                                <p class="sub-title">featured, video</p>
                                                <h3 class="title">  <a href="page-single-post-features.html"> Amazing View! Catch the sunrise <br> in high
                                                    moutain </a> </h3>
                                                <div class="meta-bot lh-1">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i>
                                                                Dec 24, 2022
                                                            </a>
                                                        </li>
                                                        <li class="comment">
                                                            <i class="las la-chart-line me-2"></i>
                                                            25,6K Views
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="https://youtu.be/pGbIOC83-So?t=21" data-fancybox=""
                                                    class="play-cont">
                                                    <i class="ion-play me-3"></i>
                                                    <span>
                                                        play <br> video
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="tc-side-video-posts">
                                <p class="text-white text-uppercase ltspc-1 mb-40 lh-2 fsz-13px">videos up next
                                </p>
                                <div class="tc-post-grid-default">
                                    <div class="item mb-40">
                                        <div class="img img-cover th-180">
                                            <img src="client/img/videos/1.png" alt="">
                                            <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity
                                                class="video_icon icon-60">
                                                <i class="ion-play"></i>
                                            </a>
                                        </div>
                                        <div class="content pt-20">
                                            <a href="home-default.html#"
                                                class="news-cat text-white fsz-13px text-uppercase mb-1 fw-lighter">travel,
                                                video</a>
                                            <h4 class="title ltspc--1 text-white">
                                                <a href="page-single-post-features.html">Amazing View! Catch the sunrise in high mountain</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="img img-cover th-180">
                                            <img src="client/img/videos/2.png" alt="">
                                            <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity=""
                                                class="video_icon icon-60">
                                                <i class="ion-play"></i>
                                            </a>
                                        </div>
                                        <div class="content pt-20">
                                            <a href="home-default.html#"
                                                class="news-cat text-white fsz-13px text-uppercase mb-1 fw-lighter">culture,
                                                video</a>
                                            <h4 class="title ltspc--1 text-white">
                                                <a href="page-single-post-features.html">Bhutan! The happiest country on the world</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-Latest" role="tabpanel" aria-labelledby="pills-Latest-tab">
                    <div class="row">
                        <div class="col-lg-9 border-1 border-end brd-light">
                            <div class="tc-video-slider1">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="slider-content">
                                                <p class="sub-title">featured, video</p>
                                                <h3 class="title"> <a href="page-single-post-features.html"> Amazing View! Catch the sunrise <br> in high
                                                    moutain </a> </h3>
                                                <div class="meta-bot lh-1">
                                                    <ul class="d-flex">
                                                        <li class="date me-5">
                                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i>
                                                                Dec 24, 2022
                                                            </a>
                                                        </li>
                                                        <li class="comment">
                                                            <i class="las la-chart-line me-2"></i>
                                                            25,6K Views
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="https://youtu.be/pGbIOC83-So?t=21" data-fancybox=""
                                                    class="play-cont">
                                                    <i class="ion-play me-3"></i>
                                                    <span>
                                                        play <br> video
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="tc-side-video-posts">
                                <p class="text-white text-uppercase ltspc-1 mb-40 lh-2 fsz-13px">videos up next
                                </p>
                                <div class="tc-post-grid-default">
                                    <div class="item mb-40">
                                        <div class="img img-cover th-180">
                                            <img src="client/img/videos/1.png" alt="">
                                            <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity=""
                                                class="video_icon icon-60">
                                                <i class="ion-play"></i>
                                            </a>
                                        </div>
                                        <div class="content pt-20">
                                            <a href="home-default.html#"
                                                class="news-cat text-white fsz-13px text-uppercase mb-1 fw-lighter">travel,
                                                video</a>
                                            <h4 class="title ltspc--1 text-white">
                                                <a href="page-single-post-features.html">Amazing View! Catch the sunrise in high mountain</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="img img-cover th-180">
                                            <img src="client/img/videos/2.png" alt="">
                                            <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity=""
                                                class="video_icon icon-60">
                                                <i class="ion-play"></i>
                                            </a>
                                        </div>
                                        <div class="content pt-20">
                                            <a href="home-default.html#"
                                                class="news-cat text-white fsz-13px text-uppercase mb-1 fw-lighter">culture,
                                                video</a>
                                            <h4 class="title ltspc--1 text-white">
                                                <a href="page-single-post-features.html">Bhutan! The happiest country on the world</a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== end hot vedios ====== -->

<!-- ====== start lifestyle ====== -->
<section class="tc-lifestyle pt-50 pb-50">
    <div class="container">
        <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">lifestyle</a> <i class="la la-angle-right ms-1"></i> </p>
        <div class="content">
            <div class="row">
                <div class="col-lg-6 border-end brd-gray border-1">
                    <div class="tc-post-grid-default">
                        <div class="item">
                            <div class="img img-cover th-400">
                                <img src="client/img/lifestyle/1.png" alt="">
                            </div>
                            <div class="content pt-30">
                                <a href="home-default.html#" class="news-cat color-999 fsz-13px text-uppercase mb-10">life
                                    style</a>
                                <h3 class="title ltspc--1 mb-20"> <a href="page-single-post-creative.html">
                                        Hotdog styles on 20 countries
                                    </a> </h3>
                                <div class="text color-666">
                                    The social-media company is in discussions to sell itself to Elon, a
                                    dramatic turn of events just 11 days after the [...]
                                </div>
                                <div class="meta-bot lh-1 mt-40">
                                    <ul class="d-flex">
                                        <li class="date me-5">
                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14, 2022</a>
                                        </li>
                                        <li class="author me-5">
                                            <a href="home-default.html#"><i class="la la-user me-2"></i> by Admin </a>
                                        </li>
                                        <li class="comment">
                                            <a href="home-default.html#"><i class="la la-comment me-2"></i> 55 Comments</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 border-end brd-gray border-1">
                    <div class="tc-post-grid-default">
                        <div class="item">
                            <div class="img img-cover th-200">
                                <img src="client/img/lifestyle/2.png" alt="">
                            </div>
                            <div class="content pt-20">
                                <a href="home-default.html#"
                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">lifestyle</a>
                                <h5 class="title ltspc--1 mb-10">
                                    <a href="page-single-post-creative.html">
                                        Grand Pera Coffee
                                    </a>
                                </h5>
                                <div class="text color-666">
                                    Crime rates on trains and buses are up in some of the nation’s biggest [...]
                                </div>
                                <div class="meta-bot lh-1 mt-20">
                                    <ul class="d-flex">
                                        <li class="date me-5">
                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14, 2022</a>
                                        </li>
                                        <li class="comment">
                                            <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tc-post-list-style2">
                        <div class="items">
                            <a href="page-single-post-creative.html"
                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-4">
                                        <div class="img th-50 img-cover">
                                            <img src="client/img/lifestyle/3.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h6 class="title ltspc--1">
                                                Top 10 Best of Mustache for Hipster 2022
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="page-single-post-creative.html" class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-4">
                                        <div class="img th-50 img-cover">
                                            <img src="client/img/lifestyle/4.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h6 class="title ltspc--1">
                                                Dad and “his son”
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="page-single-post-creative.html" class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-4">
                                        <div class="img th-50 img-cover">
                                            <img src="client/img/lifestyle/5.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h6 class="title ltspc--1">
                                                The fashion trend for “old guys”
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="tc-post-grid-default">
                        <div class="item">
                            <div class="img img-cover th-200">
                                <img src="client/img/lifestyle/6.png" alt="">
                            </div>
                            <div class="content pt-20">
                                <a href="home-default.html#"
                                    class="news-cat color-999 fsz-13px text-uppercase mb-10">lifestyle</a>
                                <h5 class="title ltspc--1 mb-10">
                                    <a href="page-single-post-creative.html">
                                        Enviroment Protection
                                    </a>
                                </h5>
                                <div class="text color-666">
                                    Crime rates on trains and buses are up in some of the nation’s biggest [...]
                                </div>
                                <div class="meta-bot lh-1 mt-20">
                                    <ul class="d-flex">
                                        <li class="date me-5">
                                            <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14, 2022</a>
                                        </li>
                                        <li class="comment">
                                            <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tc-post-list-style2">
                        <div class="items">
                            <a href="page-single-post-creative.html"
                                class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-4">
                                        <div class="img th-50 img-cover">
                                            <img src="client/img/lifestyle/7.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h6 class="title ltspc--1">
                                                10 Best of Scadinavia Interior styles
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="page-single-post-creative.html" class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-4">
                                        <div class="img th-50 img-cover">
                                            <img src="client/img/lifestyle/8.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h6 class="title ltspc--1">
                                                How to make a toast with burberry
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="page-single-post-creative.html" class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-4">
                                        <div class="img th-50 img-cover">
                                            <img src="client/img/lifestyle/9.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="content">
                                            <h6 class="title ltspc--1">
                                                Enhance water in your body with Boxed Water
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== end lifestyle ====== -->

<!-- ====== start columnist ====== -->
<section class="tc-columnist-style1">
    <div class="container">
        <div class="content pt-50 pb-50 border-1 border-top brd-gray">
            <p class="color-000 text-uppercase mb-40 ltspc-1 lh-1">top columnist <i
                    class="la la-angle-right ms-1"></i> </p>
            <div class="columnist-slider1 tc-slider-style1">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="client/img/colums/1.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Conor Bradley
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Business, technology</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="client/img/colums/2.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Luis Diaz
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Politic, lifestyle</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="client/img/colums/3.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Alberto Moreno
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Entertaiment, culture, wolrd </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="columnist-card d-flex align-items-center">
                                <div
                                    class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                    <img src="client/img/colums/2.png" alt="">
                                </div>
                                <div class="info">
                                    <h6 class="name fsz-20px mb-10">
                                        Luis Diaz
                                    </h6>
                                    <div class="jop-title">
                                        <small class="fsz-13px color-999">Specialize in</small>
                                        <p class="fsz-13px text-uppercase">Politic, lifestyle</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</section>
<!-- ====== end columnist ====== -->

<!-- ====== start another-news ====== -->
<section class="another-news pt-50 pb-50 border-1 border-top brd-gray">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-lg-4">
                    <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">Sport</a> <i
                            class="la la-angle-right ms-1"></i> </p>
                    <div class="row">
                        <div class="col-12 border-1 border-end brd-gray">
                            <div class="tc-post-grid-default">
                                <div class="item">
                                    <div class="img img-cover th-250">
                                        <img src="client/img/another_news/1.png" alt="">
                                    </div>
                                    <div class="content pt-20">
                                        <a href="home-default.html#"
                                            class="news-cat color-999 fsz-13px text-uppercase mb-10">sport</a>
                                        <h4 class="title ltspc--1 mb-10">
                                            <a href="page-single-post-creative.html">
                                                America's track and field team won the 2022 olympics?
                                            </a>
                                        </h4>
                                        <div class="text color-666">
                                            Crime rates on trains and buses are up in some of the nation’s
                                            biggest [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-20">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                        2022</a>
                                                </li>
                                                <li class="comment">
                                                    <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <a href="page-single-post-creative.html"
                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/img/another_news/2.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <small
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">sport</small>
                                                    <h5 class="title ltspc--1">
                                                        How’s Ameican Football Ball created out?
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html"
                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 brd-gray">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/img/another_news/3.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <small
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">sport</small>
                                                    <h5 class="title ltspc--1">
                                                        Daniel share experience ski on Everest
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">Entertaiment</a> <i
                            class="la la-angle-right ms-1"></i> </p>
                    <div class="row">
                        <div class="col-12 border-1 border-end brd-gray">
                            <div class="tc-post-grid-default">
                                <div class="item">
                                    <div class="img img-cover th-250">
                                        <img src="client/img/another_news/4.png" alt="">
                                    </div>
                                    <div class="content pt-20">
                                        <a href="home-default.html#"
                                            class="news-cat color-999 fsz-13px text-uppercase mb-10">Entertaiment</a>
                                        <h4 class="title ltspc--1 mb-10">
                                            <a href="page-single-post-creative.html">
                                                Logan Cee's Best Contemporary Art Works
                                            </a>
                                        </h4>
                                        <div class="text color-666">
                                            Crime rates on trains and buses are up in some of the nation’s
                                            biggest [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-20">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                        2022</a>
                                                </li>
                                                <li class="comment">
                                                    <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <a href="page-single-post-creative.html"
                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/img/another_news/5.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <small
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">entertaiment</small>
                                                    <h5 class="title ltspc--1">
                                                        Netflix change their policy for package family
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html"
                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 brd-gray">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/img/another_news/6.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <small
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">entertaiment</small>
                                                    <h5 class="title ltspc--1">
                                                        Buy black vinyl record at Festival Oldschool market
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <p class="color-000 text-uppercase mb-30 ltspc-1"> <a href="page-blog.html">Travel</a> <i
                            class="la la-angle-right ms-1"></i> </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="tc-post-grid-default">
                                <div class="item">
                                    <div class="img img-cover th-250">
                                        <img src="client/img/another_news/7.png" alt="">
                                    </div>
                                    <div class="content pt-20">
                                        <a href="home-default.html#"
                                            class="news-cat color-999 fsz-13px text-uppercase mb-10">Travel</a>
                                        <h4 class="title ltspc--1 mb-10">
                                            <a href="page-single-post-creative.html">
                                                Top 10 Most beautiful hot springs in the world
                                            </a>
                                        </h4>
                                        <div class="text color-666">
                                            Crime rates on trains and buses are up in some of the nation’s
                                            biggest [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-20">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="home-default.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                        2022</a>
                                                </li>
                                                <li class="comment">
                                                    <a href="home-default.html#"><i class="la la-comment me-2"></i> 7</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <a href="page-single-post-creative.html"
                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/img/another_news/8.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <small
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">Travel</small>
                                                    <h5 class="title ltspc--1">
                                                        Experience in applying for a visa card for newcomers
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html"
                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 brd-gray">
                                        <div class="row gx-3 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="client/img/another_news/9.png" alt="">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <small
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">Travel</small>
                                                    <h5 class="title ltspc--1">
                                                        Release yourself on the sea and get the vibe chill
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== end another-news ====== -->

<!-- ====== start download ====== -->
<section class="tc-download-style1 pb-50">
    <div class="container">
        <div class="content">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="info">
                        <strong class="title">Download Newzin App</strong>
                        <div class="text">
                            Easy to update latest news, daily podcast and everything in your hand
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="img">
                        <a href="home-default.html#">
                            <img src="client/img/apple1.png" alt="">
                        </a>
                        <a href="home-default.html#">
                            <img src="client/img/android1.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== end download ====== -->

<!-- ====== start modals ====== -->

<div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="logo">
            <img src="client/img/logo_home1.png" alt="" class="dark-none">
            <img src="client/img/logo_home1_lt.png" alt="" class="light-none">
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mt-4">
        <h6 class="color-000 text-uppercase mb-15 ltspc-1"> about us <i class="la la-angle-right ms-1"></i>
        </h6>
        <div class="text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae.
            Soluta corporis quidem aperiam amet nihil.
        </div>

        <div class="sidebar-categories mt-40">
            <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i
                    class="la la-angle-right ms-1"></i> </h6>
            <a href="home-default.html#" class="cat-card">
                <div class="img img-cover">
                    <img src="client/img/bussines/1.png" alt="">
                </div>
                <div class="info">
                    <h5>bussines</h5>
                    <span class="num">12</span>
                </div>
            </a>
            <a href="home-default.html#" class="cat-card">
                <div class="img img-cover">
                    <img src="client/img/trend/3.png" alt="">
                </div>
                <div class="info">
                    <h5>technology</h5>
                    <span class="num">14</span>
                </div>
            </a>
            <a href="home-default.html#" class="cat-card">
                <div class="img img-cover">
                    <img src="client/img/must_read/3.png" alt="">
                </div>
                <div class="info">
                    <h5>culture</h5>
                    <span class="num">20</span>
                </div>
            </a>
            <a href="home-default.html#" class="cat-card">
                <div class="img img-cover">
                    <img src="client/img/videos/1.png" alt="">
                </div>
                <div class="info">
                    <h5>videos</h5>
                    <span class="num">14</span>
                </div>
            </a>
        </div>
        <div class="sidebar-contact-info mt-50">
            <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i
                    class="la la-angle-right ms-1"></i> </h6>
            <ul class="m-0">
                <li class="mb-3">
                    <i class="las la-map-marker me-2 color-main fs-5"></i>
                    <a href="home-default.html#">streat name 12, hollywood City, USA</a>
                </li>
                <li class="mb-3">
                    <i class="las la-envelope me-2 color-main fs-5"></i>
                    <a href="home-default.html#">Newzin@gmail.com</a>
                </li>
                <li class="mb-3">
                    <i class="las la-phone-volume me-2 color-main fs-5"></i>
                    <a href="home-default.html#">+12 123 456 789</a>
                </li>
            </ul>
            <div class="social-links">
                <a href="home-default.html#">
                    <i class="la la-twitter"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-facebook-f"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-instagram"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-youtube"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-spotify"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- ====== end modals ====== -->

 </span>
</main>
