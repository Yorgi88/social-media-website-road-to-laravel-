<x-profile :sharedData="$sharedData" :avatar="$avatar">
 <div class="list-group">
    @foreach ($following as $follow)
        <a href="/profile/{{$follow->userBeingFollowed->name}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follow->userBeingFollowed->avatar}}" />
          {{$follow->userBeingFollowed->name}}
        </a>
      @endforeach
 </div>
</x-profile>