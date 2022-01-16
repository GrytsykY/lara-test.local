$(document).ready(function () {
    console.log($('#mytable'))
    $('#check_url_btn').on('click', function () {

        let url = $('#url').val();

        console.log(url);

        $.ajax({
            url: 'https://cors-anywhere.herokuapp.com/http://grytsyk.pl.ua/magazin/index.php',
            type: "GET",
            // headers: {
            //     'X-Requested-With': 'XMLHttpRequest',
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //     'Access-Control-Allow-Origin' : '*',
            //     'Access-Control-Allow-Methods' : '*',
            //     'Access-Control-Allow-Headers' : '*',
            // },
            // data: {
            //     url: url
            // },
            success: function (response) {
                console.log(response);
            },
        });
    });

    $('#save_form_btn').on('click', function (event) {

        let error = false;

        let url_check = $('#url_check').val();
        let time = $('#time').val();
        let name = $('#project').val();
        let id_user = $('#id_user').val();
        console.log(name)
        let choice = $('input[name="radio"]:checked').val();
        console.log(url_check)
        console.log(time)
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

        if (time < 0) {
            $('#time_label').after('<span class="error">Время не может быть отрицательным</span>');
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
    });


});
