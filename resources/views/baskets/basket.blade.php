<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(!empty($urls))
                    <table id="basket_table" class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Last ping</th>
                            <th scope="col">Time</th>
                            <th scope="col">Code</th>
                            <th scope="col">Max ping</th>
                            <th>restore</th>
                            <th>delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($urls as $key=> $data)
                            {{--                                    @if((Auth::user()->id_project == $data->id_project))--}}
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
                                    {{--                                                <button onclick="editUrl({{$data->id}})">--}}
                                    {{--                                                    <i style="color: #2563eb" class="fas fa-pen"></i>--}}
                                    {{--                                                </button>--}}
                                    <form action="restore/{{$data['id']}}" method="get">
                                        <button type="submit">
                                            <i style="color: #254deb" class="fas fa-trash-restore"></i>
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <button onclick="deleteTrash({{$data['id']}}, '{{$data['title']}}')">
                                        <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            {{--                                    @endif--}}
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p style="text-align: center;"  class="text-center"><b style="color: red">BASKET EMPTY!!!</b></p>
                        <div>
                            <img style="margin: 0 auto" src="{{ asset('images/Recycle-Bin-icon.png') }}">
                        </div>
                    @endif
                    <br>
                    <div class="text-center"><a href="{{route('url.index')}}" class="btn btn-primary">BACK</a></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
