$(document).ready(function(){
  var limitnum = 140; // max limit
  
  function limiting(obj, limit) {
    var cnt = $("#counter > span");
    var txt = $(obj).val().replace('/\s{2,}/',' '); 
    var len = txt.length;
    
    // check if the current length is over the limit
    if(len > limit){
       $(obj).val(txt.substr(0,limit));
       $(cnt).html(len-1);
     } 
     else { 
       $(cnt).html(len);
     }
     
     // check if user has less than 8 chars left
     if(limit-len <= 8) {
     	$(cnt).addClass("warning");
     }
  }


  $('textarea').keyup(function(){
    limiting($(this), limitnum);
  });
});