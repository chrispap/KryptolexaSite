function onload()
{
    document.getElementById('menu').style.width="801px";
}

function myClickHandler() {
    $("[id*='content']").height(30);
    $(this).parent().find('textarea').height(250);
}

//~ $(document).ready(function(){
    //~ $("[id *= 'content' ]").click(myClickHandler);
//~
    //~ $(".deleteCheckbox").mouseenter(function(){
        //~ $(this).append("<div style='width: 400px;margin-left: 20px; color: #ff3030; ' > Επιλογή για διαγραφή αυτής της σελίδας </div>");
    //~ });
//~
    //~ $(".deleteCheckbox").mouseleave(function(){
        //~ $(this).find('div').remove();
    //~ });
//~ });


function showImage(imgName) {
    document.getElementById('largeImg').src = imgName;
    showLargeImagePanel();
    unselectAll();
}

function showLargeImagePanel() {
    document.getElementById('largeImgPanel').style.visibility = 'visible';
}

function unselectAll() {
    if(document.selection) document.selection.empty();
    if(window.getSelection) window.getSelection().removeAllRanges();
}

function hideMe(obj) {
    obj.style.visibility = 'hidden';
}
