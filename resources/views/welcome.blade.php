<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>24HNews Homapage</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <header class="flex flex-col bg-white shadow-md w-full">
    <div class="flex justify-between items-center p-4 max-w-7xl mx-auto">
      <div class="flex items-center space-x-4 mx-10">
        <h1 class="text-2xl font-bold text-red-600">24H<span class="text-gray-800">News</span></h1>
        <span class="text-sm text-gray-500">Thứ bảy, 15/2/2025</span>

      </div>
      <div class="flex items-center space-x-3">
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Mới nhất</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Tin theo khu vực</button>

        <div class="relative">
          <input type="text" placeholder="Tìm kiếm..." class="pl-10 pr-2 py-1 border rounded" />
          <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z"></path></svg>
        </div>
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Đăng nhập</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Đăng ký</button>

      </div>
    </div>
    <nav class="border-t bg-white mt-4">
        <ul class="flex justify-between px-20 p-2 text-sm font-medium text-gray-700">
          <li class="hover:text-red-600 cursor-pointer">Thời sự</li>
          <li class="hover:text-red-600 cursor-pointer">Góc nhìn</li>
          <li class="hover:text-red-600 cursor-pointer">Thế giới</li>
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
        </ul>
      </nav>
  </header>
 <main>
    <span class="max-w-7xl mx-auto p-4 grid grid-cols-12 gap-4 min-h-[75vh]">
        <div class="col-span-12 flex flex-col space-y-4">
          <article class="flex items-center bg-white p-4 shadow rounded-lg">
            <div class="flex-1 pr-4">
              <p class="text-sm text-gray-500 mb-1">10' trước</p>
              <h2 class="text-xl font-bold mb-1">Vì sao "Captain America: Thế giới mới" lấn át loạt phim Việt?</h2>
              <p class="text-sm text-gray-600">(Dân trí) - Sau khi ra rạp, bom tấn "Captain America: Thế giới mới" đã vượt qua nhiều phim nội địa, vươn lên top đầu bảng xếp hạng.</p>
            </div>
            <img src="https://cdnphoto.dantri.com.vn/6gRiSElGR7YXOBfp3MfV-ulahmU=/thumb_w/1020/2025/02/16/77777777777777-1715867069899-1739684115258.jpg" alt="Hình ảnh bài viết 1" class="w-40 h-24 object-cover rounded-md">
          </article>
          <article class="flex items-center bg-white p-4 shadow rounded-lg">
            <div class="flex-1 pr-4">
              <p class="text-sm text-gray-500 mb-1">15' trước</p>
              <h2 class="text-xl font-bold mb-1">Nhiều du khách rơi xuống sông khi tham quan ở chợ nổi Cần Thơ</h2>
              <p class="text-sm text-gray-600">(Dân trí) - Mạng xã hội lan truyền clip ghi cảnh nhóm du khách khoảng chục người rơi xuống sông khi tham quan tại chợ nổi Cái Răng.</p>
            </div>
            <img src="https://cdnphoto.dantri.com.vn/6gRiSElGR7YXOBfp3MfV-ulahmU=/thumb_w/1020/2025/02/16/77777777777777-1715867069899-1739684115258.jpg" alt="Hình ảnh bài viết 2" class="w-40 h-24 object-cover rounded-md">
          </article>
          <article class="flex items-center bg-white p-4 shadow rounded-lg">
            <div class="flex-1 pr-4">
              <p class="text-sm text-gray-500 mb-1">26' trước</p>
              <h2 class="text-xl font-bold mb-1">Siêu mẫu Như Vân thi hoa hậu ở tuổi 33, tiết lộ đang làm mẹ đơn thân</h2>
              <p class="text-sm text-gray-600">(Dân trí) - Trước thềm dự thi Hoa hậu Toàn cầu 2024, người đẹp Như Vân gây bất ngờ khi tiết lộ đang làm mẹ đơn thân.</p>
            </div>
            <img src="https://cdnphoto.dantri.com.vn/6gRiSElGR7YXOBfp3MfV-ulahmU=/thumb_w/1020/2025/02/16/77777777777777-1715867069899-1739684115258.jpg" alt="Hình ảnh bài viết 3" class="w-40 h-24 object-cover rounded-md">
          </article>
        </div>
      </span>
      <span class="max-w-7xl mx-auto mt-[-6rem] p-4 grid grid-cols-12 gap-4 min-h-[75vh]">
        <div class="col-span-3 flex flex-col justify-between h-[32rem]">
          <!-- Cột trái -->
          <article class="bg-white p-4 shadow rounded-lg h-1/2 w-full mb-0">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 1" class="w-full h-3/4 object-cover rounded-md">
            <div class="p-2 w-full h-1/4">
              <h2 class="text-lg font-bold mb-1">Tiêu đề bài viết 1</h2>
              <p class="text-sm text-gray-600">Nội dung bài viết 1...</p>
            </div>
          </article>
          <article class="bg-white p-4 shadow rounded-lg h-1/2 w-full mt-0">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 2" class="w-full h-3/4 object-cover rounded-md">
            <div class="p-2 w-full h-1/4">
              <h2 class="text-lg font-bold mb-1">Tiêu đề bài viết 2</h2>
              <p class="text-sm text-gray-600">Nội dung bài viết 2...</p>
            </div>
          </article>
        </div>
        <div class="col-span-6 grid grid-rows-1 gap-4 h-[32rem]">
          <!-- Cột giữa -->
          <article class="bg-white p-4 shadow rounded-lg h-full flex flex-col">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 3" class="w-full h-full object-cover rounded">
            <div class="p-4 flex flex-col justify-center">
              <h2 class="text-xl font-bold mb-2">Tiêu đề bài viết 3</h2>
              <p class="text-sm text-gray-600">Nội dung chi tiết bài viết 3...</p>
            </div>
          </article>
        </div>
        <div class="col-span-3 flex flex-col justify-between h-[32rem]">
          <!-- Cột phải -->
          <article class="bg-white p-4 shadow rounded-lg h-1/4 w-full mb-0 flex">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 4" class="w-1/2 h-full object-cover rounded-md">
            <div class="p-2 w-1/2 h-full flex flex-col justify-center">
              <h2 class="text-lg font-bold mb-1">Tiêu đề bài viết 4</h2>
              <p class="text-sm text-gray-600">Nội dung bài viết 4...</p>
            </div>
          </article>
          <article class="bg-white p-4 shadow rounded-lg h-1/4 w-full mt-0 flex">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 5" class="w-1/2 h-full object-cover rounded-md">
            <div class="p-2 w-1/2 h-full flex flex-col justify-center">
              <h2 class="text-lg font-bold mb-1">Tiêu đề bài viết 5</h2>
              <p class="text-sm text-gray-600">Nội dung bài viết 5...</p>
            </div>
          </article>
          <article class="bg-white p-4 shadow rounded-lg h-1/4 w-full mt-0 flex">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 5" class="w-1/2 h-full object-cover rounded-md">
            <div class="p-2 w-1/2 h-full flex flex-col justify-center">
              <h2 class="text-lg font-bold mb-1">Tiêu đề bài viết 5</h2>
              <p class="text-sm text-gray-600">Nội dung bài viết 5...</p>
            </div>
          </article>
          <article class="bg-white p-4 shadow rounded-lg h-1/4 w-full mt-0 flex">
            <img src="https://cdnphoto.dantri.com.vn/r2iMkm1ljNbOP81lcrpsmsUqlo8=/zoom/1032_688/2025/02/16/3473733-1715865607352-1739684177491.jpg" alt="Hình ảnh bài viết 5" class="w-1/2 h-full object-cover rounded-md">
            <div class="p-2 w-1/2 h-full flex flex-col justify-center">
              <h2 class="text-lg font-bold mb-1">Tiêu đề bài viết 5</h2>
              <p class="text-sm text-gray-600">Nội dung bài viết 5...</p>
            </div>
          </article>
        </div>
      </span>
 </main>
 <footer class="bg-white border-t border-gray-200 p-8 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto grid grid-cols-3 gap-8">
      <div class="space-y-4 ml-4">
        <h1 class="text-2xl font-bold text-red-600">24H<span class="text-gray-800">News</span></h1>
        <p>Cơ quan của Bộ Lao động - Thương binh và Xã hội</p>
        <p>Tổng biên tập: Phạm Tuấn Anh</p>
        <p>Giấy phép hoạt động báo điện tử số 411/GP - BTTTT Hà Nội, ngày 31-10-2023</p>
        <p>Địa chỉ: Nhà 48, ngõ 2 Giảng Võ, Cát Linh, Đống Đa, Hà Nội</p>
        <p>Điện thoại: 024-3736-6491. Hotline HN: 0973-567-567</p>
        <p>Văn phòng đại diện miền Nam: 51 Võ Văn Tần, Phường Võ Thị Sáu, Quận 3, TPHCM</p>
        <p>Hotline TPHCM: 0974-567-567</p>
        <p>Email: info@dantri.com.vn</p>
      </div>
      <div>
        <h3 class="font-semibold mb-2">RSS</h3>
        <p>Liên hệ toà soạn</p>
        <p>Liên hệ quảng cáo: 0945.54.03.03</p>
        <p>Email: quangcao@dantri.com.vn</p>
        <p>Chính sách bảo mật dữ liệu cá nhân</p>
      </div>
      <div>
        <h3 class="font-semibold mb-2">Đọc báo Dân trí trên mobile:</h3>
        <div class="flex space-x-4 mb-4 d-flex">
          <img class="w-24 h-8"  src="data:image/png;base64,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" alt="App Store">
          <img class="w-24 h-10" src="data:image/png;base64,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" alt="Google Play">
        </div>
        <h3 class="font-semibold mb-2">Theo dõi Dân trí trên:</h3>
        <div class="flex space-x-4">
          <img class="w-24 h-10"src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBw0IBwcHBw0NBwcHBw0HBwcHDQ8ICQcNIBEWFiAdFhMYHygsJCYlGxMXJz0jJTU3Nzo6Fx8zOD8sNygtMDcBCgoKDQ0OGw8PFS0dHiAtKzc3LSs3LTcrKzArKzcrNzcrLy0tMCstKy0zKysrKzcrKy0vLSs3Ky0uKysrKy0tK//AABEIAOEA4QMBEQACEQEDEQH/xAAcAAEAAgMBAQEAAAAAAAAAAAAAAQcCBQYEAwj/xABIEAEAAQMCAAYLCwkJAAAAAAAAEQECAwQFBgcSUXWzExQhJTE1NmFxhLEVIiNBU1STlLLR0iYygYORkqG0wRYXM0VSYoLC4v/EABsBAQACAwEBAAAAAAAAAAAAAAABBgMEBQIH/8QAMhEBAAECAwQGCgMBAAAAAAAAAAECAwQFsREzNIESIUFRcXITFDFSU2GRodHhFcHwIv/aAAwDAQACEQMRAD8A+66vn4AAAAAAAAAAAAAAAAAAAAAAAAAAADGUhIEgSBIEgSBIEgSBIEgSBIEgSBIEgSBIEgSBIEgSBIEgSBIMRJIAAEgASAABIAEgAASABIAAEgASAABIAEgAAxAAAAAAAAAAAAAAAAAAAAAAAAAAAABEiSQJAkCQJAkCQJAkCQJAkCQJAkCQJAkCQJAkCQJAkCQJAkCUjGRJIEgSBIEgSBIEgSBIEgSBIM8OO/NktxYLLs2W783Fhtrkvu9FKPNVUUxtqnZCaaaqp2Uxtn5N/ouBm4ailLr7Mejtr4O2r4urT0Wz/Fo3Mzw9HsmavD97HRt5Tia+uYinx/W1tMfF7krT4TWWWV+OlmCuSn8bqNWc4p7Lf3/TajI6u259v2z/ALvK/Frafp03/tH8zHw/v+k/wc/F+37fHJxfZqf4Wqx383LxXY/ZWr1GcUdtE/V5nJK+y5H0/bx5uA2vspWtldPn5qY8l1ta/vW0Zqc1w8+3bHL9sFWT4mPZsnn+mh3DQ5tvz102ts7BnpZTJyOVbk97Xz21rzN+1dou09KidsOfes3LNXQuRsl5pZGMkCQJAkCQJAkESBIEgSBIEgSBIEgSBIEgSDf8GeDOXd7uzZK10232Xcm/UR7/ADV5rJ9vtaOMx1OH/wCY66u7u8XRwWX14j/qeqnv7/BZO2bXp9txdh0OO3DStPf3099ky1/3XV7tVcvX7l6dtc7Vms4e1Zp6NunY9jCzAAAAKx4w/HvqOL23LLlXD85VbOOI5R/bmZdJyyQJAkCQJAkCQYylJIEgSBIEgSBIEgSBIEg23BjZ67vuNmmrNumxU7NrMlvcrbZPgpXnr4P21+JqYzExYt9Ltn2f75NvBYWcRd6PZHt/3zW7gw2YMWPBhtpiw4rKY8eOykW2WqpVVNUzVVO2ZW+mmKYimmNkQzeXoAAAABV/GJ4+9Rxe25Zsq4fnKr5vxHKP7czLpOWSBIEgSBIEgSDGQJAkCQJAkCQJAkCQJAkFqcAdupo9mx6i6kZ9xr21fX4+R4Lafs7v/KqsZne9Jfmnsp6vytWV2PR2Iq7auv8ADpHOdIAAAAABV3GL4+9Rxe25Zsq4fnKr5vxHKP7cxLpOWSBIEgSBIEgSDESAAAAAAAAAAyx465cmPDZ+flvtxWemtY/qiZimNs9iYpmqYpjtXrgxW4cWLDjpGPDjtxWU5raUhSaqpqmZntXmmmKYiI7GaEgAPhrdXi0Wmy6vV30w6fDbysmS74v0c/me7duq5VFFEbZl4uXKbdM11zsiHAbpxgZ8l91m14rNNh8FuXU07Lnv88TFPR3Xes5RREbbs7Z+Xs/OjgXs4uTOy1Tsj5+3/fVqK8MNzrWe2q081MOClPstr+Owvufefy1P5LF+/wDaPwj+1+5/O7vosH4U/wAdhfc+8/k/kcV8T7R+Gs3DcM24Z+2ddk7Yz8imPslbbbPe081tKc7YtWaLVPRojZDWu3q7tXSuTtl5mRiAAAAAAAQlIAAAAAAAAAD27HTlbxtNtfBdummpX0dltYMT1Wa/LOjNht9R5o1Xcpq6AAAK44zNxuya3TbXbX4HTYqarLbTwX5azSk+i37VVhyizEUTdn2z1clezi9M1xa7I6+bi3YcYAAAAAAAAAABjIEgSBIEgSBIEgSBIEg9/B+vfrZ+ldN1trBitxX5Z0Z8NvqPNTqu5TVzAAAVDw7r+U25+auClPN8BjWvLeFo56yqmZcVVy0hoJbzQJAkCQJAkCQJAkCQJAkGIlMggEgAgEyCASACAbDg/Xv1s/Sum621hxW4r8s6M2G31HmjVd6mLmAAAp/h35Tbp6cHUY1sy3haOesqpmXE1ctIaButFIAIBMggEgAgEyCATIMUpAAAAAAARPPUQcqnPQ2Byqc9DYNhwerT3b2bu/5rputtYMVuK/LOjPht9R5o1Xipi5AAAKd4e1jhPundju4OoxrZlvC0c9ZVTMuJq5aQ0HKpz0b2xonKpz0NgcqnPQ2CZAEgAAAAAAMZAkCQJAkCQJAkFocWunx5djyXZcdmS73Qy05WS2l1Y5NvOrebV1Rf6p7IWPKqYmx1x2y6vtPD8ji+jt+5zPSV+9Lp9CnuO08PyOL6O37j0lfvSdCnuTbpMVtaXW4sdt1teVbdbZbStKnpK57ZOhT3Ps8PQAAD5X6bFfdW/Jjx333eG6+y266v6XqK6o6ol5mmmfbDHtPD8ji+jt+5PpK/ek6FPcdp4fkcX0dv3HpK/ek6FPcdp4fkcX0dv3HpK/ek6FPco/d8tM257jmsilmTX5r7KW9ylLeXWP4LlYp6NqmJ7o0U6/PSu1THfOrySysRIEgSBIEgSBIMZEkgSBIEgSBIEgtbiw8Q5Okcv2bFazfiOULJlO45y65ynTAAAAAAAAAfDXZ6abR6rVV7lNNpsmeta+ClKW1r/R7t09OuKe+YeLlXRpmqeyFBU8FPQvClEoSSBIEgSBIEgSkQAAAAAAAC1uK/xBk6Sy/ZsVnOOI5QsmU7jnLr3KdMAAAAAAAABpOGuo7X4Obtk/16btf966ln/ZuZfR0sTRHz062pjqujh65+WvUpVb1TAAAAAAAAYyJJAkCQJAkCQJBa/Fd4gydJZfs2KznHEcoWPKtxzl2DlOmAAAAAAAAA5DjQ1HYthsxU8Oq1+PFWnmpS6/220dXKKNt/b3RP4c3NatljZ3zH5VPKzK2SBIEgSBIEgSBIISlAAJBAJBAAPXpdz1Wlx9i0mp1GlxVurfXFps2TDZWvPFKsVdm1XO2uiJn5xDJReuURspqmI+Uy+3u9r/n2s+tZvxPPqtj4dP0h69Zv/En6ye72v+faz61m/Eeq2Ph0/SD1m/8AEn6y92wb1rcm87Riy6zV5MWTdNPjyY8mpy32ZLa5LaVpWlasGJw1iLNcxbiOqeyO5mw+IvTdoia59sds966lRWkAABUnDndtXp+Em5YNNqtTp8GPsPIw4M+TFjs+Bsr3LaV561WjLrFmrDU1VURM9ftiO+Vbx9+7TiKoprmI6u2e6Gi93tf8+1n1rN+Ju+q2Ph0/SGp6zf8AiT9ZPd7X/PtZ9azfiPVbHw6fpB6zf+JP1l8NXuOp1dttms1GfV2WXcqyzVZr89tleelLqvdFm3R10UxHhEPNd25XGyqqZ8ZeZkY0AAkEAkEAAkGMgSBIEgSBIEgSBIEgSDY8HK9/dk6X0vW2sGK3FflnRmw++o80ar5UpbwAAFL8YXlVuv6jqMa25ZwtHPWVXzHiauWkOdlvtIkCQJAkCQJAkCQJAkCQYyJJAkCQJAkCQJAkCQJBseDde/uydL6XrbWDFbivyzozYffUeaNV9qUtwAACluMPyq3X9R1GNbss4WjnrKr5hxNXLSHOS3mmSBIEgSBIEgSBIEgSBIIlKSQJAkQSBIkkCQJEEgSJbHg3Xv8AbJ0vpetta+K3FflnRlw++o80ar8UpbgAAFKcYlfyq3X1fqMa3ZZwtHPWVYzDiauWkOdlvtMkQSBIkkCQJEEgSJJAkCRDGRJIEgSBIEgSBIEgSBINjwar3+2TpfS9bawYrcV+WdGbD76jxjVfykraAAApPjEr+Ve6+r9RjW7LOFo56yrGYcTVy0hzkt9pkgSBIEgSBIEgSBIEgSDFIAAAAAAAAAA2XBrx9sfTGl621r4rcV+WdGbD76jxjVf6kraAAApLjF8q919X6jGt2V8LRz1lWcw4mrlpDm3QaQAAAAAAAAAACBJIAEgAASABIAANlwZ8f7H0xpetta+L3FflnRmw++o8Y1foBSVsAAAUjxjeVm7er9RjW7K+Fo56yrOYcRVy0hzboNMkAACQAJAAAkAAGMiSQJAkCQJAkCQJAkCQbLgzXv8A7H0xpetta+L3FflnRmw++o8Y1foJSVrAAAUhxj+Vm7er9RjW/K+Fo56yrWYcRVy0hzUt9pkgSBIEgSBIEgSBIEgSDFIAAAAAAAAAA2fBjx/sfTGl621r4vcV+WdGbD76jxjV+g1IWsAABR3GR5W7t6v/AC+Nb8r4WjnrKtZhxFXLSHNOg0wAAAAAAAAAAECQAAAAAAAAAGz4MeUGxdMaXrbWvi9xX5Z0ZsPvqPGNX6EUhagAAFG8ZHlbu3q/8vjW/K+Fo56yreP4irlpDmnQaYAAAAAAAAAACAAAAAAAAAAAbPgx5QbF0zpetta+L3FflnRmw++o8Y1foVSFqAAAUbxk+Vu7er/y+NcMr4WjnrKt4/iKuWkOZb7TAAAAAAAAAAAf/9k=" alt="Facebook">
          <img class="w-24 h-10" src="data:image/png;base64,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" alt="YouTube">
          <img class="w-24 h-10" src="data:image/png;base64,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" alt="TikTok">
        </div>
      </div>
    </div>
    <div class="text-center mt-8 text-gray-500 border-t pt-4">© 2005-2025 Bản quyền thuộc về Báo điện tử Dân trí. Cấm sao chép dưới mọi hình thức nếu không có sự chấp thuận bằng văn bản.</div>
  </footer>
</body>
</html>
@extends('master')

@section('tieudetrang')
    Home
@endsection

@section('content')
<style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #ffffff;
    color: #333;
}
a{
    text-decoration: none;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-title {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #2c3e50;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
    padding-bottom: 5px;
}

/* Featured Article */
.featured-article .article {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    display: flex;
    gap: 20px;
    align-items: center;
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
}

.featured-article .article:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.featured-article img {
    width: 300px;
    height: 200px;
    border-radius: 15px;
    object-fit: cover;
    transition: filter 0.3s;
}

.featured-article img:hover {
    filter: brightness(1.2);
}

.featured-article .article-content {
    flex: 1;
}

.featured-article h3 a {
    text-decoration: none;
    color: #007bff;
    font-size: 1.5rem;
    font-weight: bold;
}

.featured-article h3 a:hover {
    text-decoration: none;
    color: #0056b3;
}

/* Latest Articles */
.latest-articles .articles-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.latest-articles .article {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    transition: transform 0.3s;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

.latest-articles .article:hover {
    transform: translateY(-5px);
}

.latest-articles img {
    width: 100%;
    height: 180px;
    border-radius: 10px;
    object-fit: cover;
}

.read-more {
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.read-more:hover {
    background-color: #0056b3;
}
</style>

<main class="main-content">
    <div class="container">
        <section class="featured-article">
            <h2 class="section-title">Featured Article</h2>
            <article class="article">
                <img src="{{ asset('storage/' . $featuredArticle->thumbnail_url) }}" alt="{{ $featuredArticle->title }}">
                <div class="article-content">
                    <h3><a href="{{ route('client.articles.article', $featuredArticle->article_id) }}">{{ $featuredArticle->title }}</a></h3>
                    <p>{{ Str::limit($featuredArticle->preview_content, 150, '...') }}</p>
                    <a href="{{ route('client.articles.article', $featuredArticle->article_id) }}" class="read-more">Read More</a>
                </div>
            </article>
        </section>

        <section class="latest-articles">
            <h2 class="section-title">Latest Articles</h2>
            <div class="articles-grid">
                @foreach ($articles as $article)
                    <article class="article">
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}">
                        <h3><a href="{{ route('client.articles.article', $article->article_id) }}">{{ $article->title }}</a></h3>
                        <p>{{ Str::limit($article->preview_content, 80, '...') }}</p>
                        <a href="{{ route('client.articles.article', $article->article_id) }}" class="read-more">Read More</a>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</main>
@endsection
