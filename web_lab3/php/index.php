<?php

include_once("dbconnect.php");

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];

    if ($operation == 'search') {
        $search = $_GET['search'];
        $sqlsubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
    }
} else {
    $sqlsubject = "SELECT * FROM tbl_subjects";
}

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}
$stmt = $conn->prepare($sqlsubject);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlsubject = $sqlsubject . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlsubject);
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
    </div>

    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3>Subject Search</h3>
        <form>
            <div class="w3-row">
                <p><input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" /></p>
            </div>
            <button class="w3-button w3-round w3-right" style="background-color: #D6EAF8" type="submit" name="submit" value="search">search</button>
        </form>

    </div>
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $subject) {

            $i++;
            $subjectid = $subject['subject_id'];
            $subjectname = truncate($subject['subject_name'],15);
            $subjectdes = $subject['subject_description'];
            $subjectprice = number_format((float)$subject['subject_price'], 2, '.', ''); 
            $tutorid = $subject['tutor_id'];
            $subjectsessions = $subject['subject_sessions'];
            $subjectrating= $subject['subject_rating'];
            
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-blue-grey'><h5><b>$subjectname</b></h5></header>";
            echo "<a href='subjectdetails.php?subjectid=$subjectid' style='text-decoration: none;'> <img class='w3-image' src=../assets/courses/$subjectid.png" .
                " onerror=this.onerror=null;this.src='../../admin/res/newproduct.jpg'"
                . " style='width:100%;height:200px'></a><hr>";
            echo "<div class='w3-container'><p>Session: $subjectsessions classes<br>Price: RM $subjectprice<br></div>
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

</body>

</html>