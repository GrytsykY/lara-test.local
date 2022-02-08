$(document).ready(function () {
    /*  Выбор проектов */
    $('#project').on('change', () => {
        let id_project = $('#project option:selected').attr('id');
        console.log(id_project);
        $.ajax({
            url: '/url/ajax-url-form/' + id_project,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
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

    })

    checkUrl();
    /* Сохранение формы */
    $('#save_form_btn').on('click', function (event) {

        let error = false;

        let url_check = $('#url_check').val();
        let time = $('#time').val();
        let title = $('#title').val();
        let search_term = $('#search_term').val();
        let id_user = $('#id_user').val();
        let status_code = $('#status_code').val();
        let count_link = $('#count_link').val();
        let id_project = $('#project option:selected').attr('id');
        let choice = $('input[name="radio"]:checked').val();
        let id_proj = $('#id_project_input').val();

        if (id_project === undefined) id_project = id_proj;

        $(".error").remove();

        error = errorUrl(url_check);

        if (title.length < 1) {
            $('#title_label').after('<span class="error">Enter the title</span>');
            error = true;
        }

        if (choice === undefined) {
            $('#radio_label').after('<span class="error">Select button</span>');
            error = true;
        }

        if (time.length < 1) {
            $('#time_label').after('<span class="error">Enter time</span>');
            error = true;
        }

        if (time < 0) {
            $('#time_label').after('<span class="error">Time cannot be negative</span>');
            error = true;
        }

        if (time > 40) {
            $('#time_label').after('<span class="error">Time cannot be more than 40</span>');
            error = true;
        }

        if (status_code.length < 1) {
            $('#code_label').after('<span class="error">Enter code</span>');
            error = true;
        }

        if ((status_code < 200 || status_code > 1000) && status_code.length > 1) {
            $('#code_label').after('<span class="error">Incorrect code</span>');
            error = true;
        }

        if (count_link.length < 1) {
            $('#count_label').after('<span class="error">Enter the number of requests</span>');
            error = true;
        }

        let date_now = getActualFullDate();

        $("#error_mes").removeClass('text-center error_mes alert alert-danger');

        if (error) return;

        $.ajax({
            url: "/url",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                url: url_check,
                title: title,
                search_term: search_term,
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
                            <td><a style="color: #2563eb" href="${data.url}">${data.title}</a></td>
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
                               <button onclick="deleteUrl(${data.id},'${data.title}')">
                                  <i style="color: #eb2549" class="fas fa-trash-alt"></i>
                               </button>
                            </td>
                    </tr>`)
                }
                if (!error) {
                    $("#time").val("");
                    $("#title").val("");
                    $("#search_term").val("");
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
                        url: '/url/' + id,
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

function deleteTrash(id, name) {

    $.confirm({
        title: 'Удаление!',
        content: 'Вы хотите удалить безвозвратно ' + name + ' ?',
        buttons: {

            Удалить: {
                btnClass: 'btn-red',
                action: function () {

                    // $.alert('Удалить!');
                    console.log(id);
                    $.ajax({
                        url: '/delete-trash/' + id,
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            _method: 'delete',
                            id: id
                        },
                        success: function (response) {
                            checkUrl();
                            $('#basket_table').html(response);
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

function errorUrl(url_check) {
    let error = false;
    if (url_check.length < 1) {
        $('#url_label').after('<span class="error">Enter url</span>');
        error = true;
    }

    let res = validURL(url_check);
    console.log(res)
    if (res === false && !error) {
        $('#url_label').after('<span class="error">Invalid url</span>');
        error = true;
    }
    return error;
}

/* Проверка URL */
function checkUrl() {
    $('#check_url_btn').on('click', function () {
        let error = false;
        $('#status_code').val('');
        let url_check = $('#url_check').val();

        $(".error").remove();
        $('.status').remove();

        error = errorUrl(url_check);
        if (error) return;

        $.ajax({
            url: '/url/ajax-check-url',
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

function validURL(str) {
    let pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
        '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    return !!pattern.test(str);
}
