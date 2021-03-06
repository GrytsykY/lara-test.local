<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="ml-4">
                        <h1 style="font-size: 20px" class="text-center"><b> Editing  </b></h1>
                        @if ($message = Session::get('success'))
                            <div class="text-center alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger text-center">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('url.update', $urls['urls']['id'])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input name="id_project" type="hidden" value="{{$urls['urls']['id_project']}}">
                            @if(Auth::user()->role == 1)
                                <label for="project">Project name</label><br>
                                <select id="project" name="id_project" class="project control">

                                    @foreach($urls['projects'] as $project)
                                        @php $sel = ""; @endphp
                                        @if($project['id'] == $urls['urls']['id']) @php $sel = "selected"; @endphp @endif
                                        <option id="{{$project['id']}}" value="{{$project['id']}}" {{$sel}} >
                                            {{$project['title']}}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <div>
                                <label>Enter the title</label><br>
                                <input id="title" name="title" class="control" type="text" value="{{$urls['urls']['title']}}" required>
                                <p id="title_label"></p>
                            </div>
                            <div>
                                <label>Enter a search term</label><br>
                                <input id="search_term" name="search_term" class="control" type="text" value="{{$urls['urls']['search_term']}}">
                                <p id="search_label"></p>
                            </div>
                            <div>
                                <label id="url_check1">Enter url</label><br>
                                <input id="url_check" class="control" name="url"
                                       type="text" value="{{$urls['urls']['url']}}" required>
                                <button id="check_url_btn" class="check_url_btn btn btn-primary" type="button"
                                        style="background-color: #2563eb">CHECK
                                </button>
                                <p id="url_label"></p>
                                <p id="url_status"></p>
                            </div>

                            <input id="id_user" name="id_user" class="control" type="hidden" value="{{ Auth::user()->id }}">
                            <div>
                                <label id="code">Enter response code</label><br>
                                <input id="status_code" class="status_code control" type="number" min="200" max="510"
                                       name="status_code" value="{{$urls['urls']['status_code']}}" required>
                                <p id="code_label"></p>
                            </div>

                            <div>
                                <label id="time1">Enter time</label><br>
                                <input id="time" class="control" type="number" min="1" max="40"
                                       name="time_out" value="{{$urls['urls']['time_out']}}"
                                       required>
                                <p id="time_label"></p>
                            </div>

                            <div>
                                <label id="count">Enter the number of requests</label><br>
                                <input id="count_link" class="control" type="number" min="1" max="40"
                                       name="max_count_ping" value="{{$urls['urls']['max_count_ping']}}" required>
                                <p id="count_label"></p>
                            </div>
                            <br>


                            @foreach($urls['alerts'] as $alert)
                                @php $checked = ""; @endphp
                                @if($alert['id'] == $urls['urls']['id_alert']) @php $checked = "checked"; @endphp @endif
                                <input type="radio" class="btn-check" name="id_alert" id="{{$alert['class']}}-outlined"
                                       autocomplete="off" value="{{$alert['id']}}" {{$checked}}>
                                <label class="btn btn-outline-{{$alert['class']}}"
                                       for="{{$alert['class']}}-outlined">{{$alert['name']}}</label>
                            @endforeach
                            <p id="radio_label"></p>
                            <br><br>

                            <button style="background-color: green" type="submit" class="btn btn-success">
                                Update
                            </button>
                            <a href="{{route('url.index')}}" class="btn btn-primary">BACK</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

