jQuery( document ).ready(function() {
    $("#role_form").validate({
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                $('span.error').hide();
            }
        },
        ignore:"",
        rules: {
            'title': {required: true},
            'permissions': {required: true},
            'permissions[]': {required: true},
        },
        messages: {
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: $(form).attr('action'),
                method: 'POST',
                dataType: 'JSON',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('body').find('.spinner-box').show();
                }
            }).done(function(data) {
                $('body').find('.spinner-box').hide();
                if(data.success == true){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if(data.redirect){
                            window.location.href = data.redirect;
                        } else {
                            $(form)[0].reset();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        allowOutsideClick: false,
                    });
                }
            });
            return false;
        },
        errorElement : 'span',
        errorPlacement: function(error, element) {
            if (element.is("select")) {
                error.insertAfter(element.next('span'));
            } else {
              error.insertAfter(element);
            }
        }
    });
    });