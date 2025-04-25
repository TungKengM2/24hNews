<div class="user-profile d-block align-items-center justify-content-center mt-4 ">

    <div class="profile-pic ">
        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
            alt="User Avatar">
        <div class="profile-info">
            <h4>
                {{ Auth::check() ? Auth::user()->username : 'Guest' }}
            </h4>
        </div>
    </div>
</div>
