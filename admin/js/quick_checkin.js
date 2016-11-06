$(document).ready(function(){

	
	 $(".q-c-students").click(function(){
	
	    
	    		
	    		$.ajax({
	            type: 'POST',
	            url: 'q_c_students.php',
	            
	            data : {
	            
	            	range_start_time : $("#range_start_time").val(),
	            	range_end_time : $("#range_start_time").val()
	            

	               }//when this is done the msg echoed from the php file that this file posts to which is add_form.php. 
	         }).done(function($msg) {
	        alert($msg);
	    		}

	
	
	
 });
