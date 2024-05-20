<div id="modalForm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog {{ $type }}">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                {!! $form !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">{{__("Close")}}</button>
                <button class="btn btn-danger" id="btn-submit" type="submit"> {{__("Save")}} </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    var _TITLE_PAGE = "{{$title}}";
    var _TITLE_MODAL_INSERT = `{{ __('Add') }} `+_TITLE_PAGE;
    var _TITLE_MODAL_UPDATE = `{{ __('Edit') }} `+_TITLE_PAGE;
$(document).ready(function () {
    var modalFormId = $('#modalForm form').attr('id');
    $("#"+modalFormId).on('keydown', function(event) {
        var focusedElement = $(document.activeElement);
        if (event.key === 'Enter' && focusedElement.is('textarea') === false) {
            event.preventDefault();
        }
    });
    
});
$(document).on('hidden.bs.modal','#modalForm', function () {
    resetModal();
})
$(document).on('show.bs.modal','#modalForm', function () {
    $(this).find(".modal-title").text(_TITLE_MODAL_INSERT)
})
function resetModal(){
    console.log("reset modal");
    clearInput($("#modalForm"))
    $("input").removeClass('is-invalid');
    $("textarea").removeClass('is-invalid');
    $("small.text-danger").remove();
    $(".select2-hidden-accessible").val(null).trigger('change');
    $("#info").addClass("d-none");
}
function clearInput(formId){
    $(formId).find("input[type=file]").each(function() {
        $(this).wrap('<form>').closest('form').get(0).reset();
        $(this).unwrap();
    });
    $(formId).find("input[type=hidden],input[type=text],input[type=password],input[type=email],input[type=datetime-local], textarea, select").val("");
    $(formId).find("input[type=radio]").prop("checked", false);
}

$(document).on('click','.edit',function(e){
    var modal = $("#modalForm");
    var htmlThis = $(this);
    var htmlDef = htmlThis.html();
    htmlThis.addClass('disabled');
    htmlThis.toggleClass('d-flex align-items-center');
    htmlThis.html(buildLoadingWhite("15px","15px"));
    e.preventDefault();
    $.ajax({
        type: "get",
        url: $(this).attr("href"),
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                $("#modalShow").find('.btn-close').trigger("click");
                attactEdit(modal,response)
                $("#btn-submit").removeAttr("disabled")
                $(".invalid").remove();
                $("input,select").removeClass("is-invalid")
                $("input,select").siblings("small.text-danger").remove();
                htmlThis.removeClass("disabled");
                htmlThis.toggleClass('d-flex align-items-center')
                htmlThis.html(htmlDef)
                modal.modal("show");
                modal.find(".modal-title").text(_TITLE_MODAL_UPDATE);
            }
        }
    });
});

$(document).on('click','.btn-show',function(e){
    var modal = $("#modalShow");
    var htmlThis = $(this);
    var htmlDef = htmlThis.html();
    htmlThis.addClass('disabled');
    htmlThis.toggleClass('d-flex align-items-center')
    htmlThis.html(buildLoading("15px","15px"))
  
    e.preventDefault();
    $.ajax({
        type: "get",
        url: $(this).attr("href"),
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                // attactShow(modal,response)
                $("#btn-submit").removeAttr("disabled")
                $(".invalid").remove();
                $("input,select").removeClass("is-invalid")
                $("input,select").siblings("small.text-danger").remove();
                htmlThis.removeClass("disabled");
                htmlThis.toggleClass('d-flex align-items-center')
                htmlThis.html(htmlDef)
                modal.modal("show");
            }
        }
    });
});
</script>
@endpush