<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday-Reminder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>

<body>

    <!-- This is Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <h2><a class="navbar-brand p-2 " href="#">🎂 BirthDay-Reminder</a></h2>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route("home") }}">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route("profile") }}">Profile</a>
                </li>
                <li class="nav-item">
                    <button onclick="openform()" class="btn btn-outline-success my-2 my-sm-0">Add
                        Birthday!</button>&nbsp;&nbsp;
                </li>
                <li class="nav-item">
                    <button onclick="emailfun('{{ session('uid')->email }}')"
                        class="btn btn-outline-success my-2 my-sm-0">Send Email</button>
                </li>
                <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
            </ul>

        </div>
        <h6 class="mt-2">{{ session('uid')->name }}&nbsp;&nbsp;</h6>
        <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{ route("logout") }}"
                class="text-danger">Logout</a></button>&nbsp;&nbsp;
    </nav><br><br><br><br>




    <!-- This is to handle messages sent through session -->
    @if(session()->has('success'))
        <h5 class="popup-container2">
            {{ session('success') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👍</h5>
    @endif
    @if(session()->has('error'))
        <h5 class="popup-container2">
            {{ session('error') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    @endif
    @if($errors->has('phone'))
    <h5 class="popup-container2">Wrong phone formate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    @endif

    <!-- Popup form to add birthdays -->
    <div class="popup-container" id="birthdayForm">
        <form class="popup-form" action="{{ route("date.post") }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            @if($errors->has('phone'))
                <span class="text-danger">{{ $errors->first('phone') }}</span>
            @endif
            <div style="display:flex;gap: 3px">
                <button type="submit" style="background-color: green;">Submit</button>
                <button onclick="openform()" style="background-color: red;">Cancel</button>
            </div>
        </form>
    </div>


    <!-- List section for showing upcoming Birthdays of the year -->
    <div class="container">
        <h2>Upcoming Birthdays</h2>
        @if($birthday->isEmpty())
            <br>
            <p>No upcoming birthdays found!</p>
        @else
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <!-- <th>Delete</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($birthday as $bday)
                        <tr>
                            <td>{{ $bday->name }}</td>
                            <td>{{ date('jS F',strtotime($bday->date)) }}</td>
                            <!-- <td><button class=" btn btn-danger" onclick="deletefun({{ $bday->id }})">Delete</button></td> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div>
            {{ $birthday->links('pagination::bootstrap-5') }}
        </div>
    </div><br><br>


    <!-- List section for showing all birthdates added -->
    <div class="container">
        <h2>List of all Birthdays</h2>
        <h5>Apply Filter</h5>
        <select name="month" id="month" value="" class="dropdown">
            <option value="all">All</option>
            <option value="jan">January</option>
            <option value="feb">February</option>
            <option value="mar">March</option>
            <option value="apr">April</option>
            <option value="may">May</option>
            <option value="jun">June</option>
            <option value="jul">July</option>
            <option value="aug">August</option>
            <option value="sep">September</option>
            <option value="oct">October</option>
            <option value="nov">November</option>
            <option value="dec">December</option>
        </select>
        <input type="text" value="" id="search" placeholder="    ...Search by Name">
        @if($data->isEmpty())
            <br><br>
            <p>No BirthDays Added!</p>
        @else
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                        <tr class="data-row" data-date="{{ date('M', strtotime($d->date)) }}"
                            data-name="{{ $d->name }}">
                            <td>{{ $d->name }}</td>
                            <td>{{ date('jS F', strtotime($d->date)) }}</td>
                            <td><button class="btn btn-danger" onclick="deletefun({{ $d->id }})">Delete</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        //Will execite after specified time intervel
        setInterval(function () {
            emailfun('{{ session('uid')->email }}');
        }, 172800000);


        //Delete function to delete birthdate with specified id
        function deletefun(id) {
            //console.log(id);
            fetch('/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => {
                    console.log('Birthday record deleted successfully');
                    location.reload();
                    alert("Birtday Deleted!");
                })
                .catch(error => {
                    console.error(error.message);
                });
        }


        //Email function to make api call for sending email
        function emailfun(email) {
            console.log('Email run');
            fetch('/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: email
                    })
                })
                .then(response => {
                    console.log('Email Sent!');
                })
                .catch(error => {
                    console.error(error.message);
                });
        }


        //Pop form to add bithday
        openform();
        function openform() {
            var form = document.getElementById("birthdayForm");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }


        //Filter functionality
        document.getElementById('month').addEventListener('change', function () {
            var selectedMonth = this.value;
            var dataRows = document.querySelectorAll('.data-row');

            dataRows.forEach(function (row) {
                var rowDate = row.getAttribute('data-date');
                if (selectedMonth == 'all' || rowDate.toLowerCase() === selectedMonth) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        //Search functionality
        document.getElementById('search').addEventListener('change', function () {
            var name = this.value;
            if (name == "") {
                location.reload();
            }
            var dataRows = document.querySelectorAll('.data-row');
            console.log(name);
            dataRows.forEach(function (row) {
                var rowname = row.getAttribute('data-name');
                console.log(rowname);
                if (rowname.toLowerCase() == name.toLowerCase()) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
                this.value = "";
            });
        });

    </script>
</body>

</html>
