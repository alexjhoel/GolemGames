
const loginTab = new bootstrap.Tab("#loginTab")
const registerTab = new bootstrap.Tab("#registerTab")

$("#myaccountLoginButton").click(function(){
    loginTab.show();
})

$("#myaccountRegisterButton").click(function(){
    registerTab.show();
})

$("#myaccountLoginFormButton").click(function() {
    $("#userLoginInput").removeClass("is-invalid");
    $("#passwordLoginInput").removeClass("is-invalid");
    const usuario = $("#userLoginInput").val();
    const clave = $("#passwordLoginInput").val()
    $.ajax({
        url: "./php_tasks/login.php",
        type: "POST",
        data: {
            login_check: true,
            usuario: usuario,
            clave: clave
        },
        success: function(data) {
            console.log(data);
            if(data.every( (val) => val == "ok" )){

                $("#login-form").append("<input name='login' hidden>");
                $("#login-form").append("<input name='usuario' value='"+usuario+"' hidden> ");
                $("#login-form").append("<input name='clave' value='"+clave+"' hidden> ");

                $("#login-form").submit();

                return;
            }

            if(data[0] != "ok"){
                $("#userLoginInput").addClass("is-invalid");
                $("#userLoginInput").siblings(".invalid-feedback").html(data[0]);
            }
            
            if(data[1] != "ok"){
                $("#passwordLoginInput").addClass("is-invalid");
                $("#passwordLoginInput").siblings(".invalid-feedback").html(data[1]);
            }
        }
                       
    });
});

$("#myaccountRegisterFormButton").click(function() {
    $("#userRegisterInput").removeClass("is-invalid");
    $("#passwordRegisterInput").removeClass("is-invalid");
    $("#emailRegisterInput").removeClass("is-invalid");
    $("#termsRegisterCheck").removeClass("is-invalid");
    const usuario = $("#userRegisterInput").val();
    const clave = $("#passwordRegisterInput").val()
    const correo = $("#emailRegisterInput").val()
    const terminos = $("#termsRegisterCheck").is(':checked');

    $.ajax({
        url: "./php_tasks/login.php",
        type: "POST",
        data: {
            register_check: true,
            usuario: usuario,
            correo: correo,
            clave: clave,
            terminos: terminos
        },
        success: function(data) {
            console.log(data);

            if(data.every( (val) => val == "ok" )){
                $("#login-form").append("<input name='register' hidden>");
                $("#login-form").append("<input name='usuario' value='"+usuario+"' hidden> ");
                $("#login-form").append("<input name='clave' value='"+clave+"' hidden> ");
                $("#login-form").append("<input name='correo' value='"+correo+"' hidden> ");
                if(terminos) $("#login-form").append("<input name='terminos' value='true' hidden> ");

                $("#login-form").submit();

                return;
            }

            if(data[0] != "ok"){
                $("#userRegisterInput").addClass("is-invalid");
                $("#userRegisterInput").siblings(".invalid-feedback").html(data[0]);
            }

            if(data[1] != "ok"){
                $("#emailRegisterInput").addClass("is-invalid");
                $("#emailRegisterInput").siblings(".invalid-feedback").html(data[1]);
            }

            if(data[2] != "ok"){
                $("#passwordRegisterInput").addClass("is-invalid");
                $("#passwordRegisterInput").siblings(".invalid-feedback").html(data[2]);
            }

            if(data[3] != "ok"){
                $("#termsRegisterCheck").addClass("is-invalid");
            }
        }
                       
    });
});