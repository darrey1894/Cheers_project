<?php
include_once('session.php');
function log_in(){
    if (isset($_SESSION["email"]) || isset($_SESSION["username"])) {
        return true;
    }

}
if(!log_in()){
 header("Location: ./");
}else{
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Energy Management"; ?></title>
    <!-- MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding-left: 240px; /* Space for side nav */
            transition: all 0.3s ease;
        }
        .sidenav {
            height: 100%;
            width: 240px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #2c3e50;
            padding-top: 60px;
            transition: 0.5s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidenav a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidenav a:hover {
            color: #3498db;
            background-color: #34495e;
            transform: translateX(10px);
        }
        .sidenav .active {
            background-color: #3498db;
            color: white;
        }
        .navbar {
            background-color: #2c3e50 !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .nav-link:hover {
            color: #3498db !important;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-primary {
            background-color: #3498db !important;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9 !important;
            transform: scale(1.1);
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Side Navigation -->
    <div class="sidenav" id="sideNav">
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="view_properties.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_properties.php' ? 'active' : ''; ?>"><i class="fas fa-home"></i> View Properties</a>
        <a href="submit_report.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'submit_report.php' ? 'active' : ''; ?>"><i class="fas fa-exclamation-circle"></i> Submit Report</a>
        <a href="view_reports.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_reports.php' ? 'active' : ''; ?>"><i class="fas fa-file-alt"></i> View Reports</a>
        <a href="energy_tips.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'energy_tips.php' ? 'active' : ''; ?>"><i class="fas fa-lightbulb"></i> Energy Tips</a>
        <a href="logout.php" class=""><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-light" id="menuBtn"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand" href="#">Cheers Crowd Sourcing System - <b style="color: orange">[<?php echo $_SESSION["username"]; ?>]</b></a>
        </div>
    </nav>

    <div class="container mt-5 pt-4">