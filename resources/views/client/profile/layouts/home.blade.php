<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>24HNews Bài Viết</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="max-w-6xl mx-auto p-6 flex bg-white rounded-lg shadow">
        <div class="w-1/4 border-r pr-4">
          <div class="flex flex-col items-center mb-4">
            <img id="avatarImage" src="https://media.istockphoto.com/id/1288538088/vi/anh/ch%C3%A2n-dung-doanh-nh%C3%A2n-tr%E1%BA%BB-th%C3%B4ng-minh-ch%C3%A2u-%C3%A1-nh%C3%ACn-v%C3%A0o-m%C3%A1y-%E1%BA%A3nh-v%C3%A0-n%E1%BB%A5-c%C6%B0%E1%BB%9Di.jpg?s=612x612&w=0&k=20&c=x7tUzNPNFR2FFWvuBdRC5V0cu60WmTcOwq8wahnEzwo=" alt="Avatar" class="w-24 h-24 rounded-full mb-2" />
            <h2 class="font-semibold text-lg">goblin3st</h2>
            <p class="text-sm text-gray-500">Tham gia từ 2/2025</p>
            <p class="text-lg text-blue-500 font-bold">Người dùng</p>
            <button onclick="document.getElementById('upgradeDialog').classList.remove('hidden')" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Nâng cấp lên Tác giả</button>
          </div>
          <ul class="space-y-3 text-center">
            <li class="flex justify-center items-center gap-2 text-gray-700"><i class="fa fa-eye w-6"></i> <span>Thông Tin Chung</span></li>
            <li class="flex justify-center items-center gap-2 text-gray-700"><i class="fa fa-comment w-6"></i> <span>Ý kiến của bạn (0)</span></li>
            <li class="flex justify-center items-center gap-2 text-gray-700"><i class="fa fa-bookmark w-6"></i> <span>Bài Viết đã lưu(0)</span></li>
            <li class="flex justify-center items-center gap-2 text-gray-700"><i class="fa fa-eye w-6 pr-3"></i> <span>Bài Viết đã xem</span></li>
            <li class="flex justify-center items-center gap-2 text-red-500 cursor-pointer"><i class="fa fa-sign-out-alt w-6"></i> <span>Thoát</span></li>
          </ul>
        </div>

        <div class="w-3/4 pl-6">
          <h2 class="text-2xl font-semibold mb-4">Thông tin tài khoản</h2>
          <div class="space-y-4">

            <div class="flex justify-between items-center border-b pb-2">
              <span class="text-gray-700">Username</span>
              <div class="flex items-center gap-2">
                <span class="text-gray-500">Chưa có dữ liệu</span>

              </div>
            </div>
            <div class="flex justify-between items-center border-b pb-2">
                <span class="text-gray-700">Số điện thoại</span>
                <div class="flex items-center gap-2">
                  <span class="text-gray-500">Chưa có dữ liệu</span>

                </div>
              </div>
            <div class="flex justify-between items-center border-b pb-2">
              <span class="text-gray-700">Email</span>
              <div class="flex items-center gap-2">
                <span class="text-gray-500">goblin3st@gmail.com</span>

              </div>
            </div>

            <div class="flex justify-between items-center border-b pb-2">
              <span class="text-gray-700">Mật khẩu </span>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500">********</span>

                </div>

            </div>
          </div>
          <div class="border-t pt-4 text-right">
            <button onclick="document.getElementById('editDialog').classList.remove('hidden')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Sửa thông tin</button>
          </div>
        </div>
      </div>

      <!-- Dialog Edit -->
      <div id="editDialog" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 col-span-8">
        <div class="bg-white p-6 rounded-lg w-96  ">
          <h3 class="text-xl font-semibold mb-4">Sửa thông tin tài khoản</h3>
          <form class="space-y-4">
            <div>
              <label class="block text-gray-700">Ảnh đại diện</label>
              <input type="file" id="avatarFile" accept="image/*" class="w-full p-2 border border-gray-300 rounded" onchange="previewImage(event)" />
            </div>
            <div>
              <img id="editAvatarImage" src="/avatar.png" alt="Avatar Preview" class="w-24 h-24 rounded-full mt-2" />
            </div>
            <div>
              <label class="block text-gray-700">Họ tên</label>
              <input placeholder="Họ tên" class="input w-full p-2 border border-gray-300 rounded" />
            </div>
            <div>
                <label class="block text-gray-700">Số điện thoại</label>
                <input placeholder="Số điện thoại" class="input w-full p-2 border border-gray-300 rounded" />
              </div>
            <div>
              <label class="block text-gray-700">Email</label>
              <input placeholder="Email" class="input w-full p-2 border border-gray-300 rounded" />
            </div>

            <div>
              <label class="block text-gray-700">Mật khẩu</label>
              <input placeholder="Mật khẩu" type="password" class="input w-full p-2 border border-gray-300 rounded" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Lưu thông tin</button>
          </form>
          <button onclick="document.getElementById('editDialog').classList.add('hidden')" class="mt-4 text-gray-500 hover:underline">Đóng</button>
        </div>
      </div>

      <!-- Dialog Upgrade -->
      <div id="upgradeDialog" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 col-span-8">
        <div class="bg-white p-6 rounded-lg w-96">
          <h3 class="text-xl font-semibold mb-4">Nâng cấp lên Tác giả</h3>
          <form class="space-y-4" onsubmit="showApprovalMessage(event)">
            <div>
              <label class="block text-gray-700">Tên Tác giả</label>
              <input placeholder="Tên Tác giả" class="input w-full p-2 border border-gray-300 rounded" />
            </div>
            <div>
              <label class="block text-gray-700">Mô tả</label>
              <textarea placeholder="Mô tả" class="input w-full p-2 border border-gray-300 rounded"></textarea>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded w-full">Nâng cấp</button>
          </form>
          <button onclick="document.getElementById('upgradeDialog').classList.add('hidden')" class="mt-4 text-gray-500 hover:underline">Đóng</button>
        </div>
      </div>

      <!-- Approval Message -->
      <div id="approvalMessage" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-96 text-center">
          <h3 class="text-xl font-semibold mb-4">Yêu cầu của bạn đang chờ phê duyệt</h3>
          <p>Quản trị viên sẽ xem xét yêu cầu của bạn trong thời gian sớm nhất.</p>
          <button onclick="document.getElementById('approvalMessage').classList.add('hidden')" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Đóng</button>
        </div>
      </div>

      <script>
        function previewImage(event) {
          const file = event.target.files[0];
          const reader = new FileReader();
          reader.onload = function () {
            const previewImage = document.getElementById('editAvatarImage');
            previewImage.src = reader.result;
          };
          if (file) {
            reader.readAsDataURL(file);
          }
        }

        function showApprovalMessage(event) {
          event.preventDefault();
          document.getElementById('upgradeDialog').classList.add('hidden');
          document.getElementById('approvalMessage').classList.remove('hidden');
        }
      </script>
</body>
</html>
