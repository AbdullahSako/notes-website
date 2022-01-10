$(document).ready(function(){
  //create text editor tool bar with options
  var toolbarOptions = [['bold', 'italic','underline'],[{'size':[]}],[{ 'list': 'ordered'}, { 'list': 'bullet' }],[{ 'color': [] }, { 'background': [] }], [{ 'font': [] }],[{ 'align': [] }],['clean']];
  var quill = new Quill('#editor', {theme: 'snow', modules: {
clipboard: {
  matchVisual: false
}, toolbar:toolbarOptions
}});


$("#save").click(function(e){
    const button=document.querySelector('#save'); //hints to save button in order to show hint arrow on title by clicking the save arrow

    if($("#note_title").val().length==0){ //if title is empty show a red border on title text box , show a hint arrow on text box , and stop the form from submitting
        e.preventDefault();
        $("#note_title").css("border-color","red");
        tippy('#note_title',{content: 'Please enter a title',placement: "bottom",duration:200,onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);},triggerTarget: button, trigger:'click'});
    }
    else{
        $("#savetitle").val($("#note_title").val()); //fill hidden input value with title and note to send as POST
        $("#savetext").val(quill.root.innerHTML);
        return true;
    }
});

$("#note_title").focus(function(){
  $("#note_title").css("border-color","transparent"); //remove red border on focus in case you got an error
});

});