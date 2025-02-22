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
    </span>

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


 </span>
</main>
