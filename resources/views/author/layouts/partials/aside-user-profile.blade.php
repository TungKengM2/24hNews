<div class="user-profile">
    <div class="profile-pic">
        <img src="{{ asset('storage/' . $avatar) }}" alt="user">
        <div class="profile-info">
            <h4>{{ $username }}</h4>
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
