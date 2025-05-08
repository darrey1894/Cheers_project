<?php
$page_title = "View Properties";
include 'header.php';

// Database connection
include_once("db.php");

// Build the base query
$query = "SELECT lmk_key, address, postcode, current_energy_rating, potential_energy_rating, current_energy_efficiency, potential_energy_efficiency, built_form FROM properties WHERE 1=1";

// Handle Search
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
if (!empty($search)) {
    $query .= " AND address LIKE '%$search%' OR postcode LIKE '%$search%'";
}

// Handle Filters
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
if (!empty($filter)) {
    $valid_filters = ['current_energy_rating', 'potential_energy_rating', 'built_form', 'current_energy_efficiency', 'potential_energy_efficiency'];
    if (in_array($filter, $valid_filters)) {
        $query .= " ORDER BY $filter $order";
    }
}

$result = $conn->query($query);
?>

<div class="container mt-5">
    <h3 class="mb-4"><b>House Energy Performance Data</b></h3>

    <!-- Search and Filter Form -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <form method="GET" action="view_properties.php" class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Search by address..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="view_properties.php" class="input-group">
                <select name="filter" class="form-select">
                    <option value="">Sort By...</option>
                    <option value="current_energy_rating" <?php echo $filter === 'current_energy_rating' ? 'selected' : ''; ?>>Current Rating</option>
                    <option value="potential_energy_rating" <?php echo $filter === 'potential_energy_rating' ? 'selected' : ''; ?>>Potential Rating</option>
                    <option value="built_form" <?php echo $filter === 'built_form' ? 'selected' : ''; ?>>Built Form</option>
                    <option value="current_energy_efficiency" <?php echo $filter === 'current_energy_efficiency' ? 'selected' : ''; ?>>Current Efficiency</option>
                    <option value="potential_energy_efficiency" <?php echo $filter === 'potential_energy_efficiency' ? 'selected' : ''; ?>>Potential Efficiency</option>
                </select>
                <select name="order" class="form-select">
                    <option value="ASC" <?php echo $order === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                    <option value="DESC" <?php echo $order === 'DESC' ? 'selected' : ''; ?>>Descending</option>
                </select>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 position-relative">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $row['postcode']; ?></h5>
                            <p class="card-title"><?php echo $row['address']; ?></p>
                            <p>Type: <span class="text-muted"><?php echo $row['built_form']; ?></span></p>
                            <p>Current Rating: <span class="text-success"><?php echo $row['current_energy_rating']; ?></span></p>
                            <p>Potential Rating: <span class="text-primary"><?php echo $row['potential_energy_rating']; ?></span></p>
                            <canvas id="chart<?php echo $row['lmk_key']; ?>" style="max-height: 200px;"></canvas>
                            <a href="property_detail.php?lmk_key=<?php echo $row['lmk_key']; ?>" class="btn btn-secondary mt-3 align-self-end"><i class="fas fa-eye"></i> View Details</a>
                        </div>
                    </div>
                </div>
                <script>
                new Chart(document.getElementById('chart<?php echo $row['lmk_key']; ?>').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Current', 'Potential'],
                        datasets: [{
                            label: 'Energy Efficiency',
                            data: [<?php echo $row['current_energy_efficiency']; ?>, <?php echo $row['potential_energy_efficiency']; ?>],
                            backgroundColor: ['#e74c3c', '#3498db'],
                            borderColor: ['#c0392b', '#2980b9'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: { 
                            y: { 
                                beginAtZero: true, 
                                ticks: { color: '#2c3e50' },
                                title: { display: true, text: 'Efficiency Score', color: '#2c3e50' }
                            },
                            x: { ticks: { color: '#2c3e50' } }
                        },
                        plugins: { 
                            legend: { labels: { color: '#2c3e50' } },
                            title: { display: true, text: 'Energy Efficiency Comparison', color: '#2c3e50', font: { size: 16 } }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 1000, easing: 'easeInOutBounce' }
                    }
                });
                </script>
                <?php
            }
        } else {
            echo "<div class='col-12'><p class='text-muted'>No properties found matching your criteria.</p></div>";
        }
        $conn->close();
        ?>
    </div>
</div>

<style>
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>

<?php include 'footer.php'; ?>