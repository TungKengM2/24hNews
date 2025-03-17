<div class="user-profile">
    <div class="profile-pic">
        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : '/admin/main/../images/user3-128x128.jpg' }}"
            alt="User Avatar">
        <div class="profile-info">
            <h4>
                {{ Auth::check() ? Auth::user()->username : 'Guest' }}
            </h4>
            <div class="list-icons-item dropdown">
                <a href="index.html#" class="list-icons-item dropdown-toggle" data-bs-toggle="dropdown"><span
                        class="badge badge-ring fill badge-primary mx-2"></span>Online</a>
                <div class="dropdown-menu">
                    <a href="index.html#" class="dropdown-item">Update data</a>
                    <a href="index.html#" class="dropdown-item">Detailed log</a>
                    <a href="index.html#" class="dropdown-item">Statistics</a>
                    <a href="index.html#" class="dropdown-item">Clear list</a>
                </div>
            </div>
        </div>
    </div>
</div>
