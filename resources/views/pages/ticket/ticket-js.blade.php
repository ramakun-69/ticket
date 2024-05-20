@push('js')
<script>
    var _URL_INSERT = "{{ route('ticket.store') }}";
    var _TITLE_MODAL_UPDATE = `{{ __('Confirm') }} `+_TITLE_PAGE;
    function attactEdit(modal,response){
        var selectElement = modal.find("select[name=asset_id]");
        var newOption = $("<option></option>")
                        .attr("value", response.data.asset_id)
                        .text(response.data.asset.name)
                        .prop("selected", true);
        var locationValue = response.data.type == "produksi" ? response.data.asset.location.name : response.data.asset.user.pegawai.name;
      $("#input-type").addClass("d-none");
      modal.find("input[name=id]").val(response.data.id);
      modal.find("input[name=type]").val(response.data.type).prop("checked", true);
      modal.find("select[name=asset_id]").append(newOption);
      modal.find("input[name=serial_number]").val(response.data.asset.code);
      modal.find("input[name=location]").val(locationValue);
      modal.find("input[name=damage_time]").val(response.data.damage_time);
      modal.find("select[name=condition]").val(response.data.condition);
      modal.find("textarea[name=description]").val(response.data.description);
      $("#spare-part-div").toggleClass("d-none", response.data.type !== 'produksi');
      $(".disabled-input").prop("disabled", true);
      $("#asset_id").prop("disabled", true);
      $("#info").removeClass("d-none");
      $("#approve-atasan").removeClass("d-none");
      $("#approval-atasan-teknik").removeClass("d-none");
      $("#input-teknisi").removeClass("d-none");
  }
    $("#btn-submit").click(function(e){
      e.preventDefault();
      saveForm($('#form-ticket'),_URL_INSERT, $('#modalForm'));
    });
    $(document).on("click", ".confirm" ,function(e){
      var btn = $(this);
      e.preventDefault();
      $.confirm({
        title: 'Konfirmasi',
        content: 'Apakah Anda yakin ingin menyetujui?',
        buttons: {
            confirm: {
                text: '{{ __("Approve") }}',
                btnClass: 'btn-success',
                action : function () {
                  approveTicket(btn.attr('href'),'put',btn);
                    return;
                }
            },
            cancel: {
                text:'{{ __("Reject") }}',
                btnClass: 'btn-danger',
                action : function () {
                  rejectTicket(btn.attr('href'),'put',btn);
                    return;
              }
            }
        }
      });
    });
    $(document).on("click", ".close" ,function(e){
      var btn = $(this);
      e.preventDefault();
      $.confirm({
        title: 'Konfirmasi',
        content: 'Apakah Anda yakin ingin menutup ticket?',
        buttons: {
            confirm: {
                text: '{{ __("Sure") }}',
                btnClass: 'btn-success',
                action : function () {
                  closeTicket(btn.attr('href'),'put',btn);
                    return;
                }
            },
            cancel: {
                text:'{{ __("Cancel") }}',
                btnClass: 'btn-danger',
                action : function () {return;}
            }
        }
      });
    });

  function approveTicket(url,method = null,btn,callback = null){
    btn.html(buildLoadingWhite("15px","15px"))
    btn.addClass('disabled')
    $.ajax({
        type: method,
        url: url,
        data : {
          type : "approve",
          id : btn.data('id')
        },
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                _DATATABLE.ajax.reload()
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
  function rejectTicket(url,method = null,btn,callback = null){
    btn.html(buildLoadingWhite("15px","15px"))
    btn.addClass('disabled')
    $.ajax({
        type: method,
        url: url,
        data : {
          type : "reject",
          id : btn.data('id')
        },
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                _DATATABLE.ajax.reload()
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
  function closeTicket(url,method = null,btn,callback = null){
    btn.html(buildLoadingWhite("15px","15px"))
    btn.addClass('disabled')
    $.ajax({
        type: method,
        url: url,
        data : {
          id : btn.data('id')
        },
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                _DATATABLE.ajax.reload()
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