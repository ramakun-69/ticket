<div id="modalShift" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                {!! $form !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect"
                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-danger" id="submit-change" type="submit"> {{ __('Save') }} </button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $(document).on('hidden.bs.modal', '#modalShift', function() {
                resetModal();
            })
            $(document).on('show.bs.modal', '#modalShift', function() {
                $(this).find(".modal-title").text(_TITLE_MODAL_INSERT)
            })

            function resetModal() {
                console.log("reset modal");
                clearInput($("#modalShift"))
                $("input").removeClass('is-invalid');
                $("textarea").removeClass('is-invalid');
                $("small.text-danger").remove();
                $(".select2-hidden-accessible").val(null).trigger('change');
                $("#info").addClass("d-none");
            }

            function clearInput(formId) {
                $(formId).find("input[type=file]").each(function() {
                    $(this).wrap('<form>').closest('form').get(0).reset();
                    $(this).unwrap();
                });
                $(formId).find(
                    "input[type=hidden],input[type=text],input[type=password],input[type=email],input[type=datetime-local], textarea, select"
                ).val("");
                $(formId).find("input[type=radio]").prop("checked", false);
            }
            var MODALTITLE = "{{ __('Change Shift') }}"
            $(document).on("click", ".change-shift", function(e) {
                var technicianSelect = $("#technician_id")
                var btn = $(this);
                e.preventDefault();
                var modal = $("#modalShift");
                var htmlThis = $(this);
                var htmlDef = htmlThis.html();
                htmlThis.addClass('disabled');
                htmlThis.toggleClass('d-flex align-items-center');
                htmlThis.html(buildLoadingWhite("15px", "15px"));
                $.ajax({
                    type: "get",
                    url: $(this).attr("href"),
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            technicianSelect.empty().append(
                                "<option value=''>{{ __('Please Select') }}</option>");
                            $.each(response.data.technician, function(key, value) {
                                technicianSelect.append('<option value="' + value.id +
                                    '">' +
                                    value.name + ' | ' + value.shift.name +
                                    '</option>');
                            });
                            // $("#modalShow").find('.btn-close').trigger("click");
                            $("#btn-submit").removeAttr("disabled")
                            $(".invalid").remove();
                            $("input,select").removeClass("is-invalid")
                            $("input,select").siblings("small.text-danger").remove();
                            htmlThis.removeClass("disabled");
                            htmlThis.toggleClass('d-flex align-items-center')
                            htmlThis.html(htmlDef)
                            modal.find("input[name=id]").val(response.data.ticket.id)
                            modal.modal("show");
                        }
                    }
                });
            });
            $("#submit-change").click(function(e) {
                e.preventDefault();
                var btn = $(this);
                var btnOri = btn.html();
                var modal = $("#modalShift");
                btn.attr('disabled', 'disabled');
                btn.html(_LOADING)
                var URLINSERT = "{{ route('ticket.rolling-shift') }}";
                var form = $("#form-changeShift");
                $.ajax({
                    type: "POST",
                    url: URLINSERT,
                    data: form.serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == false) {
                            iziToast.warning({
                                title: 'Gagal',
                                message: response.data.message,
                                position: 'bottomCenter'
                            });
                        } else {
                            modal.modal('hide');
                            if (_DATATABLE) {
                                _DATATABLE.ajax.reload()
                            }
                            result = true;
                            iziToast.success({
                                title: 'Success',
                                message: response.data.message,
                                position: 'bottomCenter'
                            });
                        }
                        resetBtnSubmit(btn, btnOri)
                        clearInput(form)

                    },
                    statusCode: {
                        422: function(response) {
                            var data = jsonToArray(response.responseJSON.data);
                            var target
                            data.forEach(function(e) {
                                target = $("#" + e.key);
                                target.addClass("is-invalid");
                                if (target.closest(".input-group").length > 0) {
                                    target.closest(".input-group").siblings(
                                        "small.text-danger").remove();
                                    target.closest(".input-group").siblings(
                                        "small.text-danger").after(
                                        `<small class="text-danger">${e.value}</small>`
                                    );
                                } else {
                                    target.siblings("small.text-danger").remove();
                                    target.after(
                                        `<small class="text-danger">${e.value}</small>`
                                    );
                                }
                            })
                            resetBtnSubmit(btn, btnOri)

                        },
                        500: function(response) {
                            iziToast.error({
                                title: 'Failed',
                                message: response.responseJSON.data.error,
                                position: 'bottomCenter'
                            });
                            resetBtnSubmit(btn, btnOri)
                        }
                    }

                });
            })
        });
    </script>
@endpush
