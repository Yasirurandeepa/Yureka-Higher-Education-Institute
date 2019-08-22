/**
 * Created by user on 7/6/2017.
 */

/////////////////// Validations for Update Data////////////////////////////////

var fname = document.getElementById('ofirstName');
var lname = document.getElementById('olastName');
var useraddress = document.getElementById('oaddress');
var userbday = document.getElementById('obDay');
var gender = document.getElementById('ogender');
var usermail = document.getElementById('oemail');
var tel= document.getElementById('otelephoneNo');
var formWarnings = document.getElementsByClassName('warning');

function updateValidationOnclick() {
    validate_update(validate_general(fname,lname,useraddress,userbday,gender,usermail,tel,formWarnings),"oupdateDetails");
}

/////////////////// Validations for Update Data////////////////////////////////

/////////////////// Validations for courses////////////////////////////////
var sub = document.getElementById('subject');
var teach = document.getElementById('teacherSelect');
function addCourseOnClick(){

    fieldColorChange(sub,"");
    fieldColorChange(teach,"");

    var subCheck = false;
    if(sub.value.trim().length>0){
        subCheck = true;
    }else{
        subCheck = false;
        fieldColorChange(sub,"red");
    }

    var teaCheck = false;
    if(teach.selectedIndex>0){
       teaCheck=true;
    }else{
        teaCheck = false;
        fieldColorChange(teach,"red");
    }

    if(subCheck && teaCheck){
        document.getElementById('validateAddCourse').style.display='block';
    }
}


////////////////////////////// Delete btn onclick///////////////////////

var delSub = document.getElementById('deleteSub');
var delTeach = document.getElementById('deleteTeacher');
var delDay = document.getElementById('deleteDay');

function deleteOnClick() {

    fieldColorChange(delSub,"");
    fieldColorChange(delTeach,"");
    fieldColorChange(delDay,"");

    var delSubCheck = false;
    if(delSub.selectedIndex>0){
        delSubCheck = true;
    }else{
        delSubCheck = false;
        fieldColorChange(delSub,"red");
    }

    var delTeachCheck = false;
    if(delTeach.selectedIndex>0){
        delTeachCheck = true;
    }else{
        delTeachCheck = false;
        fieldColorChange(delTeach,"red");
    }

    var delDayCheck = false;
    if(delDay.selectedIndex>0){
        delDayCheck = true;
    }else{
        delDayCheck = false;
        fieldColorChange(delDay,"red");
    }

    if(delSubCheck && delTeachCheck && delDayCheck){
        document.getElementById('deleteCourse').style.display='block';
    }
}

////////////////////////////// Delete btn///////////////////////

/////////////////// Validations for courses////////////////////////////////

/////////////////////////// validations for add teacher /////////////////
var atfname = document.getElementById('atfirstName');
var atlname = document.getElementById('atlastName');
var atuseraddress = document.getElementById('ataddress');
var atuserbday = document.getElementById('atbDay');
var atgender = document.getElementById('atgender');
var atusermail = document.getElementById('atemail');
var attel= document.getElementById('attelephoneNo');
var atformWarnings = document.getElementsByClassName('atwarning');

function atValidationOnclick() {
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
    if(bDayYear>=1960) {
        bDayCheck_2 = true;
    }else{
        document.getElementById('BDwarning').innerText= 'Oops! too old';
        fieldColorChange(userbday,"red");
    }

    var bDayCheck = false;
    if(bDayCheck_1 && bDayCheck_2){
        bDayCheck = true;
    }
    if(validate_general(atfname,atlname,atuseraddress,atuserbday,atgender,atusermail,attel,atformWarnings)&&bDayCheck){
        document.getElementById('atdatasection').style.display = 'none';
        document.getElementById('atindex').style.display = 'block';
        innerJump(document.getElementsByClassName('nav'));
    }
}

/////////////////////// Advertiesment//////////////////////////////
var addfile = document.getElementById('addFileSelect');
var addhoverDesc=document.getElementById('addImageDesc');
var addDesc =document.getElementById('addDescription') ;

function addAddOnClick(){
    fieldColorChange(addDesc,'');
    fieldColorChange(addhoverDesc,'');
    addfile.style.color = '';

    var addfileCheck = false;
    if(addfile.files.length>0){
        addfileCheck = true;
    }else{
        addfileCheck = false;
        addfile.style.color = 'red';
    }

    var addImageDescCheck = false;
    if(addhoverDesc.value.trim().length>0){
        addImageDescCheck = true;
    }else{
        addImageDescCheck = false;
        fieldColorChange(addhoverDesc,'red');
    }

    var addDescCheck = false;
    if(addDesc.value.trim().length>0){
        addDescCheck = true;
    }else{
        addDescCheck = false;
        fieldColorChange(addDesc,'red');
    }

    if(addfileCheck && addImageDescCheck && addDescCheck){
        document.getElementById('addpasswordSection').style.display = 'block';
    }
}

function addClrOncilck(){
    addfile.value = addfile.defaultValue;
    addhoverDesc.value = "";
    addDesc.value = "";
}
