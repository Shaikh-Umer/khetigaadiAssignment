@extends('layouts.dashboard')

@section('main-content')
    <table id="table-list" class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">First NAme</th>
                <th scope="col">Last NAme</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Email</th>
                <th scope="col">Country</th>
                <th scope="col">State</th>
                <th scope="col">City</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@endsection



@section('javascript')
    <script>
        $(function() {

            getUsers();
        })

        function getUsers() {

            $.ajax({
                url: "{{ url('/list') }}",
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    var rows = "";
                    var i = 0;
                    
                    response.users.forEach(user => {                   
                        rows += `<tr>
                                    <td scope="col">${++i}</td>
                                    <td scope="col">${user.user.name}</td>
                                    <td scope="col">${user.first_name}</td>
                                    <td scope="col">${user.last_name}</td>
                                    <td scope="col">${user.contact_number}</td>
                                    <td scope="col">${user.user.email}</td>
                                    <td scope="col">${user.country.name}</td>
                                    <td scope="col">${user.state.name}</td>
                                    <td scope="col">${user.city.name}</td> 
                                </tr>`;
                    });

                    $('#table-list').children('tbody').html(rows);
                }
            });
        }
    </script>
@endsection
