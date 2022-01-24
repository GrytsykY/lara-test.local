$(document).ready(function () {
    const URI = 'http://lara-test.local/';

    function checkUrl() {
        $('#check_url_btn').on('click', function () {
            let error = false;
            $('#status_code').val('');
            let url_check = $('#url_check').val();

            $(".error").remove();
            $('.status').remove();
            if (url_check.length < 1) {
                $('#url_label').after('<span class="error">Введите url</span>');
                error = true;
            }

            var res = url_check.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
            if (res == null && !error) {
                $('#url_label').after('<span class="error">Неверный url адрес</span>');
                error = true;
            }

            if (error) return;

            $.ajax({
                url: URI + 'url/ajax-check-url',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    url_check: url_check
                },
                success: function (response) {
                    $('#url_status').after(`<span style="color: #2563eb" class="status">Ответ сервера код: ${response.status}</span>`);
                    $('#status_code').val(`${response.status}`);
                    console.log(response);
                },
                error: function (data) {
                    console.log(data);
                }

            });
            // if (!error) $('#url_check').val('');

        });
    }


    // document.getElementById("clearButton").onclick = function(e) {
    //     document.getElementById("textInput").value = "";
    // }


    $('#project').on('change', () => {
        let id_project = $('#project option:selected').attr('id');
        console.log(id_project);
        $.ajax({
            url: URI + 'url/ajax-url-form/' + id_project,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            // data: {
            //     id: id_project
            // },
            success: function (response) {
                $('#mytable').html(response);
                checkUrl();
                console.log(response);
            },
            error: function (data) {
                console.log(data);
            }

        });

        console.log(id_project)
    })

    checkUrl();

    $('#save_form_btn').on('click', function (event) {

        var error = false;

        let url_check = $('#url_check').val();
        let time = $('#time').val();
        let name = $('#name').val();
        let id_user = $('#id_user').val();
        let status_code = $('#status_code').val();
        let count_link = $('#count_link').val();
        let id_project = $('#project option:selected').attr('id');
        let choice = $('input[name="radio"]:checked').val();

        console.log(choice)
        console.log(time)
        console.log(name)
        console.log(status_code)
        $(".error").remove();
        // $(".alert alert-danger").remove();


        if (url_check.length < 1) {
            $('#url_label').after('<span class="error">Введите url</span>');
            error = true;
        }

        var res = url_check.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);

        if (res == null && !error) {
            $('#url_label').after('<span class="error">Неверный url адрес</span>');
            error = true;
        }

        if (name.length < 1) {
            $('#name_label').after('<span class="error">Введите название</span>');
            error = true;
        }

        if (choice == undefined) {
            $('#radio_label').after('<span class="error">Выберите кнопку</span>');
            error = true;
        }

        if (time.length < 1) {
            $('#time_label').after('<span class="error">Введите время</span>');
            error = true;
        }

        if (time < 0) {
            $('#time_label').after('<span class="error">Время не может быть отрицательным</span>');
            error = true;
        }

        // if (time > 40 ) {
        //     $('#time_label').after('<span class="error">Время не может быть больше 40</span>');
        //     error = true;
        // }

        if (status_code.length < 1) {
            $('#code_label').after('<span class="error">Введите код</span>');
            error = true;
        }

        // if (status_code < 200 || status_code > 500) {
        //     $('#code_label').after('<span class="error">Не верный код</span>');
        //     error = true;
        // }

        if (count_link.length < 1) {
            $('#count_label').after('<span class="error">Введите колличество запросов</span>');
            error = true;
        }

        function addZero(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        function getActualFullDate() {
            var d = new Date();
            var day = addZero(d.getDate());
            var month = addZero(d.getMonth() + 1);
            var year = addZero(d.getFullYear());
            var h = addZero(d.getHours());
            var m = addZero(d.getMinutes());
            var s = addZero(d.getSeconds());
            return year + "-" + month + "-" + day + " " + h + ":" + m + ":" + s;
        }

        var date_now = getActualFullDate();

        console.log(date_now)
        if (error) return;
        console.log($('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: URI + "url",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                url: url_check,
                name: name,
                time_out: time,
                max_count_ping: count_link,
                status_code: status_code,
                id_alert: choice,
                id_user: id_user,
                id_project: id_project,
            },

            success: function (response) {
                console.log(response);
                const data = response.data


                if (response.error) {

                    for (let i = 0; i < response.error.length; i++) {
                        let ul = document.createElement('ul');
                        let li = document.createElement('li');
                        li.innerHTML = response.error[i];
                        ul.appendChild(li);
                        document.getElementById('error_mes').appendChild(ul);
                        // document.getElementById('error_mes').classList.add("alert alert-danger");
                        // document.querySelector('.error_mes div').classList.add('alert alert-danger');

                    }
                    error = true;
                }

                if (data) {

                    $('#mytable').append(`
                        <tr id="row_${data.id}">
                            <th scope="row">${data.id}</th>
                            <td><a style="color: #2563eb" href="${data.url}">${data.name}</a></td>
                            <td>${date_now}</td>
                            <td>${data.time_out}</td>
                            <td>${data.status_code}</td>
                            <td>${data.max_count_ping}</td>
                            <td>${date_now}</td>
                            <td>
                                <form action="url/${data.id}/edit" method="get">

                                    <button type="submit">
                                        <i style="color: #2563eb" class="fas fa-pen"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                               <button type="submit" onclick="deleteUrl(${data.id})">
                                  <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                               </button>
                            </td>
                    </tr>`)
                }
                if (!error) {
                    $("#time").val("");
                    $("#name").val("");
                    $("#url_check").val("");
                    $("#status_code").val("");
                    $("#count_link").val("");
                }

            }
        });
        document.getElementById('error_mes').innerHTML = "";
        console.log('ERROR ' + error)

    });


});

function deleteUrl(id) {

    $.confirm({
        title: 'Удаления!',
        content: 'Вы хотите удалить?',
        buttons: {
            удалить: function () {

                $.alert('Удалить!');
                $.ajax({
                    url: 'url/' + id,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        _method: 'delete'
                    },
                    success: function (response) {
                        // $('#mytable').html(response);
                        // checkUrl();
                        console.log(response);
                    },
                    error: function (data) {
                        console.log(data);
                    }

                });
            },
            отмена: function () {
                $.alert('Отмеить!');
            }
        }
    });

}

