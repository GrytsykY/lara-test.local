<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="ml-4">
                        <h1 style="font-size: 20px" class="text-center"><b> Редактирование  </b></h1>
                        @if ($message = Session::get('success'))
                            <div class="text-center alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <form action="{{route('url.update', $urls->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input name="id_project" type="hidden" value="{{$urls->id_project}}">
                            @if(Auth::user()->role == 1)
                                <label for="project">Название проекта</label><br>
                                <select id="project" name="id_project" class="project control">

                                    @foreach($projects as $project)
                                        @php $sel = ""; @endphp
                                        @if($project->id == $urls->id_project) @php $sel = "selected"; @endphp @endif
                                        <option id="{{$project->id}}" value="{{$project->id}}" {{$sel}} >
                                            {{$project->title}}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <div>
                                <label>Введите название</label><br>
                                <input id="name" name="name" class="control" type="text" value="{{$urls->name}}" required>
                                <p id="name_label"></p>
                            </div>
                            <div>
                                <label id="url_check1">Введите url</label><br>
                                <input id="url_check" class="control" name="url"
                                       type="text" value="{{$urls->url}}" required>
                                <button id="check_url_btn" class="check_url_btn btn btn-primary" type="button"
                                        style="background-color: #2563eb">CHECK
                                </button>
                                <p id="url_label"></p>
                                <p id="url_status"></p>
                            </div>

                            <input id="id_user" name="id_user" class="control" type="hidden" value="{{ Auth::user()->id }}">
                            <div>
                                <label id="code">Введите код ответа</label><br>
                                <input id="status_code" class="status_code control" type="number" min="200" max="510"
                                       name="status_code" value="{{$urls->status_code}}" required>
                                <p id="code_label"></p>
                            </div>

                            <div>
                                <label id="time1">Введите время</label><br>
                                <input id="time" class="control" type="number" min="1" max="40"
                                       name="time_out" value="{{$urls->time_out}}"
                                       required>
                                <p id="time_label"></p>
                            </div>

                            <div>
                                <label id="count">Введите кол-запросов</label><br>
                                <input id="count_link" class="control" type="number" min="1" max="40"
                                       name="max_count_ping" value="{{$urls->max_count_ping}}" required>
                                <p id="count_label"></p>
                            </div>
                            <br>


                            @foreach($alerts as $alert)
                                @php $checked = ""; @endphp
                                @if($alert->id == $urls->id_alert) @php $checked = "checked"; @endphp @endif
                                <input type="radio" class="btn-check" name="id_alert" id="{{$alert->class}}-outlined"
                                       autocomplete="off" value="{{$alert->id}}" {{$checked}}>
                                <label class="btn btn-outline-{{$alert->class}}"
                                       for="{{$alert->class}}-outlined">{{$alert->name}}</label>
                            @endforeach
                            <p id="radio_label"></p>
                            <br><br>

                            <button style="background-color: green" type="submit" class="btn btn-success">
                                Обновить
                            </button>
                            <a href="{{route('url.index')}}" class="btn btn-primary">НАЗАД</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

