$(document).ready(function(){
   
    $("#email").focusout(function(){ //when focusing out of email field
        var email=$(this).val();
        if(email===""){ //if email field is empty change border to red and show hint arrow
            $(this).css("border-color","red");
            tippy('#email',{content: 'Please enter an email',trigger:'focusout',placement:'right',duration:400,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},});
        }
    });
    $("#password").focusout(function(){ //when focusing out of password field
        var password=$(this).val();
        if(password===""){ //if password field is empty change border to red and show hint arrow
            
            $(this).css("border-color","red");
            tippy('#password',{content: 'Please enter a password',trigger:'focusout',placement:'right',duration:400,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);}});
        }
        else if(password.length <8){ //if password is less than 8 characters change border to red and show hint arrow
            
            $(this).css("border-color","red");
            tippy('#password',{content: 'Password length must be over 8 characters',trigger:'focusout',placement:'right',duration:400,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);}});
        }

    });
    
    $("#email").focus(function(){ // change border color to normal in case it was changed to red
        $(this).css("border-color","#f6f6f6");
    });
    $("#password").focus(function(){ // change border color to normal in case it was changed to red
        $(this).css("border-color","#f6f6f6");
    });
    $("#confirm_password").focus(function(){ // change border color to normal in case it was changed to red
        $(this).css("border-color","#f6f6f6");
    });
    $('#registerForm').submit(function(e) { //when register button is clicked
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword=$('#confirm_password').val();
        const button=document.querySelector('#register_button'); //in order to show hint arrow when clicking on register button (used in tippy constructor)
        var enabled=true;
        // change border color to normal in case it was changed to red
        $("#email").css("border-color","#f6f6f6");
        $("#password").css("border-color","#f6f6f6");
        $("#confirm_password").css("border-color","#f6f6f6");

        if (email.length < 1) { //if email field is empty change border to red and show hint arrow
            $("#email").css("border-color","red");
            tippy('#email',{content: 'Please enter an email',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
            enabled=false;
        } else {    
          var regEx = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
          var validEmail = regEx.test(email);
         if (!validEmail) { //if email is not valid change border to red and show hint arrow
            $("#email").css("border-color","red");
            tippy('#email',{content: 'Please enter a valid email',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});  
            enabled=false;
        }
        }
        if (password.length < 8) { //if password is less than 8 characters change border to red and show hint arrow
            $("#password").css("border-color","red");
            tippy('#password',{content: 'Password length must be over 8 characters',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
            enabled=false;
        }

        if(password != confirmPassword){ //if confirm password field is not the same as password change border to red and show hint arrow
            $("#confirm_password").css("border-color","red");
            tippy('#confirm_password',{content: 'Passwords do not match',placement:'right',duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
            enabled=false;
        }
        if(enabled==false){ //if one of the above checks is true stop the form from submitting
            e.preventDefault();
    }
      });
});