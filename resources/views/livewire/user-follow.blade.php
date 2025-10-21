<form wire:submit="follow" class="ml-2 d-inline" action="/create-follow/{{$sharedData['name']}}" method="POST">
    @csrf
    <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
<!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
</form>