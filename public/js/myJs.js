$(document).ready(function () {

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
                console.log(response);
            },
            error: function (data) {
                console.log(data);
            }

        });
        if (!error) $('#url_check').val('');

    });

    $('#save_form_btn').on('click', function (event) {

        let error = false;

        let url_check = $('#url_check').val();
        let time = $('#time').val();
        let name = $('#project').val();
        let id_user = $('#id_user').val();
        let choice = $('input[name="radio"]:checked').val();

        console.log(url_check)
        console.log(time)
        console.log(name)
        $(".error").remove();

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

        if (time > 40 ) {
            $('#time_label').after('<span class="error">Время не может быть больше 40</span>');
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
                time: time,
                name: name,
                choice: choice,
                id_user: id_user,
            },

            success: function (response) {
                console.log(response);
                const data = response.data

                $('#mytable').append(`
                        <tr>
                        <th scope="row">${data.id}</th>
                        <td>${data.url}</td>
                        <td>${data.name}</td>
                        <td>${data.time}</td>
                        <td>${data.created_at}</td>
                    </tr>`)
            },
        });

        $("input[type='radio']:checked").val("");
        $("#time").val("");
        $("#url_check").val("");
    });


});
