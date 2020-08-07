
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
</head>

<body>
    <div class="auth-layout-wrap" style="background-image: url('assets/images/photo-wide-4.jpg')">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4">
                                <img src="{{asset('assets/images/logo.png')}}" alt="">
                            </div>
                            <h1 class="mb-3 text-18">Login</h1>
                            @if(session('gagal'))
                            <div class="alert alert-danger" role="alert">
                                <strong class="text-capitalize">{{session('gagal')}}</strong> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <form method="POST" action="/postlogin" >
                                @csrf
                                <div class="form-group">
                                    <label for="id">ID </label>
                                    <input id="ID_USER" class="form-control form-control-rounded " name="ID_USER" maxlength="10" required autocomplete="id" autofocus>

                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="PASSWORD" class="form-control form-control-rounded @error('password') is-invalid @enderror" name="PASSWORD" required autocomplete="current-password">

                                </div>

                                <button class="btn btn-rounded btn-primary btn-block mt-2">Login</button>

                            </form>

                        </div>
                    </div>
                    <div class="col-md-6 text-center " style="background-size: cover;background-image: url('assets/images/photo-long-3.jpg')">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{asset('assets/js/common-bundle-script.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>