jQuery( document ).ready(function() {

var table = {
    
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.users.index') }}",
    columns: [{
            data: 'placeholder',
            name: 'placeholder'
        },
        {
            data: 'id',
            name: 'id'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'email',
            email: 'email'
        },
        // {
        //     data: 'name',
        //     name: 'name'
        // },
        {
            data: 'actions',
            name: '{{ trans("global.actions ") }}'
        }
    ],
    order: [
        [1, 'desc']
    ],
    pageLength: 100,
};
$('body').on('click','.delete-users',function(form){


    var el = $(this);
    var user_id = $(this).attr('id');
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
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: 'JSON',
                url: "users/" + user_id,
                data: {id:user_id,_method: 'delete'},
                beforeSend: function() {
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
                            if(data.redirect){
                                window.location.href = data.redirect;
                            } else {
                                // alert("1");
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
                },
                complete:function(data){
                    $('body').find('.spinner-box').hide();
                }
            });
        }
    });
});
});