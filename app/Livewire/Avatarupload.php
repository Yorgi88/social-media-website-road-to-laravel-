<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
class Avatarupload extends Component
{
    //we need to tell livewire that this includes file uploads
    use WithFileUploads;   

    public $avatar;

    public function save(){
        if (!auth()->check()) {
            # code...
            abort(403, 'Not Authorized');
        }

        //get the code from the user controller
        $user = auth()->user();
        $fileName = $user->id . '-' . uniqid() . '.jpg';
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->avatar);
        // we simply want to read the incoming image from the request

        
        $imageData = $image->cover(120, 120)->toJpeg();
        // now to actually resize the img

        Storage::disk('public')->put('user_avatars/' . $fileName, $imageData);
        // we gonna call the storage class and put in the img file, the put
        // will take two args, folder path and file name

        $oldAvatar = $user->avatar;

        $user->avatar = $fileName;
        $user->save();

        if ($oldAvatar != '/fallback-avatar.jpg') {
            # code...
            Storage::disk('public')->delete(str_replace('/storage/', "", $oldAvatar));
        }

        session()->flash('success', 'avatar uploaded');
        return $this->redirect("/manage-avatar", navigate:true);
    }

    public function render()
    {
        return view('livewire.avatarupload');
    }
}
