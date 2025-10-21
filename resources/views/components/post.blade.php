<a wire:navigate href="/post/{{$post->id}}" class="list-group-item list-group-item-action">
    <img class="avatar-tiny" src="{{$post->user->avatar}}" />
    <strong>{{$post->title}}</strong>
    <span class="text-muted"> 
        @if (!isset($hideAuthor))
            By {{$post->user->name}} 
        @endif
          
        {{-- we want tis part to be optional --}}
        on {{$post->created_at->format('n/j/Y')}}
    </span> 
</a>