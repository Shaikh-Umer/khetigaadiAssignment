<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Khetigaadi Assignment</title>
</head>

<body>
    <p>Welcome {{ $data['user_information']->first_name . ' ' . $data['user_information']->last_name }} </p>
    <p>Hello {{ $data['user']->name }}</p>
    <p>Thank You for registering please log in in using the below URL </p>
    <p> URL: {{ url('/login') }} </p>
    <p> Username: {{ $data['user']->name }}</p>
    <p> Password: {{ $data['password'] }}</p>
</body>

</html>
