<?php
include 'connection.php';

session_start();

echo("
    <div class='topnav pt-2'>
        <a href='index.php#' class='home-logo'>
            <img src='drawable/Logo.png' alt='img''>
        </a>
    <div class='font-poppins-medium options'>
");

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
    $currentuser = $_SESSION['username'];
    $name = $_SESSION['name'];
    $id = $_SESSION['id'];
    $privilege = $_SESSION['privilege'];

    if(!$privilege){
        //for normal registered users
        echo "
            <a href='index.php#'>Home</a>
            <a href='news.php'>News</a>
            <a href='officials.php'>Barangay Officials</a>
            <a href='committee.php'>Barangay Committees</a>
            <div class='dropdown'>
                <a class='dropbtn'>Documents
                    <img src='drawable/dropdown.png' alt='img'>
                </a>
                <div class='dropdown-content'>
                <a href='documentDtb.php'>Document list</a>
                    <a href='docreq.php'>Request document</a>
                    <a href='myDocReq.php'>My requests</a>
                </div>
            </div>
            <div class='dropdown'>
                <a class='dropbtn'>About
                    <img src='drawable/dropdown.png' alt='img'>
                </a>
                <div class='dropdown-content'>
                    <a href='about.php'>Barangay Information</a>
                    <a href='contactDtb.php'>Contact Information</a>
                </div>
            </div>
            <a href='profile.php'>Profile</a>
            <a href='logout.php'> <img src='drawable/person.png' alt='img'> Logout</a>
                ";
            }else{
        //for administrator
        echo "
        <a href='index.php#'>Home</a>
        <a href='news.php'>News</a>
        <a href='officials.php'>Barangay Officials</a>
        <a href='committee.php'>Barangay Committees</a>
        <div class='dropdown'>
            <a class='dropbtn'>Documents
                <img src='drawable/dropdown.png' alt='img'class='home-logo'>
            </a>
            <div class='dropdown-content'>
                <a href='documentDtb.php'>Document list</a>
                <a href='docreqDtb.php'>Document requests</a>
            </div>
        </div>
        <div class='dropdown'>
            <a class='dropbtn'>About
                <img src='drawable/dropdown.png' alt='img'class='home-logo'>
            </a>
            <div class='dropdown-content'>
                <a href='about.php'>Barangay Information</a>
                <a href='contactDtb.php'>Contact Information</a>
            </div>
        </div>
        <div class='dropdown'>
            <a class='dropbtn'>Database
                <img src='drawable/dropdown.png' alt='img'class='home-logo'>
            </a>
            <div class='dropdown-content'>
            <a href='adminDtb.php'>Admins</a>
            <a href='residentsDtb.php'>Residents</a>
            </div>
        </div>
        <a href='profile.php'>Profile</a>
        <a href='logout.php'> <img src='drawable/person.png' alt='img'> Logout</a>
        ";
    }
}else{
    //for users who are not logged in
    echo "
    <a href='index.php#'>Home</a>
    <a href='news.php'>News</a>
    <a href='officials.php'>Barangay Officials</a>
    <a href='committee.php'>Barangay Committees</a>
    <div class='dropdown'>
        <a class='dropbtn'>Documents
            <img src='drawable/dropdown.png' alt='img'class='home-logo'>
        </a>
        <div class='dropdown-content'>
        <a href='documentDtb.php'>Document List</a>
            <a href='docreq.php'>Request Document</a>
        </div>
    </div>
    <div class='dropdown'>
        <a class='dropbtn'>About
            <img src='drawable/dropdown.png' alt='img'class='home-logo'>
        </a>
        <div class='dropdown-content'>
            <a href='about.php'>Barangay Information</a>
            <a href='contactDtb.php'>Contact Information</a>
        </div>
    </div>
    <a href='login.php'> <img src='drawable/person.png' alt='img'> Login</a>
    ";
}

echo("</div></div>")

?>
