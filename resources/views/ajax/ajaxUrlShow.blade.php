<div id="error_mes" class="error_mes">

</div>
{{--                    <a href="{{route('ping1')}}">URL</a>--}}
{{--                    <div class="search">--}}
{{--                        <input id="textInput" class="search" type="text" value=""/>--}}
{{--                        <input id="clearButton" class="submit" value="Clear" />--}}
{{--                    </div>--}}

{{-- таблица вывода url --}}

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
                        @method('GET')
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
                    <button type="submit" onclick="deleteUrl({{$data->id}})">
                        <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>


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

