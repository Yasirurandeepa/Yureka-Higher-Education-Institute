
function validate_general(fname,lname,useraddress,userbday,gender,usermail,tel,formWarnings){

    var fill = fname.value.length !=0 && lname.value.length !=0 && useraddress.value.length !=0 && userbday.value.length !=0 && usermail.value.length !=0
        && tel.value.length !=0 && gender.selectedIndex !=0;
   // console.log(fname.value);

    if(!fill){
        alert("Please fill all the details !");
        return false;
    }

    normalizeFields_general();

    var fnameCheck = false;
    if(isAlpha(fname.value)){
        fnameCheck = true;
    }else {
        fnameCheck = false;
        fieldColorChange(fname,"red");
        formWarnings[0].innerText = "first name only contain letters";
    }

    var lnameCheck = false;
    if(isAlpha(lname.value)){
        lnameCheck = true;
    }else {
        lnameCheck = false;
        fieldColorChange(lname,"red");
        formWarnings[0].innerText = "last name only contain letters";
    }

    if(!fnameCheck && !lnameCheck){
        fieldColorChange(lname,"red");
        fieldColorChange(fname,"red");
        formWarnings[0].innerText = "first & last name only contain letters";
    }

    //Email Validate
    var mailCheck = false;
    if(usermail.value.indexOf('@')>-1){
        if(usermail.value.indexOf('gmail.com')>-1){
            if((usermail.value.replace('@gmail.com','')).length>0){
                mailCheck = true;
            }else {
                mailCheck = false;
                fieldColorChange(usermail,"red");
                formWarnings[1].innerText = "invalid email address!";
            }

        }else if(fill){
            mailCheck = false;
            fieldColorChange(usermail,"red");
            formWarnings[1].innerText = "please use gmail addresses !";
            //alert("Please use GMAIL address !");
        }
    }
    else if(fill){
        mailCheck = false;
        fieldColorChange(usermail,"red");
        formWarnings[1].innerText = "email must contain @ sign";
        //alert("Invalid Email Address !");
    }

    //Tele Validate
    var telCheck =false;
    if(tel.value.length >0 && tel.value.length==10){
        if(isNumeric(tel.value)) {
            telCheck = true;
        }else {
            formWarnings[3].innerText = "telephone only contain numbers";
            fieldColorChange(tel,"red");
            telCheck = false;
        }
    }else if(fill){
        telCheck = false;
        fieldColorChange(tel,"red");
        formWarnings[2].style.color = "red";
       // alert("Invalid Telephone Number !");
    }

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
   /* var bDayYear = parseInt(userbday.value.substr(0,4));
=======
    var bDayYear = parseInt(userbday.value.substr(0,4));
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
    var bDayYear = parseInt(userbday.value.substr(0,4));
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
    var bDayYear = parseInt(userbday.value.substr(0,4));
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
    //console.log(bDayYear<1990);
    var bDayCheck_1 =false;
    if(bDayYear<=2007){
        bDayCheck_1 = true;
    }else{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        document.getElementById('BDwarning').innerText= 'Oops! just a child';
=======
        document.getElementById('BDwarning').innerText= 'You are a just child';
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
        document.getElementById('BDwarning').innerText= 'You are a just child';
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
        document.getElementById('BDwarning').innerText= 'You are a just child';
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
        fieldColorChange(userbday,"red");
    }
    var bDayCheck_2 =false;
    if(bDayYear>=1990) {
        bDayCheck_2 = true;
    }else{
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        document.getElementById('BDwarning').innerText= 'Oops! too old';
=======
        document.getElementById('BDwarning').innerText= 'You are too old';
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
        document.getElementById('BDwarning').innerText= 'You are too old';
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
        document.getElementById('BDwarning').innerText= 'You are too old';
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
        fieldColorChange(userbday,"red");
    }

    var bDayCheck = false;
    if(bDayCheck_1 && bDayCheck_2){
        bDayCheck = true;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    }*/

    return fill &&fnameCheck && lnameCheck && mailCheck && telCheck ;
=======
    }

    return fill &&fnameCheck && lnameCheck && mailCheck && telCheck && bDayCheck;
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
    }

    return fill &&fnameCheck && lnameCheck && mailCheck && telCheck && bDayCheck;
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a
=======
    }

    return fill &&fnameCheck && lnameCheck && mailCheck && telCheck && bDayCheck;
>>>>>>> d184dd4cfc38c1e43d2aeda89f18e2bc678ed50a


}

function validate_signup(validated,userbday,pass,cmfpass,agree,agreeStatement){
    normalizeFields_signup();
    var fill = validated && pass.value.length !=0 && cmfpass.value.length !=0;
    if(fill && pass.value.length ==0 && cmfpass.value.length ==0){
        alert("Please fill all the details !");
        return false;
    }

    var bDayYear = parseInt(userbday.value.substr(0,4));
    //console.log(bDayYear<1990);
    var bDayCheck_1 =false;
    if(bDayYear<=2007){
        bDayCheck_1 = true;
    }else{
        document.getElementById('BDwarning').innerText= 'Oops! just a child';
        fieldColorChange(userbday,"red");
    }
    var bDayCheck_2 =false;
    if(bDayYear>=1990) {
        bDayCheck_2 = true;
    }else{
        document.getElementById('BDwarning').innerText= 'Oops! too old';
        fieldColorChange(userbday,"red");
    }

    var bDayCheck = false;
    if(bDayCheck_1 && bDayCheck_2){
        bDayCheck = true;
    }

    // Password == Con Pass
    var passCheck = false;
    if(pass.value.trim().length>=8) {
        if (pass.value === cmfpass.value) {
            passCheck = true;
        } else if (fill) {
            passCheck = false;
            fieldColorChange(pass,"red");
            fieldColorChange(cmfpass,"red");
            formWarnings[4].innerText = "password mismatched !";
            //alert("Password mismatched !");
        }
    }else if(fill){
        passCheck = false;
        fieldColorChange(pass,"red");
        fieldColorChange(cmfpass,"red");
        formWarnings[4].innerText = "password must have 8-16 digits without whitespaces !";
        //alert("Password must have 8-16 digits !");
    }

    var agreeCheck;
    if(agree.checked){
        agreeCheck = true;
    }
    else if(fill){
        agreeCheck = false;
        agreeStatement.style.color = '#ff0000';
    }

    if(fill && passCheck && agreeCheck && bDayCheck){
        document.getElementById('id01').style.display='block';
    }else {
        pass.value = "";
        cmfpass.value = "";
        agree.checked = false;
        fieldColorChange(pass,"red");
        fieldColorChange(cmfpass,"red");
        agreeStatement.style.color = '#ff0000';
        innerJump("signup");
    }
}

function validate_update(validated,jumpLink){
    if(validated){
        document.getElementById('id01').style.display='block';
    }else {
        innerJump(jumpLink);
    }
}

function fieldColorChange(tagId,color){
    tagId.style.borderColor = color;
    tagId.style.boxShadow = color;
}

function normalizeFields_general() {
     fieldColorChange(fname,"");
    fieldColorChange(lname,"");
    fieldColorChange(useraddress,"");
    fieldColorChange(userbday,"");
    fieldColorChange(usermail,"");
    fieldColorChange(tel,"");
    fieldColorChange(gender,"");


    for(var i =0;i<formWarnings.length;i++){
        if(i!=2) {
            formWarnings[i].innerText = '';
        }else {
            formWarnings[i].style.color = 'black';
        }
    }

}

function normalizeFields_signup(){
    fieldColorChange(pass,"");

    fieldColorChange(cmfpass,"");

    agreeStatement.style.color = "";
}

function isNumeric(input) {
    return !isNaN(parseFloat(input)) && isFinite(input);
}

function isAlpha(input){
   return /^[a-zA-Z]*$/.test(input);
}

function innerJump(id){
    var url = location.href;               //Save down the URL without hash.
    location.href = "#"+id;                 //Go to the target element.
    history.replaceState(null,null,url);   //Don't like hashes. Changing it back.
}


////////////////////////Send Notification Panel //////////////////////////////////////
function notificationCrear(receiver,msg){
    receiver.selectedIndex = 0;
    msg.value = '';
}

function noticeCheck(not){
    fieldColorChange(not,'');
    if(not.value.trim().length>0){
        return  true;
    }else{
        not.value = '';
        fieldColorChange(not,'red');
        return false;
    }

}
////////////////////////Send Notification Panel //////////////////////////////////////

////////////////////////Change pass validations //////////////////////////////////////

function changePassBtnOnclick(current,newPass,cmfNewPass,warn){
    fieldColorChange(current,'');
    fieldColorChange(newPass,'');
    fieldColorChange(cmfNewPass,'');
    warn.style.color = '';
    warn.innerText = '(*password must have 8-16 digits)';

    if( current.value.trim().length>0){
        if(newPass.value.trim().length>=8){
            if(cmfNewPass.value==newPass.value){
                return true;
            }else{
                warn.innerText = 'Password mismatched!';
                warn.style.color = 'red';
                fieldColorChange(newPass,'red');
                fieldColorChange(cmfNewPass,'red');
                return false;
            }
        }else{
            warn.style.color = 'red';
            fieldColorChange(newPass,'red');
            fieldColorChange(cmfNewPass,'red');
            return false;
        }
    }else{
        fieldColorChange(current,'red');
        return false;
    }

}

////////////////////////Change pass validations //////////////////////////////////////