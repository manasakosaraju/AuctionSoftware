<?php
	if(isset($_POST['submit']))
	{
		session_start();
   		$con = new mysqli("localhost", "root", "root", "Chad", 3307) or die(mysqli_error());  
		$username = $_POST['username'];
		$password = $_POST['password'];
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$md5_password=md5($password.row_salt);
		$query = "select username, password from ilance_users where username= '$username' and password = '$md5_password' ";
		$result=mysqli_query($con, $query);
		$count=mysqli_num_rows($result);
		if($count == 0){
			echo "
				<script> 
					alert('Incorrect username/ password')
				</script>

			";
		}
		else{
			
			echo "<h1>
					Welcome $username
					</h1>";
		
		}

		session_destroy();
}
?>