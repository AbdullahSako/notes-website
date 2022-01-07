$(document).ready(function(){
   
    $("#email").focusout(function(){
        var email=$(this).val();
        if(email===""){
            $(this).css("border-color","red");
            tippy('#email',{content: 'Please enter an email',trigger:'focusout',placement:'right',duration:400,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},});
        }
    });
    $("#password").focusout(function(){
        var password=$(this).val();
        if(password===""){
            
            $(this).css("border-color","red");
            tippy('#password',{content: 'Please enter a password',trigger:'focusout',placement:'right',duration:400,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);}});
        }
        else if(password.length <8){
            
            $(this).css("border-color","red");
            tippy('#password',{content: 'Password length must be over 8 characters',trigger:'focusout',placement:'right',duration:400,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);}});
        }

    });
    
    $("#email").focus(function(){
        $(this).css("border-color","#f6f6f6");
    });
    $("#password").focus(function(){
        $(this).css("border-color","#f6f6f6");
    });
    $("#confirm_password").focus(function(){
        $(this).css("border-color","#f6f6f6");
    });
    $('#registerForm').submit(function(e) {
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword=$('#confirm_password').val();
        const button=document.querySelector('#register_button');
        var enabled=true;

        $("#email").css("border-color","#f6f6f6");
        $("#password").css("border-color","#f6f6f6");
        $("#confirm_password").css("border-color","#f6f6f6");

        if (email.length < 1) {
            $("#email").css("border-color","red");
            tippy('#email',{content: 'Please enter an email',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
            enabled=false;
        } else {
          var regEx = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
          var validEmail = regEx.test(email);
         if (!validEmail) {
            $("#email").css("border-color","red");
            tippy('#email',{content: 'Please enter a valid email',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});  
            enabled=false;
        }
        }
        if (password.length < 8) {
            $("#password").css("border-color","red");
            tippy('#password',{content: 'Password length must be over 8 characters',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
            enabled=false;
        }

        if(password != confirmPassword){
            $("#confirm_password").css("border-color","red");
            tippy('#confirm_password',{content: 'Passwords do not match',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
            enabled=false;
        }
        if(enabled==false){
            e.preventDefault();
    }
      });
});