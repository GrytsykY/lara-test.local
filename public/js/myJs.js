$(document).ready(function () {
    const URI = 'http://lara-test.local/';

    /* Проверка URL */
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
                    // $('#url_status').after(`<span style="color: #2563eb" class="status">Ответ сервера код: ${response.status}</span>`);
                    $('#status_code').val(`${response.status}`);
                    console.log(response);
                },
                error: function (data) {
                    console.log(data);
                }

            });

        });
    }


    // document.getElementById("clearButton").onclick = function(e) {
    //     document.getElementById("textInput").value = "";
    // }

    /*  Выбор проектов */
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
                $('#status_code').val('');
                console.log(response);
            },
            error: function (data) {
                console.log(data);
            }

        });

        console.log(id_project)
    })

    checkUrl();
    /* Сохранение формы */
    $('#save_form_btn').on('click', function (event) {

        var error = false;

        let url_check = $('#url_check').val();
        let time = $('#time').val();
        let name = $('#name').val();
        let search_word = $('#search_word').val();
        let id_user = $('#id_user').val();
        let status_code = $('#status_code').val();
        let count_link = $('#count_link').val();
        let id_project = $('#project option:selected').attr('id');
        let choice = $('input[name="radio"]:checked').val();
        let id_proj = $('#id_project_input').val();

        if (id_project == undefined) id_project = id_proj;

        console.log(search_word)
        // console.log(time)
        // console.log(name)
        // console.log(status_code)
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

        if (name.length < 1) {
            $('#search_label').after('<span class="error">Введите слово или фразу</span>');
            error = true;
        }

        if (choice === undefined) {
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

        if (time > 40) {
            $('#time_label').after('<span class="error">Время не может быть больше 40</span>');
            error = true;
        }

        if (status_code.length < 1) {
            $('#code_label').after('<span class="error">Введите код</span>');
            error = true;
        }

        if (status_code < 200 || status_code > 500) {
            $('#code_label').after('<span class="error">Не верный код</span>');
            error = true;
        }

        if (count_link.length < 1) {
            $('#count_label').after('<span class="error">Введите колличество запросов</span>');
            error = true;
        }

        var date_now = getActualFullDate();

        $("#error_mes").removeClass('text-center error_mes alert alert-danger');

        if (error) return;

        $.ajax({
            url: URI + "url",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                url: url_check,
                name: name,
                search_word: search_word,
                time_out: time,
                max_count_ping: count_link,
                status_code: status_code,
                id_alert: choice,
                id_user: id_user,
                id_project: id_project,
            },

            success: function (response) {
                console.log('SUCCESS ' + response);

                const data = response.data

                if (data) {

                    $('#mytable').append(`
                        <tr id="row_${data.id}">
                            <th scope="row">${data.id}</th>
                            <td><a style="color: #2563eb" href="${data.url}">${data.name}</a></td>
                            <td>${date_now}</td>
                            <td>${data.time_out}</td>
                            <td>${data.status_code}</td>
                            <td>${data.max_count_ping}</td>

                            <td>
                                <form action="url/${data.id}/edit" method="get">
                                    <button type="submit">
                                        <i style="color: #2563eb" class="fas fa-pen"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                               <button onclick="deleteUrl(${data.id},'${data.name}')">
                                  <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                               </button>
                            </td>
                    </tr>`)
                }
                if (!error) {
                    $("#time").val("");
                    $("#name").val("");
                    $("#search_word").val("");
                    $("#url_check").val("");
                    $("#status_code").val("");
                    $("#count_link").val("");
                }

            },
            error: function (error) {

                let errors = error.responseJSON.errors;
                console.log(errors)
                if (errors) {
                    $('#error_mes').addClass('text-center error_mes alert alert-danger');
                    for (let value of Object.values(errors)) {
                        let ul = document.createElement('ul');
                        let li = document.createElement('li');
                        li.innerHTML = value[0];
                        ul.appendChild(li);
                        document.getElementById('error_mes').appendChild(ul);

                    }
                }
            }
        });
        document.getElementById('error_mes').innerHTML = "";


    });

});

function deleteUrl(id, name) {

    $.confirm({
        title: 'Удаление!',
        content: 'Вы хотите удалить ' + name + ' ?',
        buttons: {

            Удалить: {
                btnClass: 'btn-red',
                action: function () {

                    // $.alert('Удалить!');
                    console.log(id);
                    $.ajax({
                        url: 'url/' + id,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            _method: 'delete',
                            id: id
                        },
                        success: function (response) {
                            $('#mytable').html(response);
                            // checkUrl();
                            console.log(response);
                        },
                        error: function (data) {
                            console.log(data);
                        }

                    });
                },

            },
            Отменить: {
                btnClass: 'btn-blue',
                action: function () {
                    // $.alert('Отменить!');
                }
            }
        }
    });

}

function editUrl(id) {
    $.ajax({
        url: 'url/' + id + '/edit',
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            $('.py-12').html(response);
            console.log(response);
        },
        error: function (data) {
            console.log(data);
        }

    });
}

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getActualFullDate() {
    let d = new Date();
    let day = addZero(d.getDate());
    let month = addZero(d.getMonth() + 1);
    let year = addZero(d.getFullYear());
    let h = addZero(d.getHours());
    let m = addZero(d.getMinutes());
    let s = addZero(d.getSeconds());
    return year + "-" + month + "-" + day + " " + h + ":" + m + ":" + s;
}


