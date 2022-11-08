<?php 
  session_start(); 
  $con = mysqli_connect('localhost','root','') or die ("could not connect");
  mysqli_select_db($con,'gardendesigner') or die ("could not Database");
  //connect
  if(isset($_POST['container']))
  {
    $searchq = $_POST['q'];
    $searchq = preg_replace("#[^0-9a-z]#i", "",$searchq);

    $req = "SELECT * FROM plants WHERE name LIKE '%$searchq%' OR season LIKE '%$searchq%' OR soil '%$searchq%' OR 'time' LIKE '%$searchq' " or die ("could not search");

    $query = mysqli_query($con,$req);
    $count = mysqli_num_rows($query);

    if($count == 0)
    {
      $Noutput = 'There was no search results!';
    }
    else
    {
      while($row = mysqli_fetch_array($query))
      {
        $fname = $row['name'];
        $seas = $row['season'];
        $soil = $row['soil'];
        $tim = $row['time'];
        $id = $row['id'];

        $foutput = '<div>'.$fname.'</div>';
        $Soutput = '<div>'.$seas.'</div>';
        $Toutput = '<div>'.$tim.'</div>';

      }
    }
  }

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="container">
  <form action=""class="search-bar">
    <input type="text" placeholder="search anything" name="q">
    <button type="submit"><img src="images/search.png"></button>

  </form>
</div>

<div class="header">
	<h2>Home Page</h2>
</div>
	Welcome to my project page	
<div class="content">
  
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>
            <?php
            if($foutput && $Soutput && $Toutput)
            {
             echo("$foutput");
             echo("Grows in: $Soutput");
             echo("Time: $Toutput");
            }
            else
            {
            echo("$Noutput");
            }
            ?>
    
    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

</body>
</html>