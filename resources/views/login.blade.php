@extends('home')

@section('style')
    <style>
        .error {
            color: #FF0000;
        }
    </style>
@endsection

@section('content')
    <br>
    <h1 class="text-center">LOGIN</h1>
    <br>
    <form id="login" method="POST" action="{{ url('user/login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="reset" class="btn btn-warning">Reset</button>
        </div>
    </form>
@endsection

@section('javascript')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
        $(document).ready(function() {

            //Form validate through JQuery
            $("#login").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                    },
                    password: {
                        required: "Password is required",
                    },
                }
            });
        });
    </script>
@endsection
