<div class="container">
  <h1 class="">Welcome back, {{$user->name}}!</h1>
  <div class="userBanner mb-3">
    <img class="profilePicture"
      src="{{ $user->profilePicture ? asset('assets/profile_pictures/' . $user->profilePicture) : 'https://via.placeholder.com/150' }}"
      alt="profile">
    <span>
      <h4 class="m-0">{{ $user->name }}</h4>
      <span>
        <small>ID: {{ $user->ic }}</small>
      </span>
    </span>
  </div>

</div>