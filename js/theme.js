$(document).ready(function(){
    let cookie=document.cookie
    var result=cookie.split('; ').find(row => row.startsWith('theme=')).split('=')[1];
    var filename=window.location.pathname.split("/").find(row => row.endsWith(".php")).split('.')[0];
    
    if(result=="dark"){
        $("#externalCssLink").attr("href",'../css/'+filename+'_dark.css');
        $("#navbar").attr('class',"navbar navbar-expand-lg navbar-dark bg-dark");
    }
    else if(result=="light"){
        $("#externalCssLink").attr("href",'../css/'+filename+'_light.css');
        $("#navbar").attr('class',"navbar navbar-expand-lg navbar-light bg-light");
    }
    
    if($("#theme_button".length)){
        $("#theme_button").click(function(){
            
            if(result=="dark"){
                result="light";
                $("#theme_icon").attr('class',"bi bi-moon-fill");
                setcookie("theme","light");
                $("#navbar").attr('class',"navbar navbar-expand-lg navbar-light bg-light");
                $("#externalCssLink").attr("href",'../css/'+filename+'_light.css');
            }
            else{
                result="dark";
                $("#theme_icon").attr('class',"bi bi-brightness-high");
                setcookie("theme","dark");
                $("#navbar").attr('class',"navbar navbar-expand-lg navbar-dark bg-dark");
                $("#externalCssLink").attr("href",'../css/'+filename+'_dark.css');
            }
            location.reload;
        });
        
    }

    function setcookie(name,value){
        const d = new Date();
        d.setTime(d.getTime() + (365*24*60*60));
        let expires = "expires="+ d.toUTCString();
        document.cookie=name+"="+value+";"+expires+";path=/";
    }

});