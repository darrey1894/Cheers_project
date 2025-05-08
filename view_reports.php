<?php  
$page_title = "View Reports";
include 'header.php';
include_once("db.php");

$user_id = $_SESSION['user_id'];

// Fetch all reports and their property addresses
$report_result = $conn->query("SELECT r.*, p.address FROM reports r 
    JOIN properties p ON r.property_lmk_key = p.lmk_key 
    WHERE r.user_id = $user_id 
    ORDER BY r.submitted_at DESC");

// Fetch total report count per date
$chart_query = "
    SELECT DATE(submitted_at) as report_date, COUNT(*) as count
    FROM reports 
    WHERE user_id = $user_id 
    GROUP BY report_date 
    ORDER BY report_date ASC
";

$chart_result = $conn->query($chart_query);
$dates = [];
$counts = [];

while ($row = $chart_result->fetch_assoc()) {
    $dates[] = $row['report_date'];
    $counts[] = $row['count'];
}
?>

<div class="container mt-5">
    <h3 class="mb-4 text-center"><i class="fas fa-file-alt me-2 text-primary"></i><b>My Reports</b></h3>

    <div class="row g-4">
        <?php if ($report_result->num_rows > 0): ?>
            <?php while ($row = $report_result->fetch_assoc()): ?>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title text-dark"><i class="fas fa-home me-2 text-secondary"></i><?php echo $row['address']; ?></h5>
                            <p class="mb-1">
                                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                <strong>Issue:</strong> <?php echo htmlspecialchars($row['issue_type']); ?>
                            </p>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i>Submitted on: <?php echo date('F d, Y', strtotime($row['submitted_at'])); ?></small>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-muted">No reports found.</p>
        <?php endif; ?>
    </div>

    <!-- Line Chart Section -->
    <div class="col-12 mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 text-dark">
                    <i class="fas fa-chart-line me-2 text-info"></i>Report Submissions Over Time
                </h5>
                <canvas id="reportsLineChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reportsLineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Reports Submitted',
                data: <?php echo json_encode($counts); ?>,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2980b9',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#2c3e50',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#34495e',
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Number of Reports',
                        color: '#34495e'
                    }
                },
                x: {
                    ticks: {
                        color: '#34495e'
                    },
                    title: {
                        display: true,
                        text: 'Date',
                        color: '#34495e'
                    }
                }
            }
        }
    });
</script>

<?php include 'footer.php'; ?>
