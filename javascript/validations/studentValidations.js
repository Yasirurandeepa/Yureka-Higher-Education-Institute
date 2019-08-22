/**
 * Created by user on 7/6/2017.
 */

var fname = document.getElementById('sfirstName');
var lname = document.getElementById('slastName');
var useraddress = document.getElementById('saddress');
var userbday = document.getElementById('sbDay');
var gender = document.getElementById('sgender');
var usermail = document.getElementById('semail');
var tel= document.getElementById('stelephoneNo');
var formWarnings = document.getElementsByClassName('warning');

function updateValidationOnclick() {
    validate_update(validate_general(fname,lname,useraddress,userbday,gender,usermail,tel,formWarnings),"supdateDetails");
}

var tumodule = document.getElementsByClassName('tmodule');
function tmoduleOnclick(index){
    if(window.getComputedStyle(tumodule[index],null).getPropertyValue("height")=='50px') {
        tumodule[index].style.height = 'auto';
    }else{
        tumodule[index].style.height = '50px';
    }
}
