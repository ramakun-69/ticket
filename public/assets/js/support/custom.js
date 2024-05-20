function jsonToArray(inputObject) {
    const resultArray = Object.entries(inputObject).map(([key, value]) => ({
        key: key,
        value: value
    }));
    return resultArray;
}

function daerah() {
    $('#provinsi').on('change', function() {
        var provinceID = $(this).val();
        if(provinceID) {
            $.ajax({
                url: '/getCourse/'+provinceID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                    if(data){
                        $('#course').empty();
                        $('#course').append('<option hidden>Choose Course</option>');
                        $.each(data, function(key, course){
                            $('select[name="course"]').append('<option value="'+ key +'">' + course.name+ '</option>');
                        });
                    }else{
                        $('#course').empty();
                    }
                }
            });
        }else{
            $('#course').empty();
        }
    });
}
function handleFileInputChange(event,callback) {
    const file = event.target.files[0];
    var dataURL = null;
    if (file) {
      const reader = new FileReader();

      reader.onload = function(event) {
        dataURL = event.target.result;
        callback(dataURL);
      };

      reader.readAsDataURL(file);

    }
}
