/**
 * Created by user on 6/30/2017.
 */
var date = new Date;
var hour = date.getHours();

var dayText = document.getElementById("dayTime");
var dayImage = document.getElementsByClassName("dayTimeImage");

if(hour>4 && hour<12){
    dayText.innerText = "Good Morning!"
    dayImage[0].style.display = "block";
    dayImage[1].style.display = "none";
    dayImage[2].style.display = "none";
    dayImage[3].style.display = "none";
}
else if(hour>=12 && hour<15){
    dayText.innerText = "Good Afternoon!"
    dayImage[0].style.display = "none";
    dayImage[1].style.display = "block";
    dayImage[2].style.display = "none";
    dayImage[3].style.display = "none";
}
else if(hour>=15 && hour<19){
    dayText.innerText = "Good Evening!"
    dayImage[0].style.display = "none";
    dayImage[1].style.display = "none";
    dayImage[2].style.display = "block";
    dayImage[3].style.display = "none";
}
else if(hour>=19 && hour<=23 || hour>=0 && hour<=4){
    dayText.innerText = "Good Night!"
    dayImage[0].style.display = "none";
    dayImage[1].style.display = "none";
    dayImage[2].style.display = "none";
    dayImage[3].style.display = "block";
}
