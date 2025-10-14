<x-profile :sharedData="$sharedData" :avatar="$avatar">
 <div class="list-group">
    @foreach ($followers as $follow)
        <a href="/profile/{{$follow->userDoingTheFollowing->name}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follow->userDoingTheFollowing->avatar}}" />
        {{$follow->userDoingTheFollowing->name}}
        </a>
      @endforeach
 </div>
</x-profile>