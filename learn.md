Lets get started, go to the routes dir and look at the web.php, 
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

similar to base urls.py in django, right?
we use this to create our routes and urls

lets create a route for "about"

Route::get('/about', function(){
    return '<h1>About Page</h1><a href="/">Link</a>';
});

Route::get('/status', function(){
    return '<h1>Status is Online, not offline</h1><a href="/about">Go to about page</a>';
});

so we can route to different urls, for example, we can route to the home page with just '/'
and so on



------------------------------

Next we are going to branch controllers
-------------------------------

we need controllers because in the real world, our views could contain various lines of code, we need to make things as clean as possible, so we create controllers#

to create controller, run tis command `php artisan make:controller ExampleController`

To see what is created find it in the app dir, in the Http dir

Now, lets create our first method in the example controller that we created

this is how it looks like: 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function aboutPage(){
        return '<h1>About Page</h1><a href="/">Link</a>';
    }

    public function status(){
        return '<h1>Status is Online, not offline</h1><a href="/about">Go to about page</a>';
    }
}

we created the methods about and status so go to the web.php in the routes dir and import the controller you created

you say : use App\Http\Controllers\ExampleController; -> in the web.php

so in the code in the web.php, use the Controller you created to point to the methods you created in the exampleController :

Route::get('/about', [ExampleController::class, "aboutPage"]);

Route::get('/status', [ExampleController::class, "status"]);

so wen we run the php artisan serve command, it works, and its cleaner



--------------------------
next we are going to learn about the view engine of laravel

-----------------------------

laravel uses the blade template engine to render html, css and possibly js in
it similar to templating in django, just that in my case, i prefer, using frontend framework like react js


Now what is a blade template engine

go to the resources dir and you will see the views dir inside and you will see welcome.blade.php

so in the views dir we need to create our own asides the default we saw:

so create about.blade.php file
we created a view template for our about
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>This is an about page, phew!</h1>

</body>
</html>

so go to the ExampleController file and configure the about view template that you created

blade is an official templating engine that comes naturally with laravel

in the blade templating, we use double curly vraces {{}} to access the php land
its like using {} single curly in react js to access the js land

so in the about blade file we created, lets try to do something dynamic:

    <p>The result of three + two is {{
        2+3}}</p>


now lets learn how to pass dynamic data from our controller into the template

but first we need to install some extensions to help autocomplete when we are using blade

so install this laravel blade snippets

now back to tis: 
now lets learn how to pass dynamic data from our controller into the template view

the view should only house the template only, so if we want to perform some operation like fetching data from the database, we need to take care of this in our controller then pass the data to our view template

so in the Example Controller file, in the aboutPage method, we want to pass data to the template

so we say: 

class ExampleController extends Controller
{
    public function aboutPage(){
        // return '<h1>About Page</h1><a href="/">Link</a>';

        $myName = 'Moses Akinmade';
        return view('about', ['name'=> $myName,
        'info'=>'online!']);
    }


So in the about.blade.php file, we display the data passed from the controller:

<p>My name is {{$name}} and i am always {{$info}}</p>

Now lets say we want to pass in multiple values, lets say an array that contains animals

how do we do it?

if we do it the initial way above we get an error, so we use a directive

in the templating view file wen you want to use display like a arry fully, use a directive

    <h2>My favorite pets are</h2>
    <p>@foreach ($allAnimal as $animal)
        <li>{{$animal}}</li>
    @endforeach</p>


next we will learn how to reduce duplication in blade

So go to the course resources and download the templates from the githib link

we will start by making use of the homeguest.html file so copy all the content and create a homepage.blade.php file and paste the content there


you need to be connected to the internet for the colors and all to show otherwise its just bare bones

next, we need to add some css to it, so from the html templates you downloaded in the course resources, look for the main.css file we will configure it here in the laravel app#
-==-=--=-=--------------

so get the main.css file, copy it and go to the laravel project, in the public dir and paste the css file there

Now in the homapage.blade template look for this:    <link rel="stylesheet" href="main.css" />

and just add a forward slash at the back of main.css

now Go to the resource dir, in the views dir, create a single-post.blade.php file

we also created the controller for it and configured the neccessary stuff in the web.php

now , to reduce duplicates, we can use include()


so, create a blade template file called header.blade.php, so in the file

copy all the header code in the homepage.blade.php file and paste it in the header blade file

Now to bring it all together, 

in the homepage.blade file, add this `@include('header')`

that includes the header

so go to the single-post blade file and do the same for the footer


-----------------------------------
CONNECTING OUR APP TO A DATABASE (?SQLite)

-----------------------------------

in the views dir, go to the blade template file of homepage.blade

change the <form action="/register" method="POST"></form> yh like that

Now go to the web.php in the routes dir and set up a route of "register"

Route::post('/register');  its a post request this time, not a get

so what we need is to create a new controller, rememeber that last time , wwe created an ExampleController ->  so now 

we need to create a UserController file , so if you remember the command, its

`php artisan make:controller UserController` so in the app dir, go inside the Http dir and you will see the controller file we just created

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(){
        return "<h2>Helllo you have registered</h2>";
    }
}

so we have created the controller, now go back to the web.php file , import the controller and say:

Route::post('/register', [UserController::class, "register"]);

----------------------

so back to the user controller that we created, when we submit the form on the ui side of things, we intend to create a new user

so in the UserController.php we say:

class UserController extends Controller
{
    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required'],
            'password' => ['required']
        ]);
        User::create($incomingFields);
        return '<h2>Registered</h2>';
    }
}
see more in the usercontroller file

the min:3 means minimum of 3 characters in the field

we update the userController further: 


class UserController extends Controller
{
    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
    
        User::create($incomingFields);
    
        return '<h2>Registered</h2>';
    }
}
----> we make the name unique as well as the email, in the database dir, look for the migrations dir

look for "create_users_table" or so and add unique(), to the name as well, then, use this command to start afresh!

`php artisan migrate:fresh`

to will refresh the database and start it afresh, for what you changed to be actually seen





we then move to our blade temolate file homepage.blade

and update the code there so that if the user is not following the rules, laravel can send an error msg to the from, 

add this right below the input filed of each field: 

              @error('email') -> this varies, from password, to username, etc
              <p class="m-0 small alert alert-danger shadow-sm">
                {{$message}}
              </p>
              @enderror



---------------------------------------

AUTHENTICATE USER /LOGIN/ LOGOUT 
---------------------------------

run the php artisan migrate:fresh

then now, we moving to kogging in feature

Now go to the header.blade.php file

change the <form></form> to <form action="/login" method="post"></form>

then under the form element, we need to add a csrf token so say...

@csrf

so go to the web.php and create the route for the /login

then go to the userController file to create the login method

    public function login(Request $request){
        $incomingFields = $request->validate([
            'login_name' => 'required',
            'login_password' => 'required'
        ]);

        if (auth()->attempt(['name' => $incomingFields['login_name'], 'password' => $incomingFields['login_password']])) {
            # code...
            $request->session()->regenerate(); --> this generates cookies,  think of it as session_id
            so every request, we send, the cookies will part of that request
            return 'Congrats';
        } else {
            # code...
            return 'Sorry';
        }
        
    }
in the ui, if we input the correct username and password, we will see congrats else, we will see sorry

but, we want to actually log the user in, perhaps we show a ui that indicates the user is truly logged in, so we use the home-logged in template, that we downloaded from the github repo
its in your downloads folder

in that ui template, we need to conditionally change the header if the user is logged in, we expect the ui to change, to the home-logged in template

so go to the header.blade file and say...

        @auth
        --> here you get the home logged in template and paste here
            @else
            --> paste the header template here, this else blogged is for if the user is a guest or if the user is not logged in
            just cut and paste the whole form tag beneath the else
            
        @endauth


we need to create a method to show the correct body content to the logged in user

go to web.php -> Route::get('/home', [UserController::class, "showCorrectHomepage"]);

and then create the method in the userController:

    public function showCorrectHomepage(){
        --> if authenticated show the home_logged view

        else: -> show the homepage view
    }


so in the blade templates, create another called homepage_logged.blade.php

and paste the necessary stuff

@include('header')

    <div class="container py-md-5 container--narrow">
      <div class="text-center">
        <h2>Hello <strong>{{auth()->user()->name}}</strong>, your feed is empty.</h2>
        <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
      </div>
    </div>

    @include('footer')




Next we are gonna see how we can allow user to logout, implement the redirect feature, Flash Messages and more



first, the log out

go to the header.blade file and find the signout btn, 
         <form action="/logout" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-sm btn-secondary">Sign Out</button>
          </form>
so create the route and the method for the logout

in the controller...

    public function logout(){
        auth()->logout();
        return 'You are now logged out';
    }

Next, we want to learn how to redirect

    public function logout(){
        auth()->logout();
        return redirect('/home');
    } ->  we use redirect ->


Next, we want to set up flash messages they are one time msgs that happen according to a request

return redirect('/home')->with('success', 'You are logged in');
the -> with is the one time flash mesaage

next, we need to tell out blade templates about this flash msgs and to display them

so go to the homepage.blade file and beneath header type in

    @if (session()->has('success'))
        <div class="container container--narrow">
            <div class="alert alert-success text-center">
                {{session('success')}}
            </div>
        </div>  
    @endif

know that we have coded the logic in the UserController ..

 return redirect('/home')->with('success', 'You are logged out');

do the same for the failure message perhaps the user got the details wrong or the account isn't in the db

Now we want a scenario where when a new user registers, we don't want to take them to back to the very /home route, instead, we want to log them in and display the Hello {{name}} view

so, in the UserController(in the register method), we say...


    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
    
        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/home')->with('success', 'Account Created!');
    }


at the footer.blade file 
lets make the year part dynamic, 

so go do that -> see footer.blade.php



------------------------------
Blog Posts
enabling users to create blogs
----------------------

go to the web.php and create the route 

---Route::get('/create-post', [PostController::class, "showCreatePost"]);
and we will need to create a blog post controller -> so do that with the command

so next in the postController, 

create the method -> see the PostController

then in the header.blade file, change the anchor tag of create post '#' to 'create-post'

lets go to the Pc download folder and get the template needed

also, create a blade template file:  create-post.blade.php

so go to the Downloads folder and get the create-post template,, we copied the required piece to the create-post.blade file -> look at it

now in the blade template update the form elem to : <form action="/create-post" method="POST">
remember when you are performing a post req, always add @csrf beneath the form
now create the method and the route

up untill now, we stored the users in the database, remember  we did not create the users db, laravel did it for us, so now we want to create a table to store the blog post

so in order to do thzt: we need to create a Model, to keep track of the users that created the post, id, title_of_post, body_of_post and so on

so to create a new table type this `php artisan make:migration create_post_table`

so go to the database dir, and inside it -> migrations dir and you will see the file

so in the create post file, we see: 

{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->longText('body');
            // now next is a column that keeps track of user that created the post
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;

            this is like one to many relationship, i guess
        });
    }

to make this actually take effect in the database, 
we run in the terminal: `php artisan migrate`

next in the postController -> we write the logic for it

see -> PostController.php

class PostController extends Controller
{
    public function showCreatePost(){
        return view('create-post');
    }

    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // we want to strip out any html tag an attacker might take advantage of
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $incomingFields['user_id'] = auth()->id();  //to get the userid of the poster
    }
}


next we create a Model in the Models dir called Posts.php or we use the command

`php artisan make:model Post`

next, we still in our PostController -> lets see how we save the entry into the database

so in the Controller add this to the storeNewPost method

Post::create($incomingFields); -> don't forget to import it

then in the Post -> in the Models dir, add this

 protected $fillable = ['title', 'body', 'user_id'];

 we ran into an error sayin posts table does not exist -> 

 in our create_post file in the database->migrations dir go that file and change post -> posts

 then run php artisan migrate:fresh to start all over ##we can re-populate  the db again

 ---- Next, in the create-post blade file, we want to improve user experience, so
 in the file, -->  <input value="{{old('title')}}" do the same for the body

 next, set up the error msgs 

               @error('name')
                  <p class="m-0 small alert alert-danger shadow-sm">
                    {{$message}}
                  </p>
              @enderror


Next, it will make more sense to redirect the user to the new url of the new post

so lets commence -> go to the web.php and add -> Route::get('/post/{post}', [PostController::class, "getPost"]);

so go to the PostController file and make the method -> see PostController

next we need to get the template, its in single-post.blade file

next, how do we load the appropriate data from the db

    public function getUserPost(Post $post){
        return $post->title;
        return view('single-post');
       
    }

we wil pass in an argument, to get the appropriate user posts

sp in the web.php it ill be like post/{post} -> tis is the arg

the above getUserPost method in the arg passed -> tis is known as type hinting

that $post in the arg is referring to the -
-> Route::get('/post/{post}', [PostController::class, "getUserPost"]);

its referring to the {post} here in the web.php -> they must match!

Now lets pass the blog post data into our blade view

-> so we say -> return view('single-post', ['post' => $post]);

so go the matching blade template html file

'single-page' and update accordingly

passing the blogger's name to the template can be tricky so lets start

in the Post.php which is in the models, create a method and say:: 

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

so in the blade-template file -> we say $post->user->name <= pointing to the user function
that we created in the Post model>

for the dynamic date:  {{$post->created_at->format('n/j/Y')}}

for the body: {{$post->body}}

Next we want to add redirect, so when the user creates a post the user gets redirected to the post he/she created

so go to the PostController, in the method: storeNewPost

return redirect("/post/{$newPost->id}")->with('success', 'post created successfully');


Next is msrkdown format for the body of the post

Think of markdown as text edit -> If we are able to implement this feature, we will be able to bold, italicize, adle to add paragraph and so on, in our body

so to start, go to the post controller file and add some code in the getUserPost method

 $post = ['body'] = Str::markdown($post->body);, //so when we enclose a text in double astrisk, we tell the markdown to bold our text for us and so on

 so go to the single-post blade template file and change the {{}} dynamic post body to ->

 <p>{!! $post->body !!}</p>


 Next, we want to only allow logged in users to view the create post page, also if a user clicks on the create post btn, we should check if the user to authenticated or not, if not, we probably redirect the user to the register field page and also Protect the Routes created, so even if a user copies an authenticated route link, if the user is not authd, the page won't display still.

 Before we do that, lets find out what a MiddleWare is -> 

 A middleware is like a bridge in between applications or systems that facilitates communication
 for example if a guest user is passing a bridge for only authd users the bridge won't allow the guest user to pass -> have that analogy

So go to the web.php file in the PostController route, the one with -> 

'showCreatePost'

add the middleware to it

Route::get('/create-post', [PostController::class, "showCreatePost"])->middleware('auth');

then name the /home route as 'login', -> see the web.php file

 we can create our own custom MiddleWare with the command `php artisan make:middleware <middleware name>`

 so in the middleware file that we created, we can customize

 <?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if (auth()->check()) {
        # code...
         return $next($request);
       }
       return redirect('/home')->with('failure', 'you must be logged in');
    }
}


-> next go to the bootstrap dir, in the app.php file 
add this in the middleware section

        $middleware->alias([
            'mustBeloggedIn' => \App\Http\Middleware\MustBeLoggedIn::class
        ]);

now we use the name mustBeloggedIn to access out ==r middleware

so to test, go to the web.php, in the showCreatePost route change the middleware from ->middleware('auth) to middleware('mustBeloggedIn)

we see it works

------------
Next is the user profile page, we can click on the user icon and we can see all the blog post the user has created so far, lets implement the feature

So lets start creating the routes for it, in the web.php -> go there and create the route
Route::get('/profile/{user:name}', [UserController::class, "userProfile"]);
/profile/bob/<userid>

next create the method in the UserController::userProfile

next we need the view template, so create the blade file profile-posts.blade.php

next we get the template for the user profile page, so go to the Downloads folder on your pc and locate the html templates ->prodile-posts.html


next, go to the header.blade file -> and change the anchor tag around the profile icon

          <a href="/profile/{{auth()->user()->name}}" class="mr-2"><img title="My Profile" data-toggle="tooltip" data-placement="bottom" style="width: 32px; height: 32px; border-radius: 16px" src="https://gravatar.com/avatar/f64fc44c03a8a7eb1d52502950879659?s=128" /></a>

in the profile-posts blade file, we want to change somethings and make them dynamic -> see the file



we need to access the user in the database and the user's blogpost in the db

so in the user controller file we use type hinting in the userProfile method

    public function userProfile(User $user){
        return view('profile-posts', ['name' => $user->name]);
    }

so, now lets fetch all the posts dynamic for the specific user

next we go to the User.php file in the Models dir and add a method

    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
        -> signifies that a user can have many posts, and the user_id is the lookup or the unique identifier

        the user_id is gotten from the Post class, see ->Post.php

    }

Now go back to the user controller file and update the user controller method

    public function userProfile(User $user){
        $getUserPost = $user->posts()->latest()->get();
        return view('profile-posts', ['name' => $user->name, 'posts' => $getUserPost]);
    }

next we move on to the profile-posts blade template file and updatee the html

-> see profile-posts.blade.php

so lets create the post count, the number of posts created is displayed in the ui, so lets also make that dynamic

so, in our user controller we say -> see the userProfile method



---------------

Next we want to allow the users who created the posts to be able to update or delete the posts
but they can't get permission to do so for another user except themselves

we'll use something called a POLICY in laravel

think of a policy in terms of memoization, it a write once, use anywhere else in the application kind of thing

lets setup a policy to allow a user to be able to edit and delete his own post only

no other user except the user can do that

so go to the terminal create a policy with a command -> 
`php artisan make:policy PostPolicy --model=Post` -> be mindful of naming conventions in laravel
this command is tied to the Post model

so in this file, we will be able to code the policy, eg only the very user can edit or delete his own post

You can check your policy in the Routes method, or in the controller method, or from the blade template angle

so in the post policy file

add this to the update method and delete method for now -> return $user->id === $post->user_id;

now how do we actually leverage the post policy

now go to single-post blade template 

wrap the span element in the can, endcan check

so what happens, remember we are logged in in chrome browser, so we can edit and delete, 
now paste the link in the chrome browser and go to firefox browser and paste the link

we don't see the edit and delete feature since we are unauthorized user using another browser

that's the power of policy in laravel

now lets try to delete functionality from our PostController 

so create a method called deletePost and then write the logic, when donec, go to web.php to create the route

    public function deletePost(Post $post){
        if (auth()->user()->cannot('delete', $post)) {
            # code...
            return 'You cannot delete it';
        }
        $post->delete();
        return redirect('/profile/' . auth()->user()->name)->with('success', 'post deleted');
        -> this checks if the user is authd, therefore the post can be deleted by the user
    }

so next go to the single-post blade file and make changes to the delete icon btn -> see the file

        @can('update', $post)
        <span class="pt-2">
          <a href="#" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
          <form class="delete-post-form d-inline" action="/post/{{$post->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </span>
        @endcan


next, how we can use policy from routes file with middleware instead

-> policy middleware

How to implement? so back to your post controller file

    public function deletePost(Post $post){
        if (auth()->user()->cannot('delete', $post)) {
            # code...
            return 'You cannot delete it';
        } 
        $post->delete();
        return redirect('/profile/' . auth()->user()->name)->with('success', 'post deleted');
        -> this checks if the user is authd, therefore the post can be deleted by the user
    }

-> delete the if block only, then go to the web.php and say 

Route::delete('/post/{post}', [PostController::class, "deletePost"])->middleware('can:delete,post');

-> means an unauthorized user cannot delete the post except the authorized user

slick!

Now to the edit text feature

How it should work, when a user clicks on the edit button, the user will be taken to the title and body page where the user will be able to edit both

so set up a blade template for this -> lets call it edit-post.blade.php
# copy the content in the create-post template

now in the edit-post file, we need to make a few changes -> 

we'll need to fetch the title and body from the database into the edit-post file

      <form action="/post/{{$post->id}}" method="POST">
        @method('PUT')
         @csrf
<input value="{{old('title', $post->tittle)}}"
the same for the textarea element 

next we go into our routes file and add this ->

Route::get('/post/{post}/edit', [PostController::class, "viewEditForm"])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, "saveEdit"])->middleware('can:update,post');

the first route is for viewing the post to be changed, the second route is for actually saving the changes

next create the methods for each route in the post controller so go do that ->

    public function viewEditForm(Post $post){
        return view('edit-post', ['post' => $post]);
    }


    public function saveEdit(Post $post, Request $request){
        // we need to things, the $post value arg and the incoming request
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $post->update($incomingFields);

        return back()->with('success', 'saved changes');
        // the back just means return the user to the previous route the user was before, 
        // the user was taken to this route
    }
next go to the single-post template file and add the route in the form elem

in the edit-post blade file, we want to add a new btn that says, 'Go back'
so when the btn is clicked, we return the user to the previous route


----------------
ADMIN
----------------

--> Next let move on to creating an admin that governs the whole user post, think of this as superuser in django, the admin will have all sorts of privileges -> A Moderator

they will have permission to delete or update anyone's posts

the trick is to find a user and make that user an admin lets say the mod is Robb Stark

SO IN OUR terminal, run the command `php artisan make:migration add_is_admin_to_users_table --table=users`

Twill create a file so goto the database->migrations dir and look for it

in the up method -> add the code: return $table->boolean('isAdmin')->default(0);
and in the down method add ->  return $table->dropColumn('isAdmin');

then in the command, run `php artisan migrate` to make changes

Now lets set Robb Stark to be an admin

-> go into your PostPolicy file and make that change

in the update method, write the code logic there

        if ($user->isAdmin === 1) {
            # code...
            return true;
        }
-> paste it in the delete method too

go to the DB browser for SQLite application, install it if you haven't and 
in the isAdmin column for ronn stark, change the isAdmin from 0 -> 1

save it and test the app in laravel

so yh as an admin Robb Stark can update and delete Bob posts, try it out in firefox

copy the Bob user posts url in the firefox browser where robb stark is logged in , you will see you can edit or delete Bob posts


-> Next we want to set up special urls that only admin can access and also allow user to change their avatar


set up a route(admin-only) and method

Route::get('/admin-only', function(){
    return 'Admin only';
});

go to your app dir, then inside, look for providers dir and enter the file in the provider dir to make some changes

you will see a method named boot 

    public function boot(): void
    {
        Gate::define('visitAdminPages', function($user){
            if ( $user->isAdmin === 1) {
                # code...
                return true;
            }
            return '<h2>Only for admins</h2>'
            
        });
    }
Now how do we make sure only the admin (robb stark) can access the route and no one else can

lets use the controller way, after we use the route way

so go to the web.php and say: 

Route::get('/admin-only', function(){
    if (Gate::allows('visitAdminPages')) {
        # code...
        return '<h2>Only admins can view this</h2>';
    }
    return  '<h2>Your not an admin</h2>';
});

now lets use a middleware within our route to achieve the same thing

Route::get('/admin-only', function(){
    return '<h2>Only Admins Can view This</h2>';
})->middleware('can:visitAdminPages');


--> Next we want mo move on with the change avatar feature where user can upload a different avatar of their choice

lets add a change -avatar btn in the user profile page

in the profile-posts blade file
under the first form element, we check if the authenticated username == username

          @if (auth()->user()->name == $name)
              <a href="/manage-avatar" class="btn btn-secondary btn-sm">Manage Avatar</a>
          @endif
<!-- we set up a route for the manage-avatar link -->
Route::get('/manage-avatar', [UserController::class, "showAvatarForm"]);

create an avatar-form.blade.php file and in the file write

@include('header')

<div class="container container--narrow py-md-5">
    <h2 class="text-center mb-3">Upload New Avatar</h2>
    <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
    <!-- wen dealing with file, you need to add enctype -->
        @csrf
        <div class="mb-3">
            <input type="file" name="avatar" required>
            @error('avatar')
                <p class="alert small alert-danger shadow-sm">{{$message}}</p>
            @enderror
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>

@include('footer')

Route::post('/manage-avatar', [UserController::class, "storeAvatar"]);
<!-- we set up a post request for this file upload this time -->


go to the user controller and create the method

in the method, we wanna actually store the user's avatar

    public function storeAvatar(Request $request){
        // in the avatar-form, remember in the input field, we added a name 'avatar'
        // so we will use that 
        $request->file('avatar')->store('user_avatars', 'public'); //the store() signifies where the img will be stored locally
        //check the storage dir -> app dir -> public dir -> you'd see user_avatars dir

        // but that's local, if we want to store the avatars where it will be available persistently,
        // there's a public dir in the laravel project, 

        so if we want to save our avatars in the public dir, not in the storage dir, 
        we first need to run the commannd `php artisan storage:link`

        what does this command do? Remember we created a local dir store('user_avatars', public);
        this creates a dir user_avatars in the storage -> app -> public/ dir
        so in the public dir, we see a dir called user_avatars
    
        `php artisan storage:link` running this command links up what's in that storage/app/public/user_avatars dir -> to the base public dir that's in the laravel project

        sounds confusing , i know

        the command links the public dir command in the storage /app / public dir



        return '<h1>Uploaded!</h1>';
    }


in laravel,if we upload an image more than 2mb, we get an error, so lets fix that
actually, this has nothing to do with laravel, but with php we need to configure stuff to allow more than 2mb file uploads

so go to the php folder in your C drive , then look for php.ini and configure it

in the php ini file, look for: upload_max_filesize, and change it from 2M to 8M

save it, then restart your laravel server


-----------------------------
File Re-sizing on the server side

when we upload a file to our server, we just don't want to store a 5mb file, we should be able to compress this file before we actually store it on our server
------------------------------

but first, protect the route for the avatar routes using middleware

next we want to validate the file that the user needs to upload to change avatar
it-> must be an image

so in the UserController, in the storeAvatar method change ->

        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);
        $request->file('avatar')->store('user_avatars', 'public'); 
        return '<h1>Uploaded!</h1>';

this code means we are more selective now, the img field is required and the img mustn't exceed 3 mb

Now lets learn how to resize the img

we will need to install a package from composer

`composer require intervention/image`

now lets refactor the code in our storeAvatar method in the user controller, AGAIN!

     $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);
        // $request->file('avatar')->store('user_avatars', 'public'); 
        $user = auth()->user();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('avatar'));
        // we simply want to read the incoming image from the request
        $imageData = $image->cover(120, 120)->toJpeg();
        // now to actually resize the img

        Storage::disk('public')->put('user_avatars/');
        // we gonna call the storage class and put in the img file, the put
        // will take two args, folder path and file name
        return '<h1>Uploaded!</h1>';
    }


go through the code carefully and try to understand, for we are not done

--> lets try to save it to our database
we need to create a table 'avatar' in our database first, so rin the command:

`php artisan make:migration add_avatar_to_users_table --table=users`

this creates a column called avatar, where we can store the user avatar
go to the said file: add_avatar_to_users_table

and write some code

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }

go to the user.php in the models dir and add 'avatar' to the fillable

also, we want to make sure when the user chnages their avatar, it actually changes in the ui

so go to header.blade.php file

          <a href="/profile/{{auth()->user()->name}}" class="mr-2"><img title="My Profile" data-toggle="tooltip" data-placement="bottom" style="width: 32px; height: 32px; border-radius: 16px" src="/storage/user_avatars/{{auth()->user()->avatar}}" /></a>
we changed the src part

Now we want to make the user avatar, appear in all areas of the user's app, we also want a default avatar in place if the user hasn't uploaded any avatar yet

we want to make this avatar change persistent

so go the User.php file, we are gonna use an accessor

    protected function avatar(): Attribute {
        return Attribute::make(get: function($value){
            // lets filter what the incoming value of avatar is to be
            // so we say if the user's avatar field is null, use a default image
            return $value ? '/storage/user_avatars/' . $value : 'fallback-avatar.jpg';
        });
    }
so if the user has not avatar uploaded, we use the fallback-avatar image instead

so we put our fallback-avatar.jpg in the public dir in the laravel project

so go to header.blade file and say

          <a href="/profile/{{auth()->user()->name}}" class="mr-2"><img title="My Profile" data-toggle="tooltip" data-placement="bottom" style="width: 32px; height: 32px; border-radius: 16px" src="{{auth()->user()->avatar}}" /></a>


go to the profile-posts.blade file and adjust accordingly as well

---------------------------------

USER FOLLOW ANOTHER USER FEATURE

------------------------------------

--> How do we store that relationship
we create a follows table -> one column signifies the user doing the following - another column signifies the user_id of the user being followed


->> lets create more users, Kyle and Vera and Sean first

So run the command `php artisan make:migration create_follows_table`

go and find the file in the migrations dir and add some code

    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();  //the user doing the following

            $table->unsignedBigInteger('followeduser'); //repr the user being followed
            $table->foreign('followeduser')->references('id')->on('users'); //repr the user being followed
            $table->timestamps();
        });
    }

now save changes running the `php artisan migrate`

now lets create the route and the method for this feature

go to the web.php and make the route
Route::post('/create-follow/{user:name}', [FollowController::class, "followUser"])->middleware('auth');

duplicate the route for unfollowing user
Route::post('/remove-follow/{user:name}', [FollowController::class, "unFollowUser"]);



-> lets create a FollowController use the command 
`php artisan make:controller FollowController`

import it in the web.php

next go to the Follow Controller file and start coding up the logic
    public function followUser(User $user){
        //u cannot follow yourself, 
        //u cannot follow someone you're already following
        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followedid = $user->id;
        $newFollow->save();
    }

--> go to the profile-post blade template and make some changes in the form elements

-> we need a Follow Model so go create one

`php artisan make:model Follow`



-> next we want an unfollow feature, if the user is already following another user, then there's no need for the follow btn to show, only the unfollow btn should show

-> go to the user controller -> in the userProfile method, pass something to the frontend

    public function userProfile(User $user){
        $isFollow = 0;
        if (auth()->check()) {
            # code...
            $isFollow = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        };
       
        $getUserPost = $user->posts()->latest()->get();
        $postCount = $user->posts()->count();
        return view('profile-posts', ['name' => $user->name, 'posts' => $getUserPost, 'postCount'=> $postCount, 'avatar' => $user->avatar, 'isFollow' => $isFollow]);
    }

so, go to the profile-post blade template and make the change

      <h2>
        <img class="avatar-small" src="{{$avatar}}" /> {{$name}}
        @auth
          @if (!$isFollow AND auth()->user()->name != $name)
            <form class="ml-2 d-inline" action="/create-follow/{{$name}}" method="POST">
              @csrf
              <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
          <!-- <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> -->
 
            </form>
          @endif

          @if ($isFollow)
            <form class="ml-2 d-inline" action="/remove-follow/{{$name}}" method="POST">
              @csrf
              <<button class="btn btn-danger btn-sm">Unfollow<i class="fas fa-user-times"></i></button>

          </form>
        @endif
   -        @if (auth()->user()->name == $name)
              <a href="/manage-avatar" class="btn btn-secondary btn-sm">Manage Avatar</a>
            @endif
        @endauth

      </h2

we have tow outer if blocks-> we check if the user is not being followed, then lets the follow button appear

if the user is being followed(if($isFollow)), let the unfollow btn to appear


-> so next lets actually implement the unfollow feature, go to the FollowController

next - we want to make an easy fix, the follow btn should not appear on our own account or the unfollow

for example, if you're bob, then in your profile you should not see those btns

go to profile-posts blade file and change: @if (!$isFollow AND auth()->user()->name != $name)


-> Next we want the follow count to show
for example is bob is following 2 people under the following tab, we should see 2

and if bob has 3 followers, we should see 3 under the followers tab

we wanto be be able to view the followers as well , so lets do that

-> Go to the profile-posts blade file and copy its content

paste it in a new file called profile.blade.php

next we created a layouts dir and innit, a app.blade template dir,-> look at it, its self-explanatory

--> now back to the feature we want to implement

create a route in the web.php file

Route::get('/profile/{user:name}/followers', [UserController::class, "userFollwers"]);
Route::get('/profile/{user:name}/following', [UserController::class, "userFollowing"]);

next, we set up the methods for each in the user controller file


   public function userFollowers(User $user){
        $isFollow = 0;
        if (auth()->check()) {
            # code...
            $isFollow = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        };
       
        $getUserPost = $user->posts()->latest()->get();
        $postCount = $user->posts()->count();
        return view('profile-followers', ['name' => $user->name, 'posts' => $getUserPost, 'postCount'=> $postCount, 'avatar' => $user->avatar, 'isFollow' => $isFollow]);
    }

    public function userFollowing(User $user){
        $isFollow = 0;
        if (auth()->check()) {
            # code...
            $isFollow = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        };
       
        $getUserPost = $user->posts()->latest()->get();
        $postCount = $user->posts()->count();
        return view('profile-following', ['name' => $user->name, 'posts' => $getUserPost, 'postCount'=> $postCount, 'avatar' => $user->avatar, 'isFollow' => $isFollow]);
    }

    --> so create the view, profile-followers and profile-following

next go to the profile-blade file and make some changes

--> i went to the userController and made some changes, in the userProfile method, i changed the view from profile-posts to profile.blade.php, the mistake i made from the very beginning was that i should have used components based styling and structuring using <x-layouts>

and i don't want to refactor, maybe in the future --> `actually we did refactor the codes in the templates, using the <x-> component, take a look at it`

now lets go to the profile balde file

where you have a anchor tags , that point to the Posts, Following, Follwers

      <div class="profile-nav nav nav-tabs pt-2 mb-4">
        <a href="/view-post/{{$name}}" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "" ? "active" : ""}}">Posts: {{$postCount}}</a>
        <a href="/profile/{{$name}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "followers" ? "active" : ""}}">Followers: 3</a>
        <a href="/profile/{{$name}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "following" ? "active" : ""}}">Following: 2</a>
      </div>
The request segment signifies the routes, eg profile/Bob/followers, that's 3 segments
so if the third segment = followers, it should route to the followers tab, if its following, it should take us to the following tabe, else, we are still in the user posts tab



next in the UserController, we want to refactor some code
--> look at it the file
we created a private function getSharedData, 
this data houses all our templates will need
this function affects the userProfile method, userFollowers and userFollowing metthod



`something happened while we were building, i kept getting the undefined variable name called avatar --error, so i tried to fix it, in the private method called getSharedData in the UserController, we removed the avatar data from it and made it standalone, so we passed in the avatar data in the userProfile, userFollowing and userFollowers method , in the view templates, we passed in the avatar data in the profile-posts, profile-following and profile-followers views `

-------------------
-> lets create a relationship between a a user and Follow, previouly we created a relationship beetween user and posts in the User.php file

    public function followers(){
        return $this->hasMany(Follow::class, 'followeduser');
        //a user can have many followers
    }

    public function followingTheseUsers(){
        return $this->hasMany(Follow::class, 'user_id');
        //returns whoever the user is following, can be many too
    }

-> also lets quickly look at the Follow.php model we created

-> take a look at the code there, here it is below
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function userDoingTheFollowing(){
        return $this->belongsTo(User::class, 'user_id');
        //the user doing the following
    }

    public function userBeingFollowed(){
        return $this->belongsTo(User::class, 'followeduser');
        // the user being followed
    }
}
-------------------

Follow::create([
    'user_id' => 5,          // John
    'followeduser' => 2,     // Sarah
]);
 from tis analogy, John is following Sarah, the user doing the following

 Sarah is the user being followed

 -> in the User.php we connect to the Follow model


-- in the User.php lets explain the method called followers

🔍 What this means:

Each user can have many Follow records where that user is the one being followed.

In the follows table, those records have the followeduser column equal to the user’s id.

Example:

If $user->id = 8,
Laravel will fetch all rows where followeduser = 8.


Next in the followingTheseUsers method
--------

What this means:

Each user can have many Follow records where that user is the one doing the following.

In the follows table, those records have the user_id column equal to the user’s id.


in other words let me explain in SIMPLE TERMS

A USER CAN HAVE MANY FOLLOWERS AND THAT VERY USER CAN PERFORM FOLLOWING TO OTHER USERS AS MANY AS THE USER WANTS


Now back to our UserController, 

in the userFollowers method-> 

    public function userFollowers(User $user){
       
        // $getUserPost = $user->posts()->latest()->get();
        // // return view('profile-followers', ['name' => $user->name, 'posts' => $getUserPost, 'postCount'=> $postCount, 'avatar' => $user->avatar, 'isFollow' => $isFollow]);
        // $getUserPost = $user->posts()->latest()->get();
        $this->getSharedData($user);
        return view('profile-followers', ['followers' => $user->followers()->latest()->get(), 'avatar'=> $user->avatar]);
    }

--> We are going to code the logic of the user following method, so go to the user controller and do so

    public function userFollowing(User $user){

        
        // $getUserPost = $user->posts()->latest()->get();
        $this->getSharedData($user);
        return view('profile-following', ['posts' => $user->posts()->latest()->get(), 'avatar'=> $user->avatar, 'following' => $user->followingTheseUsers()->latest()->get()]);

    }
Now go into the profile-following blade file and do the needful

-> see the profile-following blade file

-> next, we want to make the count dynamic, if the user has 4 followers and 2 following, the count should reflect that

-> go to the user controller file and add it in the private getSharedData method


so go to the profile-blade file

       <a href="/profile/{{$sharedData['name']}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "followers" ? "active" : ""}}">Followers: {{$sharedData['followerCount']}}</a>
        <a href="/profile/{{$sharedData['name']}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "following" ? "active" : ""}}">Following: {{$sharedData['followingCount']}}</a>

#
Next -> lers build out the homepage feed, in the homepage you should see the posts of the users you follow

laravel can just give us the exact stuff we need to implement this feature

we begin by the frame of reference "the user" or at least the user model

go to the user.php model file

    public function feedPosts(){
        return $this->hasManyThrough(
            
        );
        # we will give it 6 argumants
        first -> is the model we want to end up with, in this blog posts
        ssecond -> is the follow class
        third is the foreign key -> the user doing the following ('user_id)
        fourth is the foreign key of the post model (user_id)
        the fifth is the local User model -> if, the very user id,
        sixth-> local key on the intermediate table -> the user being followed

    }

next we go to the user controller in the showCorrectHomePage method we add:

return view('homepage_logged', ['postFeed' => auth()->user()->feedPosts()->latest()->get()]);

so go to the homepage-logged blade file

we used unless there 
think of it this way, show the other users posts that the user is following
unless there is no posts to show
->  see the file


next -> in the homepage feed, we want to show the author, name of the blogposts and so

so in the homepage-logged blade file

next we added a feature in the single post blade file

we added a link up in the anchor tag to direct the user to the profile of the one that has the posts

see the file


--> Next we will learn how to add pagination in our homepage feed





















