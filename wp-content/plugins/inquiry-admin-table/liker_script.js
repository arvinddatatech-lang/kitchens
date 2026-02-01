jQuery(document).ready( function() {
   jQuery(".user_like1").click( function(e) {
      e.preventDefault(); 
      var fired_button = jQuery(this).val();
     // nonce = jQuery(this).attr("data-nonce");
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "my_user_like", post_id : fired_button },
         success: function(response) {
                              jQuery("#app").html('');
                          var content = "<table style='border:1pxsolid green'>"
                            jQuery.each(response[0], function(key, value){
                           // jQuery("#app").append(key + " : " + value + '<br>');
                            content += '<tr style="border:1px solid green" ><td style="border: 1px solid green " >' + key + '</td>:<td style="border: 1px solid green " >' +  value + '</td></tr>';
                             });
                            jQuery('#app').append(content);           
                         }
      });
   });
});


jQuery(document).ready( function() {
   jQuery(".thickbox").click( function(e) {
      e.preventDefault(); 
      var fired_button = 1;
       let content = '';  
     // nonce = jQuery(this).attr("data-nonce");
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "my_user_like", post_id : fired_button },
         success: function(response) {
                              jQuery("#app").html();
                              if(content === ''){
                             // console.log(response[0].ip_data)
                           content = '<div id="my-modal-id" style="display:none;"><p><h1>Modal window content.' + response[0].ip_data  + '</h1>';                            
                           // jQuery.each(response[0], function(key, value){
                           // // jQuery("#app").append(key + " : " + value + '<br>');
                           //  content += '<tr style="border:1px solid green" ><td style="border: 1px solid green " >' + key + '</td>:<td style="border: 1px solid green " >' +  value + '</td></tr>';
                           //   });
                              content += '</p></div>';  
                              }
                            jQuery('#app').html(content);           
                         }
      });
   });

jQuery(".user_like").click(function() {
    alert('Button clicked');      
    tb_show('', '/?TB_inline&width=600&height=550&inlineId=my-modal-id&id=%s');
        alert('Finally thick box randered..! No issue here');
    return false;
}); 
   
});