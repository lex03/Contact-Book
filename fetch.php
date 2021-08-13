<?php

//fetch.php

include("db.php");
session_start();

$query = "SELECT * FROM contacts WHERE user_email= '".$_SESSION['email']."'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
$output = '
<form name="frmUser" method="post" action="" class="px-6">

<table class="table-auto sm:shadow-2xl rounded border-b border-gray-200 ">
<thead class="bg-gray-800 text-white">
	<tr>
		<th class="text-center  capitalize px-4 py-4">Delete Selection</th>
		<th class="text-center  capitalize px-4 py-4">Contact Name</th>
		<th class="text-center  capitalize px-4 py-4">Contact Phone</th>
		<th class="text-center  capitalize px-4 py-4">Contact Email</th>
		<th class="text-center  capitalize px-4 py-4">Contact Address</th>
		<th class="text-center  capitalize px-4 py-4">Edit</th>
		<th class="text-center  capitalize px-4 py-4">Delete</th>
	</tr>
	</thead>
';
if($total_row > 0)
{

	foreach($result as $row)
	{
		$output .= '
		
		<tr class="border bg-gray-700 text-white">
			<td class="text-center  py-3 px-4">
				<input type="checkbox" name="users[]" value=" '.$row["id"].'">
			</td>
			<td width="20%" class="text-center   py-3 px-4">'.$row["contact_name"].'</td>
			<td width="15%" class="text-center  py-3 px-4">'.$row["contact_number"].'</td>
			<td width="20%" class="text-center  py-3 px-4">'.$row["contact_email"].'</td>
			<td width="40%" class="text-center  py-3 px-4">'.$row["contact_address"].'</td>
			<td width="10%" class="text-center  py-3 px-4">
				<button type="button" name="edit" class="btn-xs edit h-10 px-5 text-indigo-500 transition-colors duration-150 border border-indigo-500 rounded-lg focus:shadow-outline hover:bg-indigo-500 hover:text-indigo-100" id="'.$row["id"].'">Edit</button>
			</td>
			<td width="10%" class="text-center  w-1/3  py-3 px-4">
				<button type="button" name="delete" class="btn-xs delete h-10 px-5 text-red-700 transition-colors duration-150 border border-red-500 rounded-lg focus:shadow-outline hover:bg-red-500 hover:text-red-100" id="'.$row["id"].'">Delete</button>
			</td>
		</tr>
		';
	}

	
}
else
{
	$output .= '
	<tr class="bg-gray-800 text-white">
		<td colspan="9" align="center">Data not found</td>
	</tr>
	';
}
$output .= '
<tr class="listheader bg-gray-800 text-white">
        <td class="width="10%" text-center" colspan="9"><input class="h-12 text-white px-6 m-2 text-lg  transition-colors duration-150 bg-red-500 rounded-lg focus:shadow-outline hover:bg-red-800" style="margin-left:650px" type="button" name="deleteselection" value="Delete Selection"  onClick="setDeleteAction();" /></td>
</tr>
</table>
</form>
';

echo $output;

?>
<script type="text/javascript">
	function setDeleteAction() {
    if(confirm("Are you sure want to delete these rows?")) {
    document.frmUser.action = "delete_user.php";
    document.frmUser.submit();
    }
  }
</script>