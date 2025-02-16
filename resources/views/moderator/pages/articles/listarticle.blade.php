<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Danh Sách Bài Viết</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body >
  <div class="p-6 bg-white rounded-lg shadow-md">
    <table class="w-full table-auto text-left">
      <thead class="text-gray-500 text-sm">
        <tr>
         <th class="pb-2">Tiêu đề</th>
          <th class="pb-2">Nội dung</th>
          <th class="pb-2">Danh mục</th>
          <th class="pb-2">Tác giả</th>
          <th class="pb-2">Trạng thái</th>
          <th class="pb-2">Lượt xem</th>
          <th class="pb-2">Duyệt bởi</th>
          <th class="pb-2">Thời gian tạo</th>
          <th class="pb-2">Hành động</th>

        </tr>
      </thead>
      <tbody>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 1</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Công Nghệ</td>
          <td class="py-3 text-gray-800">Nguyễn Văn A</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Đang Chờ Duyệt</span></td>
          <td class="py-3 text-gray-800">1.2K</td>
          <td class="py-3 text-gray-800">Admin1</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 2</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Thể Thao </td>
          <td class="py-3 text-gray-800">Nguyễn Văn BB</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Đã Duyệt</span></td>
          <td class="py-3 text-gray-800">999</td>
          <td class="py-3 text-gray-800">Admin22</td>
          <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 4</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Giải Trí</td>
          <td class="py-3 text-gray-800">Nguyễn Văn A</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Đang Chờ Duyệt</span></td>
          <td class="py-3 text-gray-800">1.2K</td>
          <td class="py-3 text-gray-800">Admin1</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 5</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Công Nghệ</td>
          <td class="py-3 text-gray-800">Nguyễn Văn BB</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Đã Duyệt</span></td>
          <td class="py-3 text-gray-800">999</td>
          <td class="py-3 text-gray-800">Admin22</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">

            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 9</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Công Nghệ</td>
          <td class="py-3 text-gray-800">Nguyễn Văn A</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Đang Chờ Duyệt</span></td>
          <td class="py-3 text-gray-800">1.2K</td>
          <td class="py-3 text-gray-800">Admin1</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 1</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Công Nghệ</td>
          <td class="py-3 text-gray-800">Nguyễn Văn A</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Đang Chờ Duyệt</span></td>
          <td class="py-3 text-gray-800">1.2K</td>
          <td class="py-3 text-gray-800">Admin1</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">
            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 2</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Công Nghệ</td>
          <td class="py-3 text-gray-800">Nguyễn Văn BB</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Đã Duyệt</span></td>
          <td class="py-3 text-gray-800">999</td>
          <td class="py-3 text-gray-800">Admin22</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>
        <tr class="border-t hover:bg-gray-50">

            <td class="py-3 text-gray-800 font-semibold max-w-[150px] overflow-hidden text-ellipsis whitespace-nowrap" title="Tiêu đề bài viết 1">Tiêu đề bài viết 2</td>
          <td class="py-3 text-gray-800 max-w-[200px] overflow-hidden text-ellipsis whitespace-nowrap">
            Nội dung bài viết ...
            <button onclick="Swal.fire({
              title: 'Nội dung bài viết',
              html: '<div style=\'width: 1200px; margin: 0 auto; text-align: center; overflow-x: hidden;\'><p style=\'text-align: center;\'>' + `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum. Cras venenatis euismod malesuada. Fusce tincidunt, nunc sit amet blandit venenatis, turpis erat varius mauris, at cursus mi orci eget sapien. Sed a massa ac urna cursus sagittis. Maecenas tempor, ligula vitae hendrerit dapibus, lorem velit laoreet massa, ut bibendum sapien sapien nec tortor. Phasellus vel tellus arcu. Integer non rhoncus urna, nec fermentum sem. Pellentesque ac velit id nulla mollis interdum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.` + '</p></div>',
              icon: 'info',
              width: '1400px'
            })" class="text-blue-500 ml-2 cursor-pointer">(xem thêm)</button>
          </td>
          <td class="py-3 text-gray-800">Công Nghệ</td>
          <td class="py-3 text-gray-800">Nguyễn Văn BB</td>
          <td class="py-3"><span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Đã Duyệt</span></td>
          <td class="py-3 text-gray-800">999</td>
          <td class="py-3 text-gray-800">Admin22</td>
            <td class="py-3 text-gray-800">2025-02-15 08:34</td>
          <td class="py-3 space-x-2">
            <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Sửa</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">Xóa</button>
          </td>
        </tr>

      </tbody>
    </table>
  </div>
</body>
</html>
