@push('js')
    <script>
        var _LOADING = `<div class="w-100 d-flex align-items-center">
            <div class="m-auto d-flex align-items-center">
                ${buildLoadingWhite("20px","20px")} <span class="ms-2">Tunggu sebentar ...</span>
            </div>
        </div>`;
        $(document).ready(function() {
           
            var userId = "{{ Auth::user()->id }}"
            $('#profile-picture').on('change', function(event) {
                var file = event.target.files[0];
                var reader = new FileReader();
                var form = $('#picture-form');
                var formData = new FormData(form[0]);
                console.log(formData)
                $.ajax({
                    type: "POST",
                    url: "{{ route('update-profile-picture') }}",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        iziToast.success({
                            title: 'Success',
                            message: "Foto berhasil diperbarui",
                            position: 'bottomCenter'
                        });
                        reader.onload = function(e) {
                            $('#profile-image').attr('src', '/storage/' + response.foto);
                            $('.foto-profile').attr('src', '/storage/' + response.foto);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
            $('.image-container').on('mouseover', function() {
                $('.logo-overlay').css('opacity', '1');
            });

            $('.image-container').on('mouseout', function() {
                $('.logo-overlay').css('opacity', '0');
            });
            $('#profile-image').on('click', function() {
                $('#profile-picture').click();
            });


            $('#edit-button').click(function(e) {
                e.preventDefault();
                var btn = $(this);
                var btnOri = btn.html()
                $.ajax({
                    type: "PUT",
                    url: "{{ route('profile.update', ':userId') }}".replace(':userId', userId),
                    data: $("#form-profile").serialize(),
                    beforeSend: function() {
                        btn.attr('disabled','disabled');
                        btn.html(_LOADING)
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        iziToast.success({
                            title: 'Sukses',
                            message: "Profile berhasil diperbarui",
                            position: 'bottomCenter',
                            timeout: 1500,
                        });
                        resetBtnSubmit(btn,btnOri)
                        
                        resetErrorValidate($("#form-profile"))
                        updateValue(response)
                        
                    },
                    statusCode: {
                        422: function(response) {
                            var data = jsonToArray(response.responseJSON.data);
                            data.forEach(function (e) {
                                console.log(e.value); // Debugging purposes
                                iziToast.error({
                                title: "{{ __('warning') }}",
                                message: e.value,
                                position: 'bottomCenter',
                                timeout: 1500,
                                })
                            });
                            resetBtnSubmit(btn,btnOri)
                        },
                        500: function(response) {
                            iziToast.error({
                            title: 'Failed',
                            message: response.responseJSON.message,
                            position: 'bottomCenter'
                        });
                            resetBtnSubmit(btn,btnOri)
                        }
                    }
                });
            })
            function updateValue(response)
            {
                $("#username").val(response.username);
                $("#email").val(response.email);
            }
        });
    </script>
@endpush
