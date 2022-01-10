$(document).ready(function(){
    //get site cookies
    let cookie=document.cookie
    var result=cookie.split('; ').find(row => row.startsWith('theme=')).split('=')[1]; //get theme cookie value
    var filename=window.location.pathname.split("/").find(row => row.endsWith(".php")).split('.')[0]; //get file name (ex: index)
    
    if(result=="dark"){ //based on theme cookie value
        $("#externalCssLink").attr("href",'../css/'+filename+'_dark.css'); // change css file to dark theme
        $("#navbar").attr('class',"navbar navbar-expand-lg navbar-dark bg-dark"); //change navigation bar theme to dark in main and editor
        $("#navbar2").attr('class',"navbar navbar-expand-sm navbar-dark bg-dark"); //change navigation bar theme to dark in editor
    }
    else if(result=="light"){
        $("#externalCssLink").attr("href",'../css/'+filename+'_light.css'); // change css file to light theme
        $("#navbar").attr('class',"navbar navbar-expand-lg navbar-light bg-light"); //change navigation bar theme to light in main and editor
        $("#navbar2").attr('class',"navbar navbar-expand-sm navbar-light bg-light"); //change navigation bar theme to light in editor
    }
    
    if($("#theme_button".length)){ 
        $("#theme_button").click(function(){
            
            if(result=="dark"){ //change to light theme if theme button is pressed
                result="light";
                $("#theme_icon").attr('class',"bi bi-moon-fill"); //change theme icon
                setcookie("theme","light"); //overwrite theme cookie with new value
                $("#navbar").attr('class',"navbar navbar-expand-lg navbar-light bg-light");  //change navigation bar theme to light in main and editor
                $("#navbar2").attr('class',"navbar navbar-expand-sm navbar-light bg-light"); //change navigation bar theme to light in editor
                $("#externalCssLink").attr("href",'../css/'+filename+'_light.css'); // change css file to light theme
            }
            else{ //change to dark theme if theme button is pressed
                result="dark";
                $("#theme_icon").attr('class',"bi bi-brightness-high"); //change theme icon
                setcookie("theme","dark"); //overwrite theme cookie with new value
                $("#navbar").attr('class',"navbar navbar-expand-lg navbar-dark bg-dark"); //change navigation bar theme to dark in main and editor
                $("#navbar2").attr('class',"navbar navbar-expand-sm navbar-dark bg-dark"); //change navigation bar theme to dark in editor
                $("#externalCssLink").attr("href",'../css/'+filename+'_dark.css'); // change css file to dark theme
            }
            location.reload; //reload page when theme is changed
        });
        
    }

    function setcookie(name,value){ //sets cookie
        const d = new Date();
        d.setTime(d.getTime() + (365*24*60*60));
        let expires = "expires="+ d.toUTCString();
        document.cookie=name+"="+value+";"+expires+";path=/";
    }

});