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


-----------------------------------




