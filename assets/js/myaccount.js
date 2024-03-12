
const loginTab = new bootstrap.Tab("#loginTab")
const registerTab = new bootstrap.Tab("#registerTab")

$("#myaccountLoginButton").click(function(){
    loginTab.show();
})

$("#myaccountRegisterButton").click(function(){
    registerTab.show();
})