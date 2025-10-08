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





















