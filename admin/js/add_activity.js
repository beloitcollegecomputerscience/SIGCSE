
$(document).ready(function(){


	var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
	})();


 $('#other_activity_type').keyup(function(){

 	delay(function(){
     $.ajax({
             url: 'add_form.php',
             type: 'POST',
             data : {
             	action : '1',
             	other_activity_type : $("#other_activity_type").val()
          }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
          }).done(function($msg) {
        		if($msg.indexOf("duplicatetype")!= -1 ){
        			$("#other_activity_type_result").show();

        		}else{$("#other_activity_type_result").hide();
        		}

          });
 	},600);

     });

    $('#other_activity_location').keyup(function(){

    	delay(function(){
        $.ajax({
                url: 'add_form.php',
                type: 'POST',
                data : {
                	action : '2',
                	other_activity_location : $("#other_activity_location").val()
             }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
             }).done(function($msg) {
           		if($msg.indexOf("duplicateroom")!= -1 ){
           			$("#other_activity_location_result").show();

           		}else{$("#other_activity_location_result").hide();
           		}

             });
    	},600);

        });

   $('#other_activity_organizer_last').keyup(function(){

    	delay(function(){
        $.ajax({
                url: 'add_form.php',
                type: 'POST',
                data : {
                	action : '3',
                	other_activity_organizer_first : $("#other_activity_organizer_first").val(),
                	other_activity_organizer_last : $("#other_activity_organizer_last").val()
             }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
             }).done(function($msg) {
           		if($msg.indexOf("duplicateorganizer")!= -1 ){
           			$("#other_activity_organizer_result").show();

           		}else{$("#other_activity_organizer_result").hide();
           		}

             });
    	},600);

        });
   $('#other_activity_organizer_first').keyup(function(){

   	delay(function(){
       $.ajax({
               url: 'add_form.php',
               type: 'POST',
               data : {
               	action : '3',
               	other_activity_organizer_first : $("#other_activity_organizer_first").val(),
               	other_activity_organizer_last : $("#other_activity_organizer_last").val()
            }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
            }).done(function($msg) {
          		if($msg.indexOf("duplicateorganizer")!= -1 ){
          			$("#other_activity_organizer_result").show();

          		}else{$("#other_activity_organizer_result").hide();
          		}

            });
   	},600);

       });







        $('#activity_type').change(function() {
             if (this.value == 'Other') {
                 $("#other_activity_type_form").show();


             } else {
                 $("#other_activity_type_form").hide();

             }
         });

         $('#activity_location').change(function() {
             if (this.value == 'Other') {
                 $("#other_activity_location_form").show();


             } else {
                 $("#other_activity_location_form").hide();

             }
         });
        $('#activity_organizer').change(function() {
             if (this.value == 'Other') {
                 $("#other_activity_organizer_form").show();


             } else {
                 $("#other_activity_organizer_form").hide();

             }
         });






	 //when the button with id add_activity_submit is clicked all the values of inputs from the add_activity.php are posted to add_form.php

    $('#add_activity_submit').click(function(){

    	$.ajax({
            type: 'POST',
            url: 'add_form.php',

            data : {
            	action : '4',
            	activity_name : $("#activity_name").val(),
            	activity_type : $("#activity_type").val(),
            	other_activity_type : $("#other_activity_type").val(),
            	activity_location : $("#activity_location").val(),
            	other_activity_location : $("#other_activity_location").val(),
            	activity_organizer : $("#activity_organizer").val(),
          	    other_activity_organizer_first : $("#other_activity_organizer_first").val(),
            	other_activity_organizer_last : $("#other_activity_organizer_last").val(),
            	activity_start_time : $("#activity_start_time").val(),
            	activity_end_time : $("#activity_end_time").val(),
            	min_num : $("#min_num").val(),
            	desired_num : $("#desired_num").val(),
            	max_num : $("#max_num").val(),
            	activity_notes : $("#activity_notes").val()

               }//when this is done the msg echoed from the php file that this file posts to which is add_form.php.
         }).done(function($msg) {

        	 document.location.href = '../activity.php';});

    });
 });
