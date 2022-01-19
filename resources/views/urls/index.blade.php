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

                        <div id="error_mes" class="error_mes">

                        </div>

                    {{--                    <div class="search">--}}
                    {{--                        <input id="textInput" class="search" type="text" value=""/>--}}
                    {{--                        <input id="clearButton" class="submit" value="Clear" />--}}
                    {{--                    </div>--}}
                    <div class="row">
                        <div class="col-5">
                            <div>
                                <label>Выберите название</label><br>
                                <label for="project"></label><select id="project" class="control">
                                    @foreach($projects as $project)
                                        <option>{{$project->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label id="url_check1">Введите url</label><br>
                                <label for="url_check"></label><input id="url_check" class="control" name="url"
                                                                      type="text" value="">

                                <button id="check_url_btn" class="btn btn-primary" type="button"
                                        style="background-color: #2563eb">CHECK
                                </button>
                                <p id="url_label"></p>
                                <p id="url_status"></p>
                            </div>
                            <input id="id_user" class="control" type="hidden" value="{{ Auth::user()->id }}">

                            <div>
                                <label id="code">Введите код ответа</label><br>
                                <input id="status_code" class="control" type="number" min="200" max="510" required>
                                <p id="code_label"></p>
                            </div>

                            <div>
                                <label id="time1">Введите время</label><br>
                                <input id="time" class="control" type="number" min="1" max="40" required>
                                <p id="time_label"></p>
                            </div>

                            <div>
                                <label id="count">Введите кол-запросов</label><br>
                                <input id="count_link" class="control" type="number" min="1" max="40" required>
                                <p id="count_label"></p>
                            </div>

                            <table>
                                <tr>
                                    <th><input type="radio" name="radio" value="1" checked> Не важно</th>
                                    <th><input type="radio" name="radio" value="2"> Важно</th>
                                </tr>
                                <tr>
                                    <th><input type="radio" name="radio" value="3"> Важно +</th>
                                    <th><input type="radio" name="radio" value="4"> Очень важно</th>
                                </tr>
                            </table>
                            <div>

                            </div>

                            <input id="save_form_btn" class="btn btn-primary" value="SAVE">
                        </div>

                        {{-- таблица вывода url --}}
                        <div class="col-7">
                            <table id="mytable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Url</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($urls as $data)
                                    @if(Auth::user()->id == $data->id_user && Auth::user()->role == 0)
                                        <tr>
                                            <th scope="row">{{$data->id}}</th>
                                            <td>{{$data->url}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->time_out}}</td>
                                            <td>{{$data->created_at}}</td>
                                        </tr>
                                    @elseif(Auth::user()->role == 1)
                                        <tr>
                                            <th scope="row">{{$data->id}}</th>
                                            <td>{{$data->url}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->time}}</td>
                                            <td>{{$data->created_at}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
