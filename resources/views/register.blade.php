<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>Hello, world!</h1>
<div class="container">
    <div class="row">
        <div class="col-5 mt-5">
            <div class="card">
                <div class="card-head">
                    <h3 class="text-center">Register</h3>
                    <div class="card-body">
                        <form action="{{route('registersave')}}" method="POST">
                            @csrf
                          
                            <div class="mb-3">
                                <label for="username" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="username">
                            </div>
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="useremail">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="userpassword">
                            </div>
                            <div class="mb-3">
                                <label for="userpassword-confirm" class="form-label">Confirm Password</label>
                                <input type="password" name="password-confirm" class="form-control" id="userpassword-confirm">
                            </div>
                           <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                    @if($errors->any())
                    <div class="card-footer text-body-secondary">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                                    
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   
  </body>
</html>