@if ($message = Session::get('success'))
    <div style="background-color: white; color:black; text-align: center;">
        <p>{{ $message }}</p>
    </div>
@endif

@if ($message = Session::get('danger'))
    <div style="background-color: red; color:white; text-align: center;">
        <p>{{ $message }}</p>
    </div>
@endif

@if (Session::has('validationErrors') || $errors->any())
    <div style="background-color: red; color:white; text-align: center;">
        <ul>
            @foreach (Session::get('validationErrors', []) as $field => $errors)
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endforeach

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
