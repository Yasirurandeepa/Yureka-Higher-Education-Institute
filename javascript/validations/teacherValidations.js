/**
 * Created by user on 7/8/2017.
 */

var fileSub = document.getElementById('uploadResultSub');
var fileFile = document.getElementById('uploadResultFile');

function uploadResultsOnClick(){
    fieldColorChange(fileSub,'');
    fieldColorChange(fileFile,'');

    var fileSubCheck = false;
    if(fileSub.selectedIndex>0){
        fileSubCheck = true;
    }else {
        fileSubCheck = false;
        fieldColorChange(fileSub,'red');
    }

    var fileFileCheck = false;
    if(fileFile.value !=""){
        fileFileCheck = true;
    }else {
        fileFileCheck = false;
        document.getElementById('fileWarning').style.color = 'red';
    }

    if(fileSubCheck && fileFileCheck){
        document.getElementById('fileUploadPassword').style.display = 'block';
    }

    return false;

}

var oBoSub = document.getElementById('resultSub_one');
var oBoIndex = document.getElementById('resultIndex_one');
var oBoName = document.getElementById('resultName_one');
var oBoMark = document.getElementById('resultMark_one');

function uploadResults_oneOnclick(){
    fieldColorChange(oBoSub,'');
    fieldColorChange(oBoIndex,'');
    fieldColorChange(oBoName,'');
    fieldColorChange(oBoMark,'');

    var oBoSubCheck = false;
    if(oBoSub.selectedIndex>0){
        oBoSubCheck = true;
    }else {
        oBoSubCheck = false;
        fieldColorChange(oBoSub,'red');
    }

    var oBoIndexCheck = false;
    if(oBoIndex.value.trim().length>0){
        oBoIndexCheck = true;
    }else {
        oBoIndexCheck = false;
        fieldColorChange(oBoIndex,'red');
    }

    var oBoNameCheck = false;
    if(oBoName.value.trim().length>0){
        oBoNameCheck = true;
    }else {
        oBoNameCheck = false;
        fieldColorChange(oBoName,'red');
    }

    var oBoMarkCheck = false;
    if(oBoMark.value.trim().length>0){
        oBoMarkCheck = true;
    }else {
        oBoMarkCheck = false;
        fieldColorChange(oBoMark,'red');
    }

    return oBoSubCheck && oBoIndexCheck && oBoNameCheck && oBoMarkCheck;

}


var fname = document.getElementById('tfirstName');
var lname = document.getElementById('tlastName');
var useraddress = document.getElementById('taddress');
var userbday = document.getElementById('tbDay');
var gender = document.getElementById('tgender');
var usermail = document.getElementById('temail');
var tel= document.getElementById('ttelephoneNo');
var formWarnings = document.getElementsByClassName('warning');

function updateValidationOnclick() {
    validate_update(validate_general(fname,lname,useraddress,userbday,gender,usermail,tel,formWarnings),"tupdateDetails");
}

var tuSub = document.getElementById('tutorialSub');
var tuMsg = document.getElementById('tutorialMessage');
var tuName= document.getElementById('tutorialName');
var tuUrl = document.getElementById('tutorialUrl');
var tuFile = document.getElementById('tutorialFile');

function tuClrOnClick(){
    tuSub.selectedIndex = 0;
    tuMsg.value = "";
    tuName.value = '';
    tuUrl.value = '';
    tuFile.value = tuFile.defaultValue;
}
