$(document).ready(function () {

    // document.getElementById("clearButton").onclick = function(e) {
    //     document.getElementById("textInput").value = "";
    // }

    $('#check_url_btn').on('click', function () {
        let error = false;

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
            url: 'url/ajax-check-url',
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{
                url_check: url_check
            },
            success: function (response) {
                $('#url_status').after(`<span style="color: #2563eb" class="status">Ответ сервера код: ${response.status}</span>`);
                $('#status_code').after(`${response.status}`);
                console.log(response);
            },
            error: function (data) {
                console.log(data);
            }

        });
        // if (!error) $('#url_check').val('');

    });

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

        console.log(id_project)
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

        if (time.length < 1) {
            $('#time_label').after('<span class="error">Введите время</span>');
            error = true;
        }

        if (time < 0 ) {
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


        if (error) return;

        $.ajax({
            url: "url",
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
                    error=true;
                }

                if (data) {
                    console.log(data)
                    $('#mytable').append(`
                        <tr>
                        <th scope="row">${data.id}</th>
                        <td>${data.name}</td>
                        <td>${data.last_ping}</td>
                        <td>${data.time_out}</td>
                        <td>${data.status_code}</td>
                        <td>${data.max_count_ping}</td>
                        <td>${data.created_at}</td>
                    </tr>`)
                }
                if (!error) {
                    $("#time").val("");
                    $("#url_check").val("");
                    $("#status_code").val("");
                    $("#count_link").val("");
                }

            }
        });
        document.getElementById('error_mes').innerHTML = "";
        console.log('ERROR '+ error)

    });


});
