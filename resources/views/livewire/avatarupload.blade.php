<form wire:submit.prevent="save" action="/manage-avatar" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input wire:model="avatar" type="file" name="avatar" required->
            @error('avatar')
                <p class="alert small alert-danger shadow-sm">{{$message}}</p>
            @enderror
        </div>
        <button class="btn btn-primary">Save</button>
</form>