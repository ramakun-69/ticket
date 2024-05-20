// submit data
var _LOADING = `<div class="w-100 d-flex align-items-center">
            <div class="m-auto d-flex align-items-center">
                ${buildLoadingWhite("20px","20px")} <span class="ms-2">Tunggu sebentar ...</span>
            </div>
        </div>`;
function saveForm(form,url,modal,method = "post",withFile = false){
    var btn = modal.find("#btn-submit");
    var btnOri = btn.html()
    var result = false;
    var validate = false;
    var data = null;
    // validate = validateInput(form,igoneinput);
    resetErrorValidate(form)
    if(withFile){
        data = new FormData(form[0]);
    }else{
        data = form.serialize()+ '&_method=' + method;
    }
    if(true){
        btn.attr('disabled','disabled');
        btn.html(_LOADING)
        var option = {
            type: method,
            url: url,
            data: data,
            dataType: "JSON",
            success: function (response) {
                if(response.status==false){
                    iziToast.warning({
                        title: 'Gagal',
                        message: response.data.message,
                        position: 'bottomCenter'
                    });
                }
                else{
                    modal.modal('hide');
                    if(_DATATABLE){
                        _DATATABLE.ajax.reload()
                    }
                    result = true;
                    iziToast.success({
                        title: 'Success',
                        message: response.data.message,
                        position: 'bottomCenter'
                    });
                }
                resetBtnSubmit(btn,btnOri)
                clearInput(form)

            },
            statusCode: {
                422: function(response) {
                    var data = jsonToArray(response.responseJSON.data);
                    var target
                    data.forEach(function (e) {
                        target = $("#"+e.key);
                        target.addClass("is-invalid");
                        if(target.closest(".input-group").length > 0){
                            target.closest(".input-group").siblings("small.text-danger").remove();
                            target.closest(".input-group").siblings("small.text-danger").after(`<small class="text-danger">${e.value}</small>`);
                        }else{
                            target.siblings("small.text-danger").remove();
                            target.after(`<small class="text-danger">${e.value}</small>`);
                        }
                     })
                     resetBtnSubmit(btn,btnOri)

                },
                500: function(response){
                    iziToast.error({
                        title: 'Failed',
                        message: response.responseJSON.data.error,
                        position: 'bottomCenter'
                    });
                    resetBtnSubmit(btn,btnOri)
                }
            }
        }

        if(withFile){
            option.processData = false
            option.contentType = false
        }
        $.ajax(option).done(function(){
            resetBtnSubmit(btn,btnOri)
            clearInput(form)
       });
    }else{
        console.error("validate false");
    }
    return result;
}

function saveFormNotForModal(form,url,btn,callback = null,update = false,method = "post",withFile = false){
    var btnOri = btn.html()
    var result = false;
    var validate = false;
    var data = null;
    // validate = validateInput(form,igoneinput);
    resetErrorValidate(form)
    if(withFile){
        data = new FormData(form[0]);
    }else{
        data = form.serialize()+ '&_method=' + method;
    }
    if(true){
        btn.attr('disabled','disabled');
        btn.html(_LOADING)
        var option = {
            type: method,
            url: url,
            data: data,
            dataType: "JSON",
            success: function (response) {
                if(response.status==false){
                    iziToast.warning({
                        title: 'Gagal',
                        message: response.data.message,
                        position: 'bottomCenter'
                    });
                }
                else{
                    result = true;
                    iziToast.success({
                        title: 'Success',
                        message: response.data.message,
                        position: 'bottomCenter'
                    });
                }
                resetBtnSubmit(btn,btnOri)
                return "success";
            },
            statusCode: {
                422: function(response) {
                    var data = jsonToArray(response.responseJSON.data);
                    data.forEach(function (e) {
                        var target = $("#"+e.key);
                        target.addClass("is-invalid");
                        if(target.closest(".input-group").length > 0){
                            target.closest(".input-group").siblings("small.text-danger").remove();
                            target.closest(".input-group").siblings("small.text-danger").after(`<small class="text-danger">${e.value}</small>`);
                        }else{
                            target.siblings("small.text-danger").remove();
                            target.after(`<small class="text-danger">${e.value}</small>`);
                        }
                     })
                     resetBtnSubmit(btn,btnOri)
                     if(!update){
                         clearInput(form)
                     }
                     if(callback){
                        callback(data)
                     }
                },
                500: function(response){
                    iziToast.error({
                        title: 'Failed',
                        message: response.responseJSON.data.error,
                        position: 'bottomCenter'
                    });
                    resetBtnSubmit(btn,btnOri)
                    if(!update){
                        clearInput(form)
                    }
                    return "error";
                }
            }
        }
        if(withFile){
            option.processData = false
            option.contentType = false
        }
        $.ajax(option);
    }else{
        console.error("validate false");
    }
    return result;
}
// function validateInput(form,ingoneInputName = []){
//     var output = true;
//     var validateInput = 0;
//     var input = form.find('input');
//     var textarea = form.find('textarea');
//     var select = form.find('select');
//     var allInput = [{el:input,text:'input'},{el:select,text:'select'},{el:textarea,text:'textarea'}];
//     console.log(allInput);
//     allInput.forEach(function(v,i){
//         $.each(v.el, function (indexInArray,element) {
//             var name = element.name;
//             //cek input ignore
//             //jika input ada maka true, jika true maka skip in-valid
//             var ignoreInput = checkInputIgnore(ingoneInputName,name);
//             // jika input type hidden skip
//             if (element.type == "hidden") {
//                 return;
//             }
//             if(!ignoreInput || element.type != "hidden"){

//                 if(element.value == ""){
//                     // array[indexInArray].addClass("is-invalid");
//                     $(v.text+"[name='"+name+"']").addClass("is-invalid");
//                     console.error(v.text+"|"+name);
//                     validateInput++;
//                 }else{
//                     $(v.text+"[name='"+name+"']").removeClass("is-invalid");
//                 }
//             }
//         });
//     })
//     if(validateInput != 0){
//         output = false;
//     }
//     return output;
// }
function checkInputIgnore(inputName = [], name = ""){
    var result = false;
    inputName.forEach(function(item,index){
        if(item == name){
            result = true;
        }
    });
    return result;
}
function resetBtnSubmit(btn,btnOri){
    console.log("reset button");
    btn.removeAttr('disabled');
    btn.empty()
    btn.html(btnOri)
}
function resetErrorValidate(form){
    form.find("select").removeClass("is-invalid");
    form.find("input").removeClass("is-invalid");
    form.find("input").siblings("small.text-danger").remove();
    form.find("select").siblings("small.text-danger").remove();
}
function clearInput(form){
    console.log("clear input");
    console.log(form.find("select"));
    form.find("select").prop("selectedIndex",0);
    form.find("input[type=hidden],input[type=text],input[type=password],input[type=email],input[type=file],textarea").val("");
}
