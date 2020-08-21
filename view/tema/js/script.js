
/*let user_show=document.getElementById("user-show");

let user_info=document.getElementById("user-info");
user_info.style.display="none";*/

let nav=document.querySelector("nav");
let iconMenu=document.getElementById("icon-menu");

/*user_show.onclick=function(){
    console.log(user_info.style.display);
    if(user_info.style.display=="none")
        user_info.style.display="block";
    else
     user_info.style.display="none";
}*/

iconMenu.onclick=function(){
    console.log(nav.style.display);
    if (nav.style.display == "none")
        nav.style.display = "block";
    else
        nav.style.display = "none";
}