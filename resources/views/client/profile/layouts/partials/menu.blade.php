<div class="col-md-3">
    <div class="profile-sidebar">

        <div class="profile-userpic">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmL71aTMDWIHF3HD3VfThy3iT7vnbMt2w2jA&s"
                 width="50" height="50" class="img-responsive" alt="">
        </div>

        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                {{ $user->username }}
            </div>
            <div class="profile-usertitle-job">
                Người Dùng
            </div>
        </div>

        <form id="upgradeForm" action="{{ route('user.upgrade') }}" method="POST" enctype="multipart/form-data"
              style="display: none;">
            @csrf
        </form>

        <button id="upgradeButton" type="button" class="btn btn-success btn-sm">Nâng Cấp Người Dùng</button>


        <script>
            document.getElementById('upgradeButton').addEventListener('click', function () {
                Swal.fire({
                    title: 'Bạn có muốn trở thành tác giả không?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('upgradeForm').submit();
                    }
                });
            });
        </script>

        <div class="profile-usermenu">
            <ul class="nav">
                <li class="active">
                    <a href="#">
                        <i class="glyphicon glyphicon-home"></i>
                        Overview </a>
                </li>

                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-bookmark"></i> Bài viết đã lưu
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-time"></i> Lịch sử
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-comment"></i> Comment
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-flag"></i> Help
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
