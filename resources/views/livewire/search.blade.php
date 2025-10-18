<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <input type="text" wire:model.live="searchTerm">
    @if (count($results) > 0)
        @foreach ($results as $post)
            <li>{{$post->title}}</li>
        @endforeach
    @endif
</div>
