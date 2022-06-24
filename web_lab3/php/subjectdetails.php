<?php
include_once("dbconnect.php");
if (isset($_GET['subjectid'])) {
    $subjectid = $_GET['subjectid'];
    $sqlsubjects = "SELECT * FROM tbl_subjects WHERE subject_id = '$subjectid'";
    
    $stmt = $conn->prepare($sqlsubjects);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Product not found.');</script>";
        echo "<script> window.location.replace('index.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('index.php')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/menu.js" defer></script>
    <script src="../js/login.js" defer></script>

    <title>WELCOME TO MY TUTOR</title>
</head>

<body id="main" style="max-width:1200px;margin:0 auto;">
    <div class="w3-sidebar w3-bar-block w3-border" style="display:none;" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>
        <hr>
        <a href="index.php" class="w3-bar-item w3-button">Courses</a>
        <a href="tutorlistpage.php" class="w3-bar-item w3-button">Tutors</a>
        <a href="subscriptionpage.php" class="w3-bar-item w3-button">Subscription</a>
        <a href="#" class="w3-bar-item w3-button">Profile</a>
        <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
    </div>

    <div class="" style="background-color: #D6EAF8">
        <button class="w3-button w3-xlarge" onclick="w3_open()">☰</button>
    </div>
    <div class="w3-bar" style="background-color: #D6EAF8">
        <a href="logout.php" class="w3-bar-item w3-button w3-right">Logout</a>
        <div class="w3-container">
            <h3>Subject Details</h3>
            <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
        </div>
    </div>

    <div>
    <?php
        foreach ($rows as $subject) {
            
            $subjectid = $subject['subject_id'];
            $subjectname = $subject['subject_name'];
            $subjectdes = $subject['subject_description'];
            $subjectprice = number_format((float)$subject['subject_price'], 2, '.', ''); 
            $tutorid = $subject['tutor_id'];
            $subjectsessions = $subject['subject_sessions'];
            $subjectrating= $subject['subject_rating'];            
        }
        echo "<div class='w3-padding w3-center'><img class='w3-image resimg' src=../assets/courses/$subjectid.png" .
        " onerror=this.onerror=null;this.src='../../admin/res/newproduct.png'"
        . " ></div><hr>";
        echo "<div class='w3-container w3-padding-large'><h4><b>$subjectname</b></h4>";
        echo " <div><p><b>Description</b><br>$subjectdes</p><p><b>Subject Sessions:</b> $subjectsessions classes</p><p><b>Price:</b>RM $subjectprice</p><p><b>Rating:</b> $subjectrating</p>
        </div></div>";
        ?>
    </div>
    
    <footer>
        <p class="w3-container w3-padding-32 w3-center" style="background-color: #D6EAF8">Copyright MYTutor&copy;</p>
    </footer>
</body>

</html>