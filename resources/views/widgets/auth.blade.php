@push('js')
    <script>
        var _LOADING = `<div class="w-100 d-flex align-items-center">
            <div class="m-auto d-flex align-items-center">
                ${buildLoadingWhite("20px","20px")} <span class="ms-2">Tunggu sebentar ...</span>
            </div>
        </div>`;
        $("[type=submit]").click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var btnOri = btn.html()
            var form = $("form");
            var option = {
                type: "post",
                url: form.attr('action'),
                data: form.serialize(),
                dataType: "JSON",
                beforeSend:function(){
                    btn.addClass('disabled');
                    btn.html(_LOADING)
                },
                success: function (response) {
                    console.log(response);
                    iziToast.success({
                        title: 'Sukses',
                        message: response.message,
                        position: 'bottomCenter',
                        timeout : 1500,
                        onClosed: function () {
                            window.location.href = response.redirect;
                        }
                    });
                },
                statusCode:{
                    422: function(response) {
                        var data = jsonToArray(response.responseJSON.errors);
                    
                    data.forEach(function (e) {
                        $("[name='"+e.key+"']").addClass("is-invalid");
                        $("[name='"+e.key+"']").siblings("small.text-danger").remove();
                        $("[name='"+e.key+"']").after(`<small class="text-danger invalid">${e.value}</small>`);
                    })
                    resetBtnSubmit(btn,btnOri)
                },
                500: function(response){
                    console.log(response);
                    iziToast.error({
                        title: 'Failed',
                        message: response.responseJSON.data.error,
                        position: 'bottomCenter'
                    });
                    resetBtnSubmit(btn,btnOri)
                },
                204: function(response){
                    console.log(response);
                    iziToast.error({
                        title: 'success',
                        message: response.responseJSON.data.error,
                        position: 'bottomCenter'
                    });
                    resetBtnSubmit(btn,btnOri)
                    }
                }
            };
            resetErrorValidate(form)
            $.ajax(option).done(function(){
                setTimeout(function(){
                    resetBtnSubmit(btn,btnOri)
                }, 5000)
                console.log("complete");
            });
        });

        function jsonToArray(inputObject) {
            const resultArray = Object.entries(inputObject).map(([key, value]) => ({
                key: key,
                value: value
            }));
            return resultArray;
        }
        function resetBtnSubmit(btn,btnOri){
            btn.removeClass('disabled');
            btn.empty()
            btn.html(btnOri)
        }
        function resetErrorValidate(form){
            form.find("input").removeClass("is-invalid");
            form.find("input").siblings("small.text-danger").remove();
        }
    </script>
@endpush