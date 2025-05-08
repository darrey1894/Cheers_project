<?php
$page_title = "Dashboard";
include 'header.php';
?>

<h1 class="text-center mb-4" style="color: #2c3e50;">Welcome, Student!</h1>
<div class="row">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-home fa-3x mb-3" style="color: #3498db;"></i>
                <h5 class="card-title">View Properties</h5>
                <a href="view_properties.php" class="btn btn-primary">Go</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-exclamation-circle fa-3x mb-3" style="color: #e74c3c;"></i>
                <h5 class="card-title">Submit Report</h5>
                <a href="submit_report.php" class="btn btn-primary">Go</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-file-alt fa-3x mb-3" style="color: #2ecc71;"></i>
                <h5 class="card-title">View Reports</h5>
                <a href="view_reports.php" class="btn btn-primary">Go</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>