/**Validate the form with the remote, return false if the validation fails, anyhows return true*/
const validate = async function(e){
        const formElement = $(e.target);
        const validationUrl = formElement.attr("validate-action")
        const validationMethod = formElement.attr("validate-method")
        if(!validationUrl || !validationMethod) return false;

        const inputList = formElement.find(":input").toArray();

        inputList.forEach(function(e){
            $(e).removeClass("is-invalid")
            $(e).removeClass("is-valid")
        })

        var dataToValidate = new FormData(e.target);

        var validationResult = true;
        formElement.children(".submit-button").attr("disabled", true);
        await $.ajax({
            url: validationUrl,
            type: validationMethod,
            data: dataToValidate,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                if(!formElement.hasClass("show-progress")) return xhr;
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        $("#form-progress-bar").css("width", (percentComplete * 100) + "%")
                    }
               }, false);
        
               xhr.addEventListener("progress", function(evt) {
                   if (evt.lengthComputable) {
                       var percentComplete = evt.loaded / evt.total;
                       //Do something with download progress
                   }
               }, false);
        
               return xhr;
            },
            success: function(data) {
                const elementsIndexes = Object.fromEntries(inputList.map((e, i) => (  [$(e).attr("name"), e])))
                
                console.log(data);
                
                Object.keys(data).forEach((k) => {
                    if(data[k] && data[k] != "ok" && elementsIndexes[k]){
                        $(elementsIndexes[k]).addClass("is-invalid")
                        $(elementsIndexes[k]).siblings(".invalid-feedback").html(data[k])
                    }else if(data[k] && data[k] == "ok" && elementsIndexes[k]){
                        $(elementsIndexes[k]).addClass("is-valid")
                    }
                    validationResult = data[k] && data[k] == "ok" && validationResult;
                })
            },
            error: function(error){
                $("#form-progress-bar").css("width", "0%")
                console.log(error);
                validationResult = false;
            },
            
                        
        })
        if(validationResult){
            if(formElement.attr("redirect-action")){
                window.location.href = formElement.attr("redirect-action");
                return;
            }
                
            formElement.off();
            formElement.submit();
        }else{
            
            $("#form-progress-bar").css("width", 0 + "%")
            formElement.children(".submit-button").attr("disabled", false);
        }

    }

const formList = $('.form-validator')
formList.on("submit", function(e) {validate(e); return false;});

