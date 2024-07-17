var  nav = document.getElementById('nav');

window.onscroll = function(){

    if (window.pageYOffset >100) {

        nav.style.background = "#007bff";
        nav.style.boxShadow = "0px 4px 2px blue";
    }
    else{
        nav.style.background = "transparent";
        nav.style.boxShadow = "none";
    }
}