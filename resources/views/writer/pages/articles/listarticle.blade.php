<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Danh Sách Người Dùng</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

  <div class="p-6 bg-white rounded-lg shadow-md">
    <table class="w-full table-auto text-left">
      <thead class="text-gray-500 text-sm">
        <tr>
          <th class="pb-2">Hình ảnh</th>
          <th class="pb-2">Title</th>
          <th class="pb-2">Category</th>
          <th class="pb-2">Slug</th>
          <th class="pb-2">View</th>
          <th class="pb-2">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t hover:bg-gray-50">
          <td class="py-3 flex items-center space-x-3">
            <img src="{{ asset('images/usercr7.jpg') }}" alt="User Image" class="w-10 h-10" />
          </td>
          <td class="py-3 text-gray-800">Anh Liêm</td>
          <td class="py-3 text-gray-800">Thể thao</td>
          <td class="py-3 text-gray-800">
            <a href="https://www.google.com/url?sa=i&url=https%3A%2F%2Fmobilecity.vn%2Ftin-tuc%2Ftop-anh-ronaldo-sieu-ngau-chat-danh-cho-dien-thoai-va-may-tinh.html&psig=AOvVaw0a2087CMBOv5FlsvfirQtf&ust=1739801196051000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCOi73NKuyIsDFQAAAAAdAAAAABAE" class="">rol</a>
          </td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">7</span></span></td>
          <td class="py-3 space-x-2">
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xoa</button>
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">show</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
