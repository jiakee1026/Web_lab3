<?php

include_once("dbconnect.php");
$sqltutor = "SELECT * FROM tbl_tutors";

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}
$stmt = $conn->prepare($sqltutor);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutor = $sqltutor . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutor);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$conn= null;

function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/menu.js" defer></script>
    <link rel="stylesheet" href="../css/style.css">
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
    </div>
    <br>

    <div class="w3-container" style="background-color: #D6EAF8">
        <p><strong>Tutors</strong></p>
    </div>
    <br>


    <div class="w3-grid-template">
    <?php
    $i = 0;
        foreach ($rows as $tutor) {
            $i++;
            $ttid = $tutor['tutor_id'];
            $ttemail = $tutor['tutor_email'];
            $ttphone = $tutor['tutor_phone'];
            $ttname = truncate($tutor['tutor_name'],15);
            $ttpassword = $tutor['tutor_password'];
            $ttdesc = $tutor['tutor_description'];
            $ttdatereg = $tutor['tutor_datereg'];
        
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-blue-grey'><h5><b>$ttname</b></h5></header>";
            echo "<a href='tutordetails.php?ttid=$ttid' style='text-decoration: none;'> <img class='w3-image' src=../assets/tutors/$ttid.jpg" .
                " onerror=this.onerror=null;this.src='../../admin/res/newproduct.jpg'"
                . " style='width:100%;height:200px'></a><hr>";
            echo "<div class='w3-container'></div>
            </div>";
        }
    ?>

    </div>
    <br>

    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "index.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>
    
    <footer>
        <p class="w3-container w3-padding-32 w3-center" style="background-color: #D6EAF8">Copyright MYTutor&copy;</p>
    </footer>


</html>