/* Licensed under the BSD. See License.txt for full text.  */


$(document).ready(function() {
 $('#mass_email').summernote();


    $('#mass_email_query_selection').change(function() {
        $(".note-editable").html("");
        $(".update_template_button").html("");
     $("#recipients_to_show").html("");
     $("#recipient").html('');
        $(".embed").remove();

           if($("#mass_email_query_selection").val()=="-1"){

            $("#recipient").append('<p> select a query</p>');
            $(".edit_template_button").html("");

            }
           else{


            $.ajax({

               url: 'php/mass_email_list.php',
                type: 'POST',
                data : {
                 action : "select",
                 selected_query: $("#mass_email_query_selection").val()}

                }).done(function(array) {
                 var parsed_array=JSON.parse(array);
                 var content = parsed_array['content'];
                 delete parsed_array['content'];



 $.each(parsed_array, function(id,info){

                  var info_array = info.split('/');
                  var recipient_name = info_array[0]+" "+info_array[1];

                  var recipient_email = info_array[2];

                        $("#recipient").append('<p><label for="email"><input type="checkbox" name="email" checked="checked" value="'+id+'">'+recipient_name+' ('+recipient_email+')</label></p>');






                 });
                 $("input:checkbox[name='email']:checked").each(function(){
                  $("#recipients_to_show").append('<p>'+ $(this).parent().text()+'</p>');
                 });

                 $(".note-editable").html(content);

               });

            $(".update_template_button").html("<button id='update_template' type='button' class='btn btn-primary pull-right'>Update template</button>");
               $(".note-toolbar").append("<button class='btn btn-default btn-sm btn-small embed' id='firstname' type='button' >First Name</button>");

           }

    });


    $('#recipient_confirm').click(function(){
     $("#recipients_to_show").html("");
     $("input:checkbox[name='email']:checked").each(function(){
      $("#recipients_to_show").append('<p>'+ $(this).parent().text()+'</p>');
     });


    });

    $("#send_mass_email").click(function() {
     if($("#mass_email_query_selection").val()=="-1"){

         bootbox.alert("No Recipients");

         }
        else{
     var id_list = "";
   $("input:checkbox[name='email']:checked").each(function(){
  id_list=id_list+","+$(this).val();
 });
     message = $('#mass_email').code();

     bootbox.confirm("Are you sure you want to send this email to these volunteers?", function(result) {

      if (result == true) {
       $.ajax({
       type : "POST",
       url: "php/mass_email_list.php",
       data : {
        action : "send",
        message : message,
        id_list :id_list
       }
      }).done(function(msg) {

       if (msg == "") {
      setTimeout(function() {
       bootbox.alert("Message sent successfully");
      }, 1000);

     }

      });
      }

    }); }

   });




    $(document).on('click', '#update_template', function(){

     var new_template = $('#mass_email').code();
      bootbox.confirm("Are you sure you want to save this as template?", function(result) {
       if(result==true){


      $.ajax({

            url: 'php/mass_email_list.php',
             type: 'POST',
             data : {
              action : "update",
              new_template:new_template,
              selected_query: $("#mass_email_query_selection").val()}

             }).done(function(msg) {
            alert("template updated");

             });
       }
      });



    });







});
