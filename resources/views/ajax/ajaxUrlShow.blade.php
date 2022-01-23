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
            <select id="project" class="project control">
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


        @foreach($alerts as $alert)

            <input type="radio" class="btn-check" name="radio" id="{{$alert->class}}-outlined"
                   autocomplete="off" value="{{$alert->id}}">
            <label class="btn btn-outline-{{$alert->class}}"
                   for="{{$alert->class}}-outlined">{{$alert->name}}</label>

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
                <th scope="col">Date</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @php $count = 0; @endphp
            @foreach($urls as $key=> $data)
                @if(Auth::user()->id_project == $data->id_project && Auth::user()->role == 0)
                    @php $count++; @endphp
                    {{--                                            @dump($key)--}}
                    @csrf
                    <tr id="row_{{$data->id}}">
                        <th scope="row">{{$count}}</th>
                        <td>
                            <a style="color: #2563eb" href="{{$data->url}}" target="_blank">
                                {{$data->name}}
                            </a>
                        </td>
                        <td>{{$data->last_ping}}</td>
                        <td>{{$data->time_out}}</td>
                        <td>{{$data->status_code}}</td>
                        <td>{{$data->max_count_ping}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>
                            <form action="{{route('url.edit',$data->id)}}" method="post">
                                @method('PUT')
                                @csrf
                                <button type="submit">
                                    <i style="color: #2563eb" class="fas fa-pen"></i>
                                </button>
                            </form>
                        </td>

                        <td>
                            <form action="{{route('url.destroy',$data->id)}}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit">
                                    <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @elseif(Auth::user()->role == 1)
                    @csrf
                    <tr id="row_{{$data->id}}">
                        <th scope="row">{{$key+1}}</th>
                        <td>
                            <a style="color: #2563eb" href="{{$data->url}}" target="_blank">
                                {{$data->name}}
                            </a>
                        </td>
                        <td>{{$data->last_ping}}</td>
                        <td>{{$data->time_out}}</td>
                        <td>{{$data->status_code}}</td>
                        <td>{{$data->max_count_ping}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>
                            <form action="{{route('url.update',$data->id)}}" method="post">
                                @method('PATCH')
                                @csrf
                                <button type="submit">
                                    <i style="color: #2563eb" class="fas fa-pen"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('url.destroy',$data->id)}}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" data-bs-target="#exampleModal">
                                    <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Button trigger modal -->
{{--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">--}}
{{--        Launch demo modal--}}
{{--    </button>--}}

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

