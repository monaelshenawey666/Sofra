$(document).on('click','.destroy',function(){
    var route   = $(this).data('route');
    var token   = $(this).data('token');
    $.confirm({
        icon                : 'glyphicon glyphicon-floppy-remove',
        animation           : 'rotateX',
        closeAnimation      : 'rotateXR',
        title               : 'تأكد عملية الحذف',
        autoClose           : 'cancel|6000',
        text             : 'هل أنت متأكد من الحذف ؟',
        confirmButtonClass  : 'btn-outline',
        cancelButtonClass   : 'btn-outline',
        confirmButton       : 'نعم',
        cancelButton        : 'لا',
        dialogClass			: "modal-danger modal-dialog",
        confirm: function () {
            $.ajax({
                url     : route,
                type    : 'post',
                data    : {_method: 'delete', _token :token},
                dataType:'json',
                success : function(data){
                    if(data.status == 0)
                    {
                        //toastr.error(data.msg)
                        swal("خطأ!", data.msg, "error")
                    }else{
                        $("#removable"+data.id).remove();
                        swal("أحسنت!", data.msg, "success")
                        //toastr.success(data.msg)
                    }
                }
            });
        },
    });
});
