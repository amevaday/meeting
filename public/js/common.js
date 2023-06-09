function handleModal(modalId, _URL, modelContentContainerId, formId, formValidator, type){
    
    return new Promise((resolve) => {
     
        $.ajax({
            url: _URL,
            type: 'POST',
            dataType: 'JSON',
            data: { 'type': type },
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if (response.status != undefined && response.status == 'success') {
                $(modelContentContainerId).html(response.data)
                $(formId).validate(formValidator)
                $(modalId).modal('show')
            }
        })
        resolve(true)
    })
}