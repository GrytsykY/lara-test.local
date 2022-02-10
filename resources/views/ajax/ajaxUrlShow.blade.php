<div id="error_mes" class="error_mes">
</div>

{{-- таблица вывода url --}}

<table id="mytable" class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Title</th>
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
{{--    @dd($urls)--}}
    @foreach($urls['urls'] as $key=> $data)
        {{--        @if(Auth::user()->id_project == $data->id_project)--}}
        @php $count++; @endphp

        <tr id="row_{{$data['id']}}">
            <th scope="row">{{$count}}</th>
            <td>
                <a style="color: #2563eb" href="{{$data['url']}}" target="_blank">
                    {{$data['title']}}
                </a>
            </td>
            <td>{{$data['last_ping']}}</td>
            <td>{{$data['time_out']}}</td>
            <td>{{$data['status_code']}}</td>
            <td>{{$data['max_count_ping']}}</td>
            <td>
                <form action="url/{{$data['id']}}/edit" method="get">
                    <button type="submit">
                        <i style="color: #2563eb" class="fas fa-pen"></i>
                    </button>
                </form>
            </td>

            <td>
                <button type="button" onclick="deleteUrl({{$data['id']}}, '{{$data['title']}}')">
                    <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                </button>
            </td>
        </tr>

        {{--        @endif--}}
    @endforeach
    </tbody>
</table>




