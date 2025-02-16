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
          <th class="pb-2">Avatar</th>
          <th class="pb-2">Username</th>
          <th class="pb-2">Phone</th>
          <th class="pb-2">Email</th>
          <th class="pb-2">Role</th>
          <th class="pb-2">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t hover:bg-gray-50">
          <td class="py-3 flex items-center space-x-3">
            <img src="{{ asset('images/usercr7.jpg') }}" alt="User Image" class="w-10 h-10 rounded-full" />
          </td>
          <td class="py-3 text-gray-800">nguyenvana</td>
          <td class="py-3 text-gray-800">0123456789</td>
          <td class="py-3 text-gray-800">nguyenvana@gmail.com</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Người Dùng</span></td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Khóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
          <td class="py-3 flex items-center space-x-3">
            <img src="{{ asset('images/satikhoc.jpg') }}" alt="User Image" class="w-10 h-10 rounded-full" />
          </td>
          <td class="py-3 text-gray-800">Lý Thập Phong</td>
          <td class="py-3 text-gray-800">0987654321</td>
          <td class="py-3 text-gray-800">tranthib@gmail.com</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Tác Giả</span></td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Khóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 flex items-center space-x-2">
              <img src="{{ asset('images/7takhoc2.jpg') }}" alt="User Image" class="w-10 h-10 rounded-full" />
            </td>
            <td class="py-3 text-gray-800">Lê Quang Liêm</td>
            <td class="py-3 text-gray-800">0987654321</td>
            <td class="py-3 text-gray-800">tranthib@gmail.com</td>
            <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Tác Giả</span></td>
            <td class="py-3 space-x-2">
              <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
              <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Khóa</button>
            </td>
          </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
