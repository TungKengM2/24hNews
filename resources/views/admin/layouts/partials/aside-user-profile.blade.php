<div class="user-profile">
    <div class="profile-pic">
        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
            alt="User Avatar">
        <div class="profile-info">
            <h4>
                {{ Auth::check() ? Auth::user()->username : 'Guest' }}
            </h4>
        </div>
    </div>
</div>
