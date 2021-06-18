<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
    <!-- Latest compiled and minified CSS & JS -->
    <link href="{{ asset('bower_components/bower/client/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all">
    <script type="text/javascript" src="{{ asset('bower_components/bower/client/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('bower_components/bower/client/js/bootstrap.min.js') }}">
    </script>
    <style type="text/css">
    body {
        height : 500px;
        background : black;
        color : white;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content : center;
    }
    .card {
        width: 50%;
        display: flex;
        flex-flow: column;
        height: 60%;
        margin: 0 auto;
        background: #252525;
        /* align-items: center; */
        justify-content: center;
    }
    .card-header {
        margin-bottom: 50px;
        font-size: 25px;
        text-align: center;
        font-weight: bold;
    }
    .form-group {
        padding : 0 50px;
        display: flex;
        flex-wrap: wrap;
        align-items : center;
        font-size : 16px;
    }
    .col-form-label {
        width : 15%;
    }
    #email {
        width : 85%;
    }
    button {
        float : right;
        margin-right : 50px;
    }
    .alert {
        margin-top : 20px;
        width : 50%;
    }
</style>
</head>
<body>
    @if (session('error'))
    <div class="alert alert-danger">
        <ul>
            @foreach (json_decode(session('error')) as $error)
            <li>{{ $error[0] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="card">
        <div class="card-header">{{ __('Cài Đặt Lại Mật Khẩu') }}</div>

        <div class="card-body">
            <form method="POST" action="{{ route('client.reset', [$token]) }}">
                @csrf
                <div class="form-group">
                    <label for="password" class="col-form-label text-md-right">Mật khẩu</label>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Gửi') }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>


