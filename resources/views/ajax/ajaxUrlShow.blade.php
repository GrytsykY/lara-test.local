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
        {{--        @if(Auth::user()->id_project == $data->id_project)--}}
        @php $count++; @endphp

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
                <button onclick="editUrl({{$data->id}})">
                    <i style="color: #2563eb" class="fas fa-pen"></i>
                </button>
            </td>

            <td>
                <button type="button" onclick="deleteUrl({{$data->id}}, '{{$data->name}}')">
                    <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>

        {{--        @endif--}}
    @endforeach
    </tbody>
</table>


