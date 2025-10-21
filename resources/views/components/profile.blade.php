<x-layout :doctitle="$doctitle">
    <div class="container py-md-5 container--narrow">
      <h2>
        <img class="avatar-small" src="{{$avatar}}" /> {{$sharedData['name']}}
        @auth
          @if (!$sharedData['isFollow'] AND auth()->user()->name != $sharedData['name'])
            <form class="ml-2 d-inline" action="/create-follow/{{$sharedData['name']}}" method="POST">
              @csrf
              <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
          <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
            </form>
          @endif

          @if ($sharedData['isFollow'])
            <form class="ml-2 d-inline" action="/remove-follow/{{$sharedData['name']}}" method="POST">
              @csrf
              <button class="btn btn-danger btn-sm">Unfollow<i class="fas fa-user-times"></i></button>
          </form>
        @endif
            @if (auth()->user()->name == $sharedData['name'])
              <a href="/manage-avatar" class="btn btn-secondary btn-sm">Manage Avatar</a>
            @endif
        @endauth

      </h2>

      <div class="profile-nav nav nav-tabs pt-2 mb-4">
        <a wire:navigate href="/profile/{{$sharedData['name']}}" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "" ? "active" : ""}}">Posts: {{$sharedData['postCount']}}</a>
        <a wire:navigate href="/profile/{{$sharedData['name']}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "followers" ? "active" : ""}}">Followers: {{$sharedData['followerCount']}}</a>
        <a wire:navigate href="/profile/{{$sharedData['name']}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "following" ? "active" : ""}}">Following: {{$sharedData['followingCount']}}</a>
      </div>

      <div class="profile-slot-content">
        {{$slot}}
      </div>
  </div>
</x-layout>



