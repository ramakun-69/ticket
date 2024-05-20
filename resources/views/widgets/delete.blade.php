@push('js')
<script>

$(document).on('click','.delete',function (e) {
    var btn = $(this);
    e.preventDefault();
    var type = $(this).data('type')

    $.confirm({
        title: '<label class="text-dark">{{__("Delete")}}</label>',
        content: '<label class="text-dark">{{__("Confirm Delete")}}</label>',
        buttons: {
            confirm: {
                text: '{{ __("Sure") }}',
                btnClass: 'btn-danger',
                action: function () {
                    var callback = null
                    if(type == 'redirect'){
                        var redirect = btn.data('redirect')
                        callback = function(){
                            // console.log(redirect);
                            window.location.href = redirect;
                        }
                    }
                    deleteData(btn.attr('href'),'post',{_method:'delete'},btn,callback);
                    return;
                }
            },
            cancel:{
                text: '{{__("Cancel")}}',
                action:function () {return;}
            }
        }
    });
});

function deleteData(url,type = "get",method = null,btn,callback = null){
    btn.html(buildLoadingWhite("15px","15px"))
    btn.addClass('disabled')
    $.ajax({
        type: type,
        url: url,
        data : method,
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                console.log(@json($dt));
                if(@json(isset($dt) ? $dt : false)){
                    _DATATABLE.ajax.reload()
                }
                
                btn.removeClass('disabled');
                iziToast.success({
                    title: 'Success',
                    message: response.data.message,
                    position: 'bottomCenter'
                });
                console.log(callback);
                if(callback){
                    callback()
                }
            }
        }
    });
}

</script>
@endpush
