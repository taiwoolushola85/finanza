setInterval(function(){alert("🚫 Hello!!, your session is over")}, 25 * 60 * 1000);

setInterval(function(){
    redirect();
}, 25 * 60 * 1000);

function redirect(){
    document.location = "../index.php"
}