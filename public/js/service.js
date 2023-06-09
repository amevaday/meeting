var serviceValidator;//Declare Global Variable For Service
jQuery(document).ready(function () {
    //Define Service Datatable
    var table = $('#service-datatable').DataTable({
        "dom": 'B<"top">rt<"bottom"ip><"clear">',
        ajax: {
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            'type': 'POST',
            'url': 'services/index',
        },
        serverSide: true,
        processing: false,
        responsive: true,
        aaSorting: [[0, "asc"]],
        pageLength: 100,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'actions', name: 'actions' },
        ],
    });
    //Service datatable End

    // Service Modal Open and validate function also declare
    $('body').on('click', '#add_service', function () {
        $('.loadimg').show();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: 'services/addService',
            type: 'POST',
            success: function (data) {
                $('#service_modal_content').html(data);
                $('#service_form').validate(serviceValidator); //Use Global Variable
                $('#ServiceModal').modal('show');
                $('.loadimg').hide();

            },
            error: function (e) { }
        });
    });
    // End Add Service Modal
    // User Variable 
    serviceValidator = {
        invalidHandler: function (event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                $('span.error').hide();
            }
        },
        ignore: "",
        rules: {
            'name': { required: true },
        },
        messages: {
        },
        submitHandler: function (form) {
            var formData = new FormData(form);
            // Call Ajax for Save Data
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: $(form).attr('action'),
                method: 'POST',
                dataType: 'JSON',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('body').find('.spinner-box').show();
                }
            }).done(function (data) {
                $('body').find('.spinner-box').hide();
                if (data.success == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (data.redirect) {
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
        errorElement: 'span',
        errorPlacement: function (error, element) {
            if (element.is("select")) {
                error.insertAfter(element.next('span'));
            } else {
                error.insertAfter(element);
            }
        }

    };

    // Edit Service Modal
    $(document).on('click', '.editService', function () {
        var id = $(this).attr('data-id');
        var check_temp = $(this).attr('check_temp');
        if (check_temp == "edit") {
            $('.loadimg').show();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: 'services/editService',
                type: 'POST',
                data: { 'id': id },
                success: function (data) {
                    $('#service_modal_content').html(data);
                    $('#service_form').validate(clientValidator);
                    $('#ServiceModal').modal('show');
                    $('.loadimg').hide();
                },
                error: function (e) { }
            });
        }
    });
    // End Edit Service Modal

    //Delete Service Modal
    $('body').on('click', '.deleteService', function () {
        var el = $(this);
        var id = $(this).attr('data-id');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete It!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: "POST",
                    dataType: 'JSON',
                    url: "services/" + id,
                    data: { _method: 'delete' },
                    beforeSend: function () {
                        $('body').find('.spinner-box').show();
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                allowOutsideClick: false,
                            }).then((result) => {
                                table.row(el.parents('tr')).remove().draw();
                            });
                        }
                    },
                    complete: function (data) {
                        $('body').find('.spinner-box').hide();
                    }
                });
            }
        });
    });
    //End Service delete Model
});