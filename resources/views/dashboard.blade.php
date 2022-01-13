<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Панель пользователя') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container mt-8">
                        <div class="row">
                            <div class="col-5">
{{--                                <form>--}}
{{--                                    <div class="mb-3">--}}
{{--                                        <label for="exampleInputEmail1" class="form-label">Email address</label>--}}
{{--                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">--}}
{{--                                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="mb-3">--}}
{{--                                        <label for="exampleInputPassword1" class="form-label">Password</label>--}}
{{--                                        <input type="password" class="form-control" id="exampleInputPassword1">--}}
{{--                                    </div>--}}
{{--                                    <div class="mb-3 form-check">--}}
{{--                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">--}}
{{--                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>--}}
{{--                                    </div>--}}
{{--                                    <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                                </form>--}}
                            <form action="" method="post">
                                <form id="urlForm">
                                    <label>Введите url</label><br>
                                    <input id="url" class="" name="url" type="text" value="">
                                    <button id="submit" class="btn btn-primary" name="url" type="button"
                                    style="background-color: #2563eb">CHECK</button><br>
                                </form>
                                <label>Введите название</label><br>
                                <input class="" name="title" type="text" value=""><br>
                                <label>Введите время</label><br>
                                <input class="" name="time" type="text" value=""><br><br>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                           id="exampleRadios1"
                                           value="option1"
                                           checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Success
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                           id="exampleRadios2"
                                           value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Warning
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                           id="exampleRadios3"
                                           value="option3">
                                    <label class="form-check-label" for="exampleRadios3">
                                        Warning +
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                           id="exampleRadios4"
                                           value="option4">
                                    <label class="form-check-label" for="exampleRadios4">
                                        Warning ++
                                    </label>
                                </div>
                                    <input name="submit" type="submit" value="SAVE">
                            </form>
                            </div>

                            {{-- таблица вывода url --}}
                            <div class="col-7">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>mdo</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>fat</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td colspan="2">Larry the Bird</td>
                                        <td>twitter</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
                    <script>

                        $('#urlForm').on('submit', function (event) {
                            alert('ol')
                            event.preventDefault();
                            console.log('ok');
                            let url = $('#url').val();

                            $.ajax({
                                url: "test",
                                type: "GET",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    url: url
                                },
                                success: function (response) {
                                    console.log(response);
                                },
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
