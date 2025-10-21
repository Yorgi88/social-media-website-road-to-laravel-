<form wire:submit="unfollow" class="ml-2 d-inline" action="/remove-follow/{{$sharedData['name']}}" method="POST">
    @csrf
    <button class="btn btn-danger btn-sm">Unfollow<i class="fas fa-user-times"></i></button>
</form>