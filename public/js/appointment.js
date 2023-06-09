var appointmentValidator;//Declare Global Variable For Appointment
jQuery(document).ready(function () {
    //Define Appointment Datatable
    var table = $('#appointment-datatable').DataTable({
        "dom": 'B<"top">rt<"bottom"ip><"clear">',
        ajax: {
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            'type': 'POST',
            'url': 'clients/index',
        },
        serverSide: true,
        processing: false,
        responsive: true,
        aaSorting: [[0, "asc"]],
        pageLength: 100,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'actions', name: 'actions' },
        ],
    });
    //Appointment datatable End

    // Appointment Modal Open and validate function also declare
    $('body').on('click', '#add_appointment', function () {
        $('.loadimg').show();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: 'appointments/addAppointment',
            type: 'POST',
            success: function (data) {
                $('#appointment_modal_content').html(data);
                $('#appointment_form').validate(appointmentValidator); //Use Global Variable
                $('#AppointmentModal').modal('show');
                $('.loadimg').hide();
            },
            error: function (e) { }
        });
    });
    // End Add Appointment Modal
    // User Variable 
    appointmentValidator = {
        invalidHandler: function (event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                $('span.error').hide();
            }
        },
        ignore: "",
        rules: {
            'client':{required:true},
            'start_time': { required: true },
            'finish_time': { required: true},
            'services': { required: true},
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

    // Edit Appointment Modal
    $(document).on('click', '.editAppointment', function () {
        var id = $(this).attr('data-id');
        var check_temp = $(this).attr('check_temp');
        if (check_temp == "edit") {
            $('.loadimg').show();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: 'appointments/editAppointment',
                type: 'POST',
                data: { 'id': id },
                success: function (data) {
                    $('#appointment_modal_content').html(data);
                    $('#appointment_form').validate(appointmentValidator);
                    $('#AppointmentModal').modal('show');
                    $('.loadimg').hide();
                },
                error: function (e) { }
            });
        }
    });
    // End Edit Appointment Modal

    //Delete Appointment Modal
    $('body').on('click', '.deleteClient', function () {
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
                    url: "clients/" + id,
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
    //End Appointment delete Model


    //Datepicker
    $(".datetimepicker").each(function () {
        $(this).datetimepicker();
      });

    $('.date').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'en'
      })
    
      $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'en',
        sideBySide: true,
        stepping: 15
      })
    
      $('.timepicker').datetimepicker({
        format: 'HH:mm:ss'
      })
    
      $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
      })
      $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
      })
    
      $('.select2').select2()
    
      $('.treeview').each(function () {
        var shouldExpand = false
        $(this).find('li').each(function () {
          if ($(this).hasClass('active')) {
            shouldExpand = true
          }
        })
        if (shouldExpand) {
          $(this).addClass('active')
        }
      })
});