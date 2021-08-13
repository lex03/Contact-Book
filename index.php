<?php
include("auth_session.php");
?>
<html>  
    <head>  
        <title>Contact List</title>  
		<link rel="stylesheet" href="jquery-ui.css">
		<link rel="stylesheet" href="./assets/style.css"/>
		<script src="jquery.min.js"></script>  
		<script src="jquery-ui.js"></script>
		<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>  
    <body class="text-center bg-gradient-to-t from-red-100 via-white to-white ">  
    <h3 align="center" class="text-white py-5 text-5xl font-bold bg-gradient-to-r from-blue-700 via-indigo-900 to-blue-700 ...">Welcome <?php echo $_SESSION['name']; ?>, to your Contact List</h3><br />
	<div class="flex self-end">
	<a href="logout.php"><button type="submit" class="leftbtn place-items-end items-center h-10 px-5 text-red-700 transition-colors duration-150 border border-red-500 rounded-lg focus:shadow-outline hover:bg-red-500 hover:text-red-100">Logout</button></a>
	</div>
	<div class="container mx-auto">
			<br />
			
			<br />
			<div align="right" style="margin-bottom:5px;">
			<div align="center">
			<button type="button" name="add" id="add" class="text-right h-12 text-white px-6 m-2 text-lg transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-800">Add new Contact</button>
			</div>
			</div>
			<div class="table-responsive" id="user_data">
				
			</div>
			<br />
		</div>
		<!-- Pop up -->
		<div id="user_dialog" title="Add Data">
			<form method="post" id="user_form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
				<div class="form-group  px-4 py-3">
					<label class="block text-gray-700 text-sm font-bold mb-2 px-4">Enter Name</label>
					<input type="text" name="contact_name" id="contact_name" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline " />
					<span id="contact_name_error" class="text-danger "></span>
				</div>
				<div class="form-group px-4 py-3">
					<label class="block text-gray-700 text-sm font-bold mb-2 px-4">Enter Number</label>
					<input type="number" name="contact_number" id="contact_number" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
					<span id="contact_number_error" class="text-danger"></span>
				</div>
				<div class="form-group px-4 py-3">
					<label class="block text-gray-700 text-sm font-bold mb-2 px-4">Enter Email</label>
					<input type="email" name="contact_email" id="contact_email" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
					<span id="contact_email_error" class="text-danger"></span>
				</div>
				<div class="form-group px-4 py-3">
					<label class="block text-gray-700 text-sm font-bold mb-2 px-4">Enter Address</label>
					<input type="text" name="contact_address" id="contact_address" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
					<span id="contact_address_error" class="text-danger"></span>
				</div>
				<div class="form-group px-4 py-3">
					<input type="hidden" name="action" id="action" value="insert" />
					<input type="hidden" name="hidden_id" id="hidden_id" />
					<input type="submit" name="form_action" id="form_action" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" value="Insert" />
				</div>
			</form>
		</div>
		
		<div id="action_alert" title="Action">
			
		</div>
		
		<div id="delete_confirmation" title="Confirmation">
		<p>Are you sure you want to Delete this data?</p>
		</div>
		
    </body>  
</html>  




<script>  
$(document).ready(function(){  

	load_data();
    
	function load_data()
	{
		$.ajax({
			url:"fetch.php",
			method:"POST",
			success:function(data)
			{
				$('#user_data').html(data);
			}
		});
	}
	
	$("#user_dialog").dialog({
		autoOpen:false,
		width:400
	});
	
	$('#add').click(function(){
		$('#user_dialog').attr('title', 'Add Data');
		$('#action').val('insert');
		$('#form_action').val('Insert');
		$('#user_form')[0].reset();
		$('#form_action').attr('disabled', false);
		$("#user_dialog").dialog('open');
	});
	// validation
	$('#user_form').on('submit', function(event){
		event.preventDefault();
		var contact_name_error = '';
		var contact_email_error = '';
		if($('#contact_name').val() == '')
		{
			contact_name_error = 'Name is required';
			$('#contact_name_error').text(contact_error_name);
			$('#contact_name').css('border-color', '#cc0000');
		}
		else
		{
			contact_name_error = '';
			$('#contact_name_error').text(contact_name_error);
			$('#contact_name').css('border-color', '');
		}
		if($('#contact_email').val() == '')
		{
			contact_email_error = 'Email is required';
			$('#contact_email_error').text(contact_email_error);
			$('#contact_email').css('border-color', '#cc0000');
		}
		else
		{
			contact_email_error = '';
			$('#contact_email_error').text(contact_email_error);
			$('#contact_email').css('border-color', '');
		}
		if($('#contact_number').val() == '')
		{
			contact_number_error = 'Phone number is required';
			$('#contact_number_error').text(contact_number_error);
			$('#contact_number').css('border-color', '#cc0000');
		}
		else
		{
			contact_number_error = '';
			$('#contact_number_error').text(contact_number_error);
			$('#contact_number').css('border-color', '');
		}
		
		if(contact_name_error != '' || contact_email_error != '' || contact_number_error != '')
		{
			return false;
		}
		else
		{
			$('#form_action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					$('#user_dialog').dialog('close');
					$('#action_alert').html(data);
					$('#action_alert').dialog('open');
					load_data();
					$('#form_action').attr('disabled', false);
				}
			});
		}
		
	});
	
	$('#action_alert').dialog({
		autoOpen:false
	});
	
	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#contact_name').val(data.contact_name);
				$('#contact_number').val(data.contact_number);
				$('#contact_email').val(data.contact_email);
				$('#contact_address').val(data.contact_address);

				$('#user_dialog').attr('title', 'Edit Data');
				$('#action').val('update');
				$('#hidden_id').val(id);
				$('#form_action').val('Update');
				$('#user_dialog').dialog('open');
			}
		});
	});
	
	$('#delete_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var id = $(this).data('id');
				var action = 'delete';
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{id:id, action:action},
					success:function(data)
					{
						$('#delete_confirmation').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		$('#delete_confirmation').data('id', id).dialog('open');
	});
	
});  
</script>