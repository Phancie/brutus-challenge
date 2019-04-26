<html>

    <head>
        <title>Brutus Challenge</title>
    </head>

    <body>
        <div class="">
            <form action="{{route('signup')}}" method="post">
                @csrf
                Name:<br>
                <input type="text" name="name"><br>
                @if ($errors->has('name'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                Email:<br>
                <input type="email" name="email"><br>
                @if ($errors->has('email'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                Password:<br>
                <input type="password" name="password"><br>
                @if ($errors->has('password'))
                    <span class="invalid-feedback text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <button type="submit">Sign up</button>
            </form>
        </div>
    </body>

</html>
