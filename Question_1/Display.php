<html>
	<head>
		<link rel="stylesheet" type="text/css" href="Display.css">
	</head>
	<body>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
		<h1> List of Projects </h1>
		<label class='sort-label'> Sort By: </label>
		<select id="sort">
			<option value=4> Project Date </option>
			<option value=1> Project Title </option>
			<option value=2> UserName </option>
			<option value= 3>Category Name </option>
		</select>
		<script> 
			$(document).ready(function (){
				var results = ($('table').find('tbody tr.data').length);
				if(!(results>0)){
					$('select').hide();
				}
				paginate();
			});

			$('select').change(function() {	
				var value = this.value;
				column = value-1
					$('table tbody tr.data').sort(function(a,b) {
						a = $(a).find('td:eq(' + column + ')').text();
						b = $(b).find('td:eq(' + column +  ')').text();
						if(column === 3){
							return b.localeCompare(a);
						}
						else{
						return a.localeCompare(b);
					}
					}).appendTo('table tbody');
					paginate();	
			});
			function paginate(){
			$('table').each(function () {
				var currentPage = 0;
				var numPerPage = 2;
				var $table = $(this);
				$table.bind('repaginate' , function () {
					$table.find('tbody tr.data').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show(); 
				});
				$table.trigger('repaginate');
				var numRows = ($table.find('tbody tr.data').length);
				var numPages = Math.ceil(numRows/2);
				$('div.pager').hide();
				var $pager = $('<div class= "pager"> </div>');
				for(var page = 0; page < numPages; page++){
					$('<span> </span>').text(page+1).bind('click', {
						newPage: page
					}, function(event) {
						currentPage = event.data['newPage'];
						$table.trigger('repaginate');
					}).appendTo($pager).addClass('clickable');
				}		
				$pager.insertAfter($('table'));
			
			});
		}
			
		
		</script>
	</body>
</html>


<?php
	$con = new mysqli("localhost", "root", "root", "Chad", 3307) or die(mysqli_error());
	$query = "Select ilance_projects.project_title, ilance_users.username, ilance_categories.categoryName, ilance_projects.date_added from
			 ilance_projects inner join ilance_users on ilance_projects.user_id = ilance_users.user_id left join ilance_categories on ilance_categories.cid=
			 ilance_projects.cid order by ilance_projects.date_added";
	$result = mysqli_query($con, $query);
	$count = mysqli_num_rows($result);
	if($count == 0){
		echo 
		"
			<h2>
				No projects found
			</h2>

		";
	}
	else{
		echo "
			<div class='display-table'>
				<table class='paginator'>
					<tr class='header-class'>
						<th> Project Title </th>
						<th> UserName </th>
						<th> CategoryName </th>
						<th class='hide'> Date </th>
					</tr>
				
		";
		while($rows = mysqli_fetch_array($result)){
			echo "
					<tr class='data'>
						<td> $rows[0] </td>
						<td> $rows[1] </td>
						<td> $rows[2] </td>
						<td class='hide'> $rows[3] </td>
					</tr>
			";
		}
		echo 
			"
				</table>
			</div>
		 	";
    }
?>