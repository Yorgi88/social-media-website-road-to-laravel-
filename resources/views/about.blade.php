<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>This is an about page, phew!</h1>
    <p>My name is {{$name}} and i am always {{$info}} </p>

    <h2>My favorite pets are</h2>
    <p>@foreach ($allAnimal as $animal)
        <li>{{$animal}}</li>
    @endforeach</p>
    <a href="/">Go to Home!</a>

    <p>The result of three + two is {{
        2+3}}</p>
</body>
</html>