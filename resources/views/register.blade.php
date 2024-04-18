<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, 
                   initial-scale=1,
                   shrink-to-fit=no" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <title>Birthday-Remider</title>
</head>

<body>
    <h1 class="text-success text-center">
        Birthday Reminder
    </h1>
    <h5 class="text-center">Create an account and never forget to wish your loved one's...</h5>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <div class="card-body">
                        <div>
                            @if(session()->has('success'))
                                <h3 class="text-success ">{{ session('success') }}</h3>
                            @endif
                            @if(session()->has('error'))
                                <h5 class="text-danger ">{{ session('error') }}</h5>
                            @endif
                        </div>
                        <form id="registrationForm" action="{{ route("register.post") }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">
                                    Name
                                </label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                                    required />
                                @if($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    Email
                                </label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                    required />
                                @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">
                                    Password
                                </label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Password" required />
                                @if($errors->has('password'))
                                    <span
                                        class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="Phone">
                                    Phone
                                </label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone"
                                    required />
                                    @if($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                            <button class="btn btn-danger" type="submit">
                                Register
                            </button>
                        </form>
                        <p class="mt-3">
                            Alredy have an Account?
                            <a href="/">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
