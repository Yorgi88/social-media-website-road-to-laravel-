<x-profile :sharedData="$sharedData" :avatar="$avatar" doctitle="{{$sharedData['name']}}'s Profile">
 <div class="list-group">
    @foreach ($posts as $post)
        <x-post :post="$post" hideAuthor/>
    @endforeach
 </div>
</x-profile>