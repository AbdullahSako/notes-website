$(document).ready(function(){
    $("#note_title").focus(function(){
        $("#note_title").css("border-color","transparent");
    });

    $("#save").click(function(e){
        const button=document.querySelector('#save');

        if($("#note_title").val().length==0){
            e.preventDefault();
            $("#note_title").css("border-color","red");
            tippy('#note_title',{content: 'Please enter a title',placement: "bottom",duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
        }
        else{
            $("#savetitle").val($("#note_title").val());
            $("#savetext").val($("#editor").val());
            return true;
        }
    });
});