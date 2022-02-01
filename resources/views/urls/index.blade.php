<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div id="error_mes">

                    </div>

                    <div class="row">
                        @if(Auth::user()->role == 0)
{{--                            @dd($urls['projects'])--}}
                            <h2 style="font-size: 24px" class="text-center"><b>{{ __($urls['projects'][0]['title']) }}</b></h2>
                            <input id="id_project_input" type="hidden" value="{{$urls['projects'][0]['id']}}">
                        @endif
                        <div class="col-5">
                            @if(Auth::user()->role == 1)
                                <div id="select_project">
                                    <label for="project">Название проекта</label><br>
{{--                                    @dd($urls)--}}
                                    <select id="project" class="project control">
                                        @foreach($urls['projects'] as $project)
                                            @php $sel = ""; @endphp

                                            <option id="{{$project['id']}}" {{$sel}}>
                                                {{$project['title']}}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div>
                                <label>Введите название</label><br>
                                <input id="name" class="control" type="text" value="">
                                <p id="name_label"></p>
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
                            <br>


                            @foreach($urls['alerts'] as $alert)

                                <input type="radio" class="btn-check" name="radio" id="{{$alert['class']}}-outlined"
                                       autocomplete="off" value="{{$alert['id']}}">
                                <label class="btn btn-outline-{{$alert['class']}}"
                                       for="{{$alert['class']}}-outlined">{{$alert['name']}}</label>

                            @endforeach
                            <p id="radio_label"></p>
                            <br><br>

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
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $count = 0; @endphp
                                @foreach($urls['urls'] as $key=> $data)
{{--                                    @if((Auth::user()->id_project == $data->id_project))--}}
                                        @php $count++; @endphp

                                        <tr id="row_{{$data['id']}}">
                                            <th scope="row">{{$count}}</th>
                                            <td>
                                                <a style="color: #2563eb" href="{{$data['url']}}" target="_blank">
                                                    {{$data['name']}}
                                                </a>
                                            </td>
                                            <td>{{$data['last_ping']}}</td>
                                            <td>{{$data['time_out']}}</td>
                                            <td>{{$data['status_code']}}</td>
                                            <td>{{$data['max_count_ping']}}</td>
                                            <td>
{{--                                                <button onclick="editUrl({{$data->id}})">--}}
{{--                                                    <i style="color: #2563eb" class="fas fa-pen"></i>--}}
{{--                                                </button>--}}
                                                <form action="url/{{$data['id']}}/edit" method="get">
                                                    <button type="submit">
                                                        <i style="color: #2563eb" class="fas fa-pen"></i>
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                                <button onclick="deleteUrl({{$data['id']}}, '{{$data['name']}}')">
                                                    <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
{{--                                    @endif--}}
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

