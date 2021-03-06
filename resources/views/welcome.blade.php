<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Workshop</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="/js/workshop.js"></script>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .container {
            padding-top: 75px;
        }
    </style>
</head>
<body>
<div class="container">
    @if(Session::has('flash_message'))
        <p class="alert {{ Session::get('alert-class') }}">{{ Session::get('flash_message') }}</p>
    @endif
    <div class="jumbotron">
        <h1 class="display-4">Please, fill out the form</h1>
        <hr class="my-4">

        {!! Form::open(['action' => 'HomeController@submit']) !!}
        <div class="form-group">
            {!! Form::label('name', 'Customer Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control name_auto leader']) !!}
            @if ($errors->has('name'))
                <div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
            @endif
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
            @if ($errors->has('phone'))
                <div class="alert alert-danger" role="alert">{{ $errors->first('phone') }}</div>
            @endif
            {!! Form::label('workshop', 'Workshop Time') !!}
            {!! Form::select('workshop', $workshops, null, ['class' => 'form-control']) !!}
            <br>
            <h5>Free places: <span class="badge badge-light free-places">0</span></h5>
            @if ($errors->has('workshop'))
                <div class="alert alert-danger" role="alert">{{ $errors->first('workshop') }}</div>
            @endif
        </div>
        <hr class="my-4">
        <div class="guest">
            <h5>1</h5>
            <div class="form-group">
                {!! Form::label('guest_name[1]', 'Guest Name') !!}
                {!! Form::text('guest_name[1]', null, ['class' => 'form-control name_auto guest', 'name' => 'guest_name[1]']) !!}
                @if ($errors->has('guest_name.*'))
                    <div class="alert alert-danger" role="alert">{{ $errors->first('guest_name.*') }}</div>
                @endif
                {!! Form::label('guest_email[1]', 'Email') !!}
                {!! Form::text('guest_email[1]', null, ['class' => 'form-control mail_auto', 'name' => 'guest_email[1]']) !!}
                @if ($errors->has('guest_email.*'))
                    <div class="alert alert-danger" role="alert">{{ $errors->first('guest_email.*') }}</div>
                @endif
            </div>
        </div>
        <button type="button" id="add-guest-fields" class="btn btn-outline-secondary">Add guest</button>
        <hr class="my-4">
        <button type="submit" class="btn btn-outline-success">Book Workshop</button>
        {!! Form::close() !!}
    </div>
</div>
</body>
<script>
    $('#workshop').on('change', function () {
        let url = window.location.origin + '/free-places/' + this.value;
        $.ajax({
            url: url,
            type: 'GET',
            crossDomain: false,
            async: false,
            success: function (data) {
                $('.free-places').html(data);
            },
            error: function (e) {
                console.log(e.message);
            }
        });
    });

    let counter = 1;

    $("#add-guest-fields").click(function () {
        counter++;
        $(".guest").append('<hr class="my-4"><h5>' + counter + '</h5><div class="form-group">\n' +
            '                <label for="guest_name[' + counter + ']">Guest Name</label>\n' +
            '                <input class="form-control name_auto guest" name="guest_name[' + counter + ']" type="text" id="autocomplete">\n' +
            '                <label for="guest_email[' + counter + ']">Email</label>\n' +
            '                <input class="form-control mail_auto" name="guest_email[' + counter + ']" type="text" id="guest_email[' + counter + ']">\n' +
            '            </div>');

        initData();
    });
</script>
</html>
