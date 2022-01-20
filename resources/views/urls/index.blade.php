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
                    {{--                    <a href="{{route('ping1')}}">URL</a>--}}
                    {{--                    <div class="search">--}}
                    {{--                        <input id="textInput" class="search" type="text" value=""/>--}}
                    {{--                        <input id="clearButton" class="submit" value="Clear" />--}}
                    {{--                    </div>--}}
                    <div class="row">
                        <div class="col-5">
                            <div id="select_project">

                                <label for="project"></label>
                                <select id="project" class="control">
                                    @foreach($projects as $project)
                                        @if($project->id == Auth::user()->id_project)
                                            <option id="{{$project->id}}">{{$project->title}}</option>
                                        @elseif(Auth::user()->role == 1)
                                            <option id="{{$project->id}}">{{$project->title}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label>Введите название</label><br>
                                <input id="name" class="control" type="text" value="">
                            </div>
                            <div>
                                <label id="url_check1">Введите url</label><br>
                                <label for="url_check"></label><input id="url_check" class="control" name="url"
                                                                      type="text" value="">
                                <input id="id_user" class="control" type="hidden" value="{{ Auth::user()->id }}">
                                <button id="check_url_btn" class="btn btn-primary" type="button"
                                        style="background-color: #2563eb">CHECK
                                </button>
                                <p id="url_label"></p>
                                <p id="url_status"></p>
                            </div>


                            <div>
                                <label id="code">Введите код ответа</label><br>
                                <input id="status_code" class="status_code control" type="number" min="200" max="510"
                                       required>
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

                                @foreach($alerts as $alert)

                                    <tr>
                                        <th><input type="radio" name="radio" value="{{$alert->id}}"> {{$alert->name}}
                                        </th>

                                    </tr>
                                @endforeach
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Last ping</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Max ping</th>
                                    <th scope="col">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($urls as $key=> $data)
                                    @if(Auth::user()->id_project == $data->id_project && Auth::user()->role == 0)
                                        <tr>
                                            <th scope="row">{{$key+1}}</th>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->last_ping}}</td>
                                            <td>{{$data->time_out}}</td>
                                            <td>{{$data->status_code}}</td>
                                            <td>{{$data->max_count_ping}}</td>
                                            <td>{{$data->created_at}}</td>
                                        </tr>
                                    @elseif(Auth::user()->role == 1)
                                        <tr>
                                            <th scope="row">{{$data->id}}</th>
                                            <td>{{$data->url}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->status_code}}</td>
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
