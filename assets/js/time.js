
function getTime(){
    let time = document.getElementById('time');
    
    let date = new Date();
    
let hour = date.getHours();
let ampm = hour > 11 ? 'PM' : 'AM';
hour = hour <= 9 ? `0${hour}`:hour;
hour = hour >= 12 ? hour-12 : hour;

let minute = date.getMinutes();
minute = minute <= 9 ? `0${minute}`:minute;

let second = date.getSeconds();
second = second <= 9 ? `0${second}`:second;


time.innerHTML = `${hour}:${minute}:${second} ${ampm}`;
}

setInterval(getTime, 1000);
