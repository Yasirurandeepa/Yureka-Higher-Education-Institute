/**
 * Created by user on 6/29/2017.
 */
var sendNotifi_btn = document.getElementById("sendNotification");
var sendNotifi_layer = document.getElementsByClassName("notification_panel")[0];

var advertisement_btn = document.getElementById("advertisement");
var advertisement_layer = document.getElementsByClassName("advertisement_panel")[0];

var addTeacher_btn = document.getElementById("addTeacher");
var addTeacher_layer = document.getElementsByClassName("addTeacher_panel")[0];

var updateCourses_btn = document.getElementById("updateCourses");
var updateCourses_layer = document.getElementsByClassName("updateCourses_panel")[0];

var newStudent_btn = document.getElementById("newStudent");
var newStudent_layer = document.getElementsByClassName("newStudent_panel")[0];

var updateDetails_layer = document.getElementsByClassName("updateDetails_panel")[0];

var tutorials_btn = document.getElementById("tutorials");
var tutorials_layer = document.getElementsByClassName("tutorial_panel")[0];

var results_btn = document.getElementById("results");
var results_layer = document.getElementsByClassName("results_panel")[0];

var viewStudent_btn = document.getElementById("viewStudent");
var viewStudent_layer = document.getElementsByClassName("view_table")[0];

var addvertiesmetsT_btn = document.getElementById("addAdvertiesmentsT");
var addvertiesmetsT_layer = document.getElementsByClassName("advertisementT_panel")[0];

function ownerLayers(){
    sendNotifi_layer.style.display = "none";
    advertisement_layer.style.display = "none";
    addTeacher_layer.style.display = "none";
    updateCourses_layer.style.display = "none";
    newStudent_layer.style.display = "none";
    updateDetails_layer.style.display = "none";
    viewStudent_layer.style.display = "none";

    sendNotifi_btn.className = "";
    advertisement_btn.className ="";
    addTeacher_btn.className = "";
    updateCourses_btn.className ="";
    newStudent_btn.className ="";
    viewStudent_btn.className ="";
}

function studentLayers(){
    tutorials_layer.style.display = "none";
    results_layer.style.display = "none";
    updateDetails_layer.style.display = "none";

    tutorials_btn.className = "";
    results_btn.className ="";
}

function teacherLayers(){

    tutorials_layer.style.display = "none";
    results_layer.style.display = "none";
    sendNotifi_layer.style.display = "none";
    updateDetails_layer.style.display = "none";
    viewStudent_layer.style.display = "none";
    addvertiesmetsT_layer.style.display = "none";

    tutorials_btn.className = "";
    results_btn.className ="";
    sendNotifi_btn.className = "";
    viewStudent_btn.className ="";
    addvertiesmetsT_btn.className ="";
}

function changeLayer(button,layer){
    button.className = "active";
    layer.style.display = "block";
}

