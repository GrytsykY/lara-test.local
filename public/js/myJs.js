$(document).ready(function () {

    $('#check_url_btn').on('click', function () {

        let url = $('#url').val();

        console.log(url);

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
            },
        });
    });

    $('#save_form_btn').on('click', function (event) {

        event.preventDefault();

        let url_check = $('#url').val();
        let time = $('#time').val();
        let name = $('#name').val();
        let choice = $('input[name="radio"]:checked').val();

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
            },
            success: function (response) {
                console.log(response);
            },
        });
    });


});
