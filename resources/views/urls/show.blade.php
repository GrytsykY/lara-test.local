<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            @if (Auth::user()->role == 0)
                {{ __('Панель пользователя') }}
            @else
                {{ __('Панель администратора') }}
            @endif
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


                        <table id="mytable" class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Url</th>
                                <th scope="col">Project</th>
                                <th scope="col">Name</th>
                                <th scope="col">Last ping</th>
                                <th scope="col">Time</th>
                                <th scope="col">Code</th>
                                <th scope="col">Col-ping</th>
                                <th scope="col">Max ping</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                                                            @dd($projects)--}}
                            @foreach($urls as $key=> $data)

                                <tr>
                                    <th scope="row">{{(int) $key+1}}</th>
                                    <td>{{$data->url}}</td>
                                    <td>{{$projects[0]->title}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->last_ping}}</td>
                                    <td>{{$data->time_out}}</td>
                                    <td>{{$data->status_code}}</td>
                                    <td>{{$data->ping_counter}}</td>
                                    <td>{{$data->max_count_ping}}</td>
                                    <td>{{$data->created_at}}</td>
                                </tr>
                                {{--                                    @endif--}}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <p style="margin-left: 20px"><a class="btn btn-primary" href="{{route('url.index')}}">НАЗАД</a></p>
            </div>
        </div>
    </div>
</x-app-layout>

