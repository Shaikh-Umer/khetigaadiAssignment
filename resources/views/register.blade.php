@extends('home')

@section('style')
    <style>
        .error {
            color: #FF0000;
        }
    </style>
@endsection

@section('content')
    <form id="register">
        @csrf
        <div class="container">
            <br>
            <h1 class="text-center">REGISTRATION</h1>
            <br>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="Enter First Name">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Enter Last Name">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="contact_number">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number"
                            placeholder="Enter Contact Number">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="address">Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Enter Address">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="country_id">Select Country <span class="text-danger">*</span></label>
                        <select class="form-control" id="country_id" name="country_id">
                            <option value="" selected disabled>-- Select Country --</option>
                            @foreach ($countries as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="state_id">Select State <span class="text-danger">*</span></label>
                        <select class="form-control" id="state_id" name="state_id">
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="city_id">Select City <span class="text-danger">*</span></label>
                        <select class="form-control" id="city_id" name="city_id">
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="name">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Username">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter Password">
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </div>
    </form>
@endsection


@section('javascript')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {

            // Country Dropdown Change Event
            $('#country_id').on('change', function() {
                var country_id = this.value;
                $("#state_id").html('');
                $.ajax({
                    url: "{{ url('/api/fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state_id').html('<option value="" selected disabled>-- Select State --</option>');
                        $.each(result.states, function(key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city_id').html('<option value="" selected disabled>-- Select City --</option>');
                    }
                });
            });

            // State Dropdown Change Event
            $('#state_id').on('change', function() {
                var state_id = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "{{ url('api/fetch-cities') }}",
                    type: "POST",
                    data: {
                        state_id: state_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city_id').html('<option value="" selected disabled>-- Select City --</option>');
                        $.each(result.cities, function(key, value) {
                            $("#city_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });

            //Form validate through JQuery
            $("#register").validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    contact_number: {
                        required: true,
                        remote: {
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            url: "{{ url('contact/number/validate/unique') }}"
                        }
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            url: "{{ url('email/validate/unique') }}"
                        }
                    },
                    address: {
                        required: true,
                    },
                    country_id: {
                        required: true,
                    },
                    state_id: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },

                    password: {
                        required: true,
                    }
                },
                messages: {
                    first_name: {
                        required: "First name is required",
                    },
                    last_name: {
                        required: "Last name is required",
                    },
                    contact_number: {
                        required: "Contact Number is required",
                        remote: 'Number already exists.'
                    },
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        remote: "Email already exist",
                    },
                    address: {
                        required: "Address is required",
                    },
                    country_id: {
                        required: "Country is required",
                    },
                    state_id: {
                        required: "State is required",
                    },
                    city_id: {
                        required: "City is required",
                    },
                    Username: {
                        required: "Username is required",
                    },
                    password: {
                        required: "Password is required",
                    },

                }
            });



            $("#register").submit(function() {

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ url('/insert') }}",
                    type: "POST",
                    dataType: 'json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(request, status, error) {

                        console.log(error);
                    }
                });

                return false;
            });
        });
    </script>
@endsection
