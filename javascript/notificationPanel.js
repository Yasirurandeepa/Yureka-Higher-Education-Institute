/**
 * Created by user on 6/30/2017.
 */

function openNav() {
    document.getElementById("myNav").style.width = "100%";
    document.getElementById("nav_noti").className = "active";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
    document.getElementById("nav_noti").className = "";
}