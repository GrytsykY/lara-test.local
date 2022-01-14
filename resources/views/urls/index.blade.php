@extends('layouts.myApp')


@section('title','Url')

@include('layouts.myNavigation')

@section('content')

    <div class="container mt-8">
        <div class="row">
            <div class="col-5">

                <label>Введите url</label><br>
                <input id="url" class="" name="url" type="text" value="">
                <button id="check_url_btn" class="btn btn-primary" type="button"
                         style="background-color: #2563eb">CHECK
                </button>
                <br>

                <label>Введите название</label><br>
                <input id="name" class="" name="title" type="text" value=""><br>
                <label>Введите время</label><br>
                <input id="time" class="" name="time" type="number" max="40" value=""><br><br>

{{--                <div class="form-check">--}}
{{--                    <input class="form-check-input" type="radio" name="exampleRadios"--}}
{{--                           id=""--}}
{{--                           value="option1"--}}
{{--                           checked>--}}
{{--                    <label class="form-check-label" for="exampleRadios1">--}}
{{--                        Success--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                <div class="form-check">--}}
{{--                    <input class="form-check-input" type="radio" name="exampleRadios"--}}
{{--                           id="exampleRadios2"--}}
{{--                           value="option2">--}}
{{--                    <label class="form-check-label" for="exampleRadios2">--}}
{{--                        Warning--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                <div class="form-check">--}}
{{--                    <input class="form-check-input" type="radio" name="exampleRadios"--}}
{{--                           id="exampleRadios3"--}}
{{--                           value="option3">--}}
{{--                    <label class="form-check-label" for="exampleRadios3">--}}
{{--                        Warning +--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                <div class="form-check">--}}
{{--                    <input class="form-check-input" type="radio" name="exampleRadios"--}}
{{--                           id="exampleRadios4"--}}
{{--                           value="option4">--}}
{{--                    <label class="form-check-label" for="exampleRadios4">--}}
{{--                        Warning ++--}}
{{--                    </label>--}}
{{--                </div>--}}
                <label><input type="radio" name="radio" value="1"> Radio Button 1</label>
                <label><input type="radio" name="radio" value="2"> Radio Button 2</label>
                <label><input type="radio" name="radio" value="3"> Radio Button 3</label>
                <label><input type="radio" name="radio" value="4"> Radio Button 4</label>


                <input id="save_form_btn" name="submit" type="submit" value="SAVE">
            </div>

            {{-- таблица вывода url --}}
            <div class="col-7">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Url</th>
                        <th scope="col">Time</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($urls as $data)
                    <tr>
                        <th scope="row">{{$data->id}}</th>
                        <td>{{$data->url}}</td>
                        <td>{{$data->time}}</td>
                        <td>{{$data->created_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>--}}
    {{--    <script>--}}

    {{--        $('#urlForm').on('submit', function (event) {--}}
    {{--            alert('ol')--}}
    {{--            event.preventDefault();--}}
    {{--            console.log('ok');--}}
    {{--            let url = $('#url').val();--}}

    {{--            $.ajax({--}}
    {{--                url: "test",--}}
    {{--                type: "GET",--}}
    {{--                data: {--}}
    {{--                    "_token": "{{ csrf_token() }}",--}}
    {{--                    url: url--}}
    {{--                },--}}
    {{--                success: function (response) {--}}
    {{--                    console.log(response);--}}
    {{--                },--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
    </div>

