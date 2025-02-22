<header class="flex flex-col bg-white shadow-md w-full">
    <div class="flex justify-between items-center p-4 max-w-7xl mx-auto">
        <div class="flex items-center space-x-4 mx-10">
            <h1 class="text-2xl font-bold text-red-600">24H<span class="text-gray-800">News</span></h1>
            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('l, d/m/Y') }}</span>
        </div>
        <div class="flex items-center space-x-3">
            <button class="px-3 py-1 border rounded hover:bg-gray-100">Mới nhất</button>
            <button class="px-3 py-1 border rounded hover:bg-gray-100">Tin theo khu vực</button>
            <div class="relative">
                <input type="text" placeholder="Tìm kiếm..." class="pl-10 pr-2 py-1 border rounded" />
                <svg class="absolute left-2 top-2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <a href="{{ route('login') }}" class="px-3 py-1 border rounded hover:bg-gray-100 flex items-center">
                <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
            </a>
            <a href="{{ route('signup') }}" class="px-3 py-1 border rounded hover:bg-gray-100 flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Đăng ký
            </a>

        </div>
    </div>
    <nav class="border-t bg-white mt-4">
        <ul class="flex justify-between px-20 px-4 p-2 text-base font-bold text-gray-700 items-center">
            <!-- Icon Home -->
            <li class="hover:text-red-600 cursor-pointer flex items-center">
                <i class="fas fa-home text-gray-500 text-lg mr-2 "></i>
            </li>

            <!-- Các danh mục -->
            <li class="hover:text-red-600 cursor-pointer">Thời sự</li>
            <li class="hover:text-red-600 cursor-pointer">Góc nhìn</li>
            <li class="hover:text-red-600 cursor-pointer ">Thế giới</li>
            <li class="hover:text-red-600 cursor-pointer">Video</li>
            <li class="hover:text-red-600 cursor-pointer">Podcasts</li>
            <li class="hover:text-red-600 cursor-pointer">Kinh doanh</li>
            <li class="hover:text-red-600 cursor-pointer">Bất động sản</li>
            <li class="hover:text-red-600 cursor-pointer">Khoa học</li>
            <li class="hover:text-red-600 cursor-pointer">Giải trí</li>
            <li class="hover:text-red-600 cursor-pointer">Thể thao</li>
            <li class="hover:text-red-600 cursor-pointer">Pháp luật</li>
            <li class="hover:text-red-600 cursor-pointer">Giáo dục</li>
            <li class="hover:text-red-600 cursor-pointer">Sức khoẻ</li>
            <li class="hover:text-red-600 cursor-pointer">Đời sống</li>
            <li class="hover:text-red-600 cursor-pointer">Du lịch</li>
            <li class="hover:text-red-600 cursor-pointer">Công nghệ</li>
            <li class="hover:text-red-600 cursor-pointer">Xe</li>
            <li class="hover:text-red-600 cursor-pointer">Ý kiến</li>
            <li class="hover:text-red-600 cursor-pointer">Tâm sự</li>

            <!-- Icon Danh Mục -->
            <li class="hover:text-red-600 cursor-pointer flex items-center">
                <i class="fas fa-bars text-gray-500 text-lg ml-2"></i>
            </li>
        </ul>
    </nav>

</header>
