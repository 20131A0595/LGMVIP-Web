<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $website = mysqli_real_escape_string($conn, $_POST['website']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $skills = mysqli_real_escape_string($conn, $_POST['skills']);

   $select = mysqli_query($conn, "SELECT * FROM `enrollment` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
     if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `enrollment`(name, email, gender, website, image, skills) VALUES('$name', '$email',  '$gender' , '$website', '$image', '$skilla')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'enrolled successfully!';
            header('location:login.php');
         }else{
            $message[] = 'enrollment failed!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body class="body">
   
<div class="form-container">

   <form action=" " method="post" enctype="multipart/form-data" class="form">
      <h3>Enroll now</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="enter username" class="box" required><br>
      <input type="email" name="email" placeholder="enter email" class="box" required><br>
      <input type="text" name="gender" placeholder="Gender" class="box" required><br>
      <input type="link" name="website" placeholder="enter website link" class="box" required><br>
     <!-- <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png"><br>-->
      <input type="text" name="skills" placeholder="enter skills" class="box" required><br>
      <input type="submit" name="submit" value="Enroll Now" class="btn" href="register.php" onclick = "alert('Enrolled Successfully')">
      <input type="reset" name="clear" value="clear" class="btn" >
   </form>

</div>
<h1 class="head">Enrollment Details</h1>
<div class=div2 >

   <?php
   $sqlget = "select * from enrollment";
   $sqldata=mysqli_query($conn,$sqlget)or die('error getting');
   echo "<table>";
   echo "<tr><th>NAME</th><th>EMAIL</th><th>GENDER</th><th>WEBSITE LINK</th></tr>";
   while($fetch=mysqli_fetch_assoc($sqldata)){
      echo "\r\n";
      echo  "<tr>";
      echo "<td>{$fetch['name']}</td>";
      echo "<td>{$fetch['email']}</td>";
      echo "<td>{$fetch['gender']}</td>";
      echo "<td>{$fetch['website']}</td>";
      echo " </tr>";
      echo "\n";
  }
  echo "</table>"?>
   </div>

</body>
</html>