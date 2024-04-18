<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    
</head>

<body>
<!-- This is Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <h2><a class="navbar-brand p-2 " href="#">🎂 BirthDay-Reminder</a></h2>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="{{route("home")}}">Home </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{route("profile")}}">Profile</a>
      </li>
      <!-- <li class="nav-item">
      <button onclick="openform()" class="btn btn-outline-success my-2 my-sm-0">Add Birthday!</button>&nbsp;&nbsp;
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
      <!-- <button onclick="emailfun('{{ session('uid')->email }}')" class="btn btn-outline-success my-2 my-sm-0">Send Email</button> -->
      </form>
    
  </div>
  <h6 class="mt-2">{{session('uid')->name}}&nbsp;&nbsp;</h6>
  <button class="btn btn-outline-success my-2 my-sm-0 "><a href="{{route("logout")}}" class="text-danger">Logout</a></button>&nbsp;&nbsp;
</nav><br><br><br><br>

        <!-- This is to handle messages sent through session -->
    @if(session()->has('success'))
        <h5 class="popup-container2">{{ session('success') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👍</h5>
    @endif
    @if(session()->has('error'))
        <h5 class="popup-container2">{{ session('error') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    @endif

    <!-- This is section to display profile information -->
    <div class="page-content page-container " id="page-content" style="width:100%">
        <div class="padding">
            <div class="row container d-flex justify-content-center">
                <div class="col-xl-8 col-md-12 mx-auto">
                    <div class="card user-card-full" style="height: 500px;">
                        <div class="row m-l-0 m-r-0">
                            <div class="col-sm-4 bg-c-lite-green user-profile" style="height: 500px;">
                                <div class="card-block text-center text-white">
                                    <div class="m-b-25">
                                        <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius"
                                            alt="User-Profile-Image">
                                    </div>
                                    <h3 class="f-w-600">{{ session('uid')->name }}</h3>
                                    <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="card-block">
                                    <h2 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Name</p>
                                            <h6 class="text-muted f-w-400">
                                                {{ session('uid')->name }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Email</p>
                                            <h6 class="text-muted f-w-400">
                                                {{ session('uid')->email }}</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Phone</p>
                                            <h6 class="text-muted f-w-400">
                                                {{ session('uid')->phone }}</h6>
                                        </div>
                                    </div>
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Notification frequency</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Days prior</p>
                                            <h6 class="text-muted f-w-400">2</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn btn-success mt-5" onclick="openform()">Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-container3" id="registrationForm">
                                <form id="" action="{{ route('profile.post') }}" method="POST"
                                    class="mx-auto">
                                    @csrf
                                    <div class="form-group"><br><br>
                                        <label for="name">
                                            Name
                                        </label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                                            required  />
                                        @if($errors->has('name'))
                                            <span
                                                class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email">
                                            Email
                                        </label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Email" required
                                             />
                                        @if($errors->has('email'))
                                            <span
                                                class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="number">
                                            Notification frequency
                                        </label>
                                        <input type="number" name="frequency" class="form-control" id="frequency" />
                                        @if($errors->has('password'))
                                            <span
                                                class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="Phone">
                                            Phone
                                        </label>
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="Phone" required
                                            />
                                        @if($errors->has('phone'))
                                            <span
                                                class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Save
                                    </button>
                                    <button class="btn btn-danger" onclick="openform()" >
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //popup functionality
        function openform() {
            var form = document.getElementById("registrationForm");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }

    </script>
</body>

</html>
