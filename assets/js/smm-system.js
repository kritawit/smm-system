$(function() {
    $("#title_warning").hide();
    var options = {
        // target:        '#',   // target element(s) to be updated with server response 
        beforeSubmit: validate, // pre-submit callback 
        success: function(data) {
            if(data == 'fail'){
                $("#title_warning").show();
                $("#warning_user").addClass('form-group has-error');
                $("#warning_pass").addClass('form-group has-error');
                $("#warning_location").addClass('form-group has-error');
            }else{
                $("body").html(data);
                location.reload();
                $("#title_warning").hide();
                $("#warning_user").removeClass('form-group has-error');
                $("#warning_user").addClass('form-group');
                $("#warning_pass").removeClass('form-group has-error');
                $("#warning_pass").addClass('form-group');
                $("#warning_location").removeClass('form-group has-error');
                $("#warning_location").addClass('form-group');
            }
        }, // post-submit callback 

        url: 'main/login', // override for form's 'action' attribute 
        type: 'POST',        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        // clearForm: true, // clear all form fields after successful submit 
        resetForm: true, // reset the form after successful submit 
            // $.ajax options can be used here too, for example: 
            //timeout:   3000
    };
    // bind to the form's submit event
    $('#frmLogin').submit(function() {
        // inside event callbacks 'this' is the DOM element so we first 
        // wrap it in a jQuery object and then invoke ajaxSubmit 
        $(this).ajaxSubmit(options);
        // !!! Important !!! 
        // always return false to prevent standard browser submit and page navigation 
        return false;
    });

    function validate() {
        var user = $("#username").val();
        var pass = $('#password').val();
        var location = $("#location").val();
        if (user == '' || pass == '') {
            $("#warning_user").addClass('form-group has-error');
            $("#warning_pass").addClass('form-group has-error');
            $("#title_warning").show();
            return false;
        } else {
            $("#title_warning").hide();
            $("#warning_user").removeClass('form-group has-error');
            $("#warning_user").addClass('form-group');
            $("#warning_pass").removeClass('form-group has-error');
            $("#warning_pass").addClass('form-group');
        }
        if (location == '') {
            $("#warning_location").addClass('form-group has-error');
            $("#title_warning").show();
            return false;
        } else {
            $("#title_warning").hide();
            $("#warning_location").removeClass('form-group has-error');
            $("#warning_location").addClass('form-group');
        }
    }
});
