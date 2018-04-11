
//Globals
var currentUser = null;

$(document).ready(function() {
    toggleLoginLogoffItems(false);
});

//
function toggleLoginLogoffItems(loggedin) {
    if(loggedin == true){
        $('.loggedOn').show();
        $('.loggedOff').hide();
    } else {// login = false 
        $('.loggedOn').hide();
        $('.loggedOff').show();
    }
}

$('#logoutNavItem').on("click", function() {
    currentUser = null;
    toggleLoginLogoffItems(false);
});

$('#loginButton').on('click', function() {
    $.ajax({
        url: 'login.php',
        type: 'POST',
        data:   {
                    username:   $("#username").val(),
                    password:   $("#password").val()
                },
        dataType: 'html',
        success:    function(data){

                        try {
                            data = JSON.parse(data);
                            alert("success");
                            currentUser = data.user[0];
                                $("#username").val("");
                                $("#password").val("");
                            toggleLoginLogoffItems(true);
                            $("#homeNavItem").click();
                        } catch (ex) {
                                alert(ex);
                        }


        },
        error: 	    function (xhr, ajaxOptions, thrownError) {
            alert("-ERROR:" + xhr.responseText + " - " + 
            thrownError + " - Options" + ajaxOptions);
        }
    });
});

$('#signUpButton').on('click', function() {
    if($('#signUpPassword').val() != $('#signUpConfirmPassword').val()) {
        alert("Passwords must match");
         // evt.preventDefault();
        return ;
    }

    $.ajax({
        url: 'signup.php',
        type: 'POST',
        data:	{
                    username:   $("#signUpUsername").val(), 
                    name:       $("#signUpName").val(),
                    email:      $("#signUpEmail").val(),
                    password:   $("#signUpPassword").val()
                },
        dataType: 'html',
        success:	function(data){

                        try { //make this work for login
                            data = JSON.parse(data);
                            alert("success");
                            currentUser = data.user[0]; // set the currentUser to the global variable
                                $("#signUpUsername").val(""); 
                                $("#signUpName").val("");
                                $("#signUpEmail").val("");
                                $("#signUpPassword").val("");
                                $("#signUpConfirmPassword").val("");
                            toggleLoginLogoffItems(true);
                            $("#homeNavItem").click();
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});

$('#manageButton').on('click', function() {
    if($('#managePassword').val() != $('#manageConfirmPassword').val()) {
        alert("Passwords must match");
         // evt.preventDefault();
        return ;
    }

    $.ajax({
        url: 'manage.php',
        type: 'POST',
        data:	{
                    username:   $("#manageUsername").val(), 
                    name:       $("#manageName").val(),
                    email:      $("#manageEmail").val(),
                    ID:         $("#manageID").val()
                },
        dataType: 'html',
        success:	function(data){

                        try {
                            data = JSON.parse(data);
                            alert("Record updated succesfully");
                            currentUser = data.user[0]; // set the currentUser to the global variable
                                $("manageUsername").val(""); 
                                $("#manageName").val("");
                                $("#manageEmail").val("");
                                $("#manageID").val("");

                            $("#homeNavItem").click();
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    }
    });    		
});


$("#manageAccountNavItem").on("click", function() {

    $("#manageUsername").val(currentUser.username);
    $("#manageName").val(currentUser.name);
    $("#manageEmail").val(currentUser.email);
    $("#manageID").val(currentUser.ID);

});


