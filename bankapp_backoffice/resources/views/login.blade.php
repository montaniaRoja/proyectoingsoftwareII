<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">

            </div>
            <div class="col" style="margin-top: 200px;">
                <div class="card" style="width: 600px; height: 500px; background-color:lightgrey; border-radius: 10px">
                     @include('layouts._partials.messages')
                    <div style="text-align: center;">
                        <img src="{{ asset ('images/banca-en-linea.png')}}" class="img-fluid" alt="logo banca en linea" style="width:150px; height: 150px;">
                    </div>
                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf
                        <div class="mb-3" style="width: 80%;">
                            <label for="exampleInputEmail1" class="form-label" style="margin-left: 50px;">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" style="margin-left: 50px;">

                        </div>
                        <div class="mb-3" style="width: 80%;">
                            <label for="exampleInputPassword1" class="form-label" style="margin-left: 50px;">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" style="margin-left: 50px;">
                        </div>

                        <input type="submit" class="btn btn-primary btn-block" id="loginuser"
                                                value="Login" name="loginuser" style="margin-left: 50px;">
                    </form>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0" style="margin-left: 50px;">
                        <a href="#">Olvido su contrasenia?</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0" style="margin-left: 50px;">
                        <div class="small"><a href="#">Registrese para una nueva cuenta</a></div>
                    </div>
                </div>
            </div>

            <div class="col">

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
