/**
 * Created by user on 7/6/2017.
 */
    //onclick validation in sign up

var imported = document.createElement('script');
imported.src = 'Validations.js';
document.head.appendChild(imported);

var fname = document.getElementById('firstName');
var lname = document.getElementById('lastName');
var useraddress = document.getElementById('address');
var userbday = document.getElementById('bDay');
var gender = document.getElementById('gender');
var usermail = document.getElementById('email');
var tel= document.getElementById('telephoneNo');
var pass= document.getElementById('password');
var cmfpass =  document.getElementById('confirmPassword');
var agree = document.getElementById('agreement');
var agreeStatement = document.getElementById('agreementStatement');
var formWarnings = document.getElementsByClassName('warning');

function validateOnclick() {
    validate_signup(validate_general(fname,lname,useraddress,userbday,gender,usermail,tel,formWarnings),userbday,pass,cmfpass,agree,agreeStatement);
}