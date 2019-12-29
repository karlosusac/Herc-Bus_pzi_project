function validateForm(someFunction){
    var isOkay = someFunction();
        if(isOkay == false){
            return false;
        }
}

function isPassOk(){
    var passInput = document.getElementsByName("password")[0];
    var confPassInput = document.getElementsByName("conPassword")[0];

    if((passInput.value != confPassInput.value) && (passInput.value != "")){
        passInput.classList.add("is-invalid");
        confPassInput.classList.add("is-invalid");
        return(false);
    }else{
        passInput.classList.remove("is-invalid");
        confPassInput.classList.remove("is-invalid");
    }
}