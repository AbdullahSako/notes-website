$(document).ready(function(){
    //show hint on add note button
    const addhint=tippy('#plusicon',{content: 'Add a note',placement:'bottom',onShow: function(reference){setTimeout(function() {reference.destroy();}, 1500);}});
    addhint[0].show();

    $(".box").click(function(){
        $(this).children("#boxform").submit(); // submit form when clicking on note box
    });

    
});