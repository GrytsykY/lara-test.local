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
                    <div class="container mt-8">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-5">
                                <div>
                                    <label id="url_check1">Введите url</label><br>
                                    <input id="url_check" class="" name="url" type="text" value="">

                                    <button id="check_url_btn" class="btn btn-primary" type="button"
                                            style="background-color: #2563eb">CHECK
                                    </button>
                                    <p id="url_label"></p>
                                </div>
                                <input id="id_user" type="hidden" value="{{ Auth::user()->id }}">
                                <div>
                                    <label>Выберите название</label><br>
                                    <select id="project">
                                        @foreach($projects as $project)
                                            <option>{{$project->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label id="time1">Введите время</label><br>
                                    <input id="time" type="number" min="1" max="40" value="">
                                    <p id="time_label"></p>
                                </div>
                                <label><input type="radio" name="radio" value="1" checked> Radio Button 1</label>
                                <label><input type="radio" name="radio" value="2"> Radio Button 2</label>
                                <label><input type="radio" name="radio" value="3"> Radio Button 3</label>
                                <label><input type="radio" name="radio" value="4"> Radio Button 4</label>


                                <input id="save_form_btn" name="submit" type="submit" value="SAVE">
                            </div>

                            {{-- таблица вывода url --}}
                            <div class="col-7">
                                <table id="mytable" class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Url</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($urls as $data)
                                        @if(Auth::user()->id == $data->id_user)
                                            <tr>
                                                <th scope="row">{{$data->id}}</th>
                                                <td>{{$data->url}}</td>
                                                <td>{{$data->name}}</td>
                                                <td>{{$data->time}}</td>
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
    </div>
</x-app-layout>
