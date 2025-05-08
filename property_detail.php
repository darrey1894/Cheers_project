<?php
include 'db.php';
$page_title = "Property Details";
include 'header.php';
?>
<style>
    .nav-tabs .nav-link.active {
        background-color: #2c3e50 !important; /* same dark as header */
        color: #fff !important;               /* white text */
        border-color: transparent transparent #fff transparent;
    }

    .nav-tabs .nav-link {
        color: #ecf0f1; /* light gray for inactive tabs */
    }

    .nav-tabs .nav-link:hover {
        color: #fff !important;
    }
</style>

<div class="container mt-5">
    <?php

    $lmk_key = $_GET['lmk_key'] ?? '';
    $result = $conn->query("SELECT * FROM properties WHERE lmk_key = '$lmk_key'");

    if ($result->num_rows == 1) {
        $property = $result->fetch_assoc();
        ?>
        <h3 class="mb-4 text-center" style="color: #2c3e50;"><b><i class="fas fa-home"></i> <small>Post Code:</small> <?php echo $property['postcode']; ?></b></h3>
        <h5 class="mb-4 text-center" style="color: #2c3e50;"><b><i class="fas fa-map-marker-alt"></i> <?php echo $property['address']; ?></b></h5>

        <!-- Main Card with Tabbed Navigation -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white" style="background-color: black !important;">
                <ul class="nav nav-tabs card-header-tabs" id="propertyTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" data-mdb-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true"><i class="fas fa-info-circle"></i> Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="energy-tab" data-mdb-toggle="tab" href="#energy" role="tab" aria-controls="energy" aria-selected="false"><i class="fas fa-bolt"></i> Energy Analysis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="report-tab" data-mdb-toggle="tab" href="#report" role="tab" aria-controls="report" aria-selected="false"><i class="fas fa-exclamation-circle"></i> Report Issue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reports-tab" data-mdb-toggle="tab" href="#reports" role="tab" aria-controls="reports" aria-selected="false"><i class="fas fa-file-alt"></i> Previous Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tips-tab" data-mdb-toggle="tab" href="#tips" role="tab" aria-controls="tips" aria-selected="false" onclick="startEnergyTips('<?php echo $lmk_key; ?>')"><i class="fas fa-lightbulb"></i> Energy Tips</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="propertyTabContent">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="row g-4">
                            <!-- Energy Ratings -->
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body bg-light rounded p-4">
                                        <h5 class="card-title text-center text-dark mb-4">
                                            <i class="fas fa-bolt text-warning me-2"></i>Energy Ratings
                                        </h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-3"><i class="fas fa-battery-half text-success me-2"></i>
                                                <strong>Current:</strong> <span class="badge bg-success"><?php echo $property['current_energy_rating']; ?></span> 
                                                <small>(<?php echo $property['current_energy_efficiency']; ?>/100)</small>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-battery-full text-primary me-2"></i>
                                                <strong>Potential:</strong> <span class="badge bg-primary"><?php echo $property['potential_energy_rating']; ?></span> 
                                                <small>(<?php echo $property['potential_energy_efficiency']; ?>/100)</small>
                                            </li>
                                            <li class="mb-2"><i class="fas fa-leaf text-success me-2"></i>
                                                <strong>Env. Impact Current:</strong> <?php echo $property['environment_impact_current']; ?>/100
                                            </li>
                                            <li><i class="fas fa-seedling text-primary me-2"></i>
                                                <strong>Env. Impact Potential:</strong> <?php echo $property['environment_impact_potential']; ?>/100
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Property Details -->
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body bg-white rounded p-4">
                                        <h5 class="card-title text-center text-dark mb-4">
                                            <i class="fas fa-house-user text-info me-2"></i>Property Details
                                        </h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-3"><i class="fas fa-home text-secondary me-2"></i>
                                                <strong>Type:</strong> <?php echo $property['property_type']; ?>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-th-large text-secondary me-2"></i>
                                                <strong>Built Form:</strong> <?php echo $property['built_form']; ?>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-hourglass-half text-secondary me-2"></i>
                                                <strong>Construction Age:</strong> <?php echo $property['construction_age_band']; ?>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-expand-arrows-alt text-secondary me-2"></i>
                                                <strong>Floor Area:</strong> <?php echo $property['total_floor_area']; ?> m²
                                            </li>
                                            <li class="mb-3"><i class="fas fa-door-open text-secondary me-2"></i>
                                                <strong>Rooms:</strong> <?php echo $property['number_habitable_rooms']; ?> 
                                                (<?php echo $property['number_heated_rooms']; ?> heated)
                                            </li>
                                            <li><i class="fas fa-layer-group text-secondary me-2"></i>
                                                <strong>Floor Level:</strong> <?php echo $property['floor_level'] ?: 'N/A'; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Property Features -->
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body bg-light rounded p-4">
                                        <h5 class="card-title text-center text-dark mb-4">
                                            <i class="fas fa-cogs text-primary me-2"></i>Features
                                        </h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-3"><i class="fas fa-fire text-danger me-2"></i>
                                                <strong>Main Fuel:</strong> <?php echo $property['main_fuel']; ?>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-plug text-dark me-2"></i>
                                                <strong>Energy Tariff:</strong> <?php echo $property['energy_tariff']; ?>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-gas-pump text-warning me-2"></i>
                                                <strong>Mains Gas:</strong> <?php echo $property['mains_gas_flag']; ?>
                                            </li>
                                            <li class="mb-3"><i class="fas fa-window-restore text-secondary me-2"></i>
                                                <strong>Glazing:</strong> <?php echo $property['windows_description']; ?> 
                                                (<?php echo $property['multi_glaze_proportion']; ?>%)
                                            </li>
                                            <li><i class="fas fa-lightbulb text-warning me-2"></i>
                                                <strong>Low Energy Lighting:</strong> <?php echo $property['low_energy_lighting']; ?>%
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Energy Analysis Tab -->
                    <div class="tab-pane fade" id="energy" role="tabpanel" aria-labelledby="energy-tab">
                        <div class="row g-4">
                            <!-- Date Range Filter -->
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="startMonth" class="form-label">Start Month:</label>
                                        <select id="startMonth" class="form-select" onchange="updateCharts()">
                                            <?php
                                            $month_options = ['Apr 2023', 'May 2023', 'Jun 2023', 'Jul 2023', 'Aug 2023', 'Sep 2023', 
                                                            'Oct 2023', 'Nov 2023', 'Dec 2023', 'Jan 2024', 'Feb 2024', 'Mar 2024',
                                                            'Apr 2024', 'May 2024', 'Jun 2024', 'Jul 2024', 'Aug 2024', 'Sep 2024', 
                                                            'Oct 2024', 'Nov 2024', 'Dec 2024', 'Jan 2025', 'Feb 2025', 'Mar 2025'];
                                            foreach ($month_options as $month) {
                                                echo "<option value='$month'>$month</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endMonth" class="form-label">End Month:</label>
                                        <select id="endMonth" class="form-select" onchange="updateCharts()">
                                            <?php
                                            foreach ($month_options as $month) {
                                                echo "<option value='$month'" . ($month == 'Mar 2025' ? ' selected' : '') . ">$month</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Line Chart: Energy Consumption -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-chart-line text-success"></i> Energy Consumption (kWh)</h5>
                                        <canvas id="energyConsumptionChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Line Chart: CO2 Emissions -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-smog text-danger"></i> CO2 Emissions (kg)</h5>
                                        <canvas id="co2EmissionsChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Line Chart: Energy Cost -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-pound-sign text-primary"></i> Energy Cost (£)</h5>
                                        <canvas id="energyCostChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Line Chart: Energy Consumption Forecast -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-chart-line text-primary"></i> Energy Consumption Forecast (kWh)</h5>
                                        <canvas id="energyForecastChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Line Chart: CO2 Emissions Forecast -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-smog text-warning"></i> CO2 Emissions Forecast (kg)</h5>
                                        <canvas id="co2ForecastChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Line Chart: Energy Cost Forecast -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-pound-sign text-info"></i> Energy Cost Forecast (£)</h5>
                                        <canvas id="costForecastChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Pie Chart: Energy Breakdown -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-pie-chart text-info"></i> Current Costs Breakdown</h5>
                                        <canvas id="energyBreakdownChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Pie Chart: Lighting Efficiency -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-lightbulb text-warning"></i> Lighting Efficiency</h5>
                                        <canvas id="lightingEfficiencyChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        <?php
                        // Read CSV for energy consumption
                        $csv_file = 'data/octopus-1413985791007-21J0016813.csv'; 
                        $daily_total = 0;
                        $interval_count = 0;
                        if (($handle = fopen($csv_file, 'r')) !== false) {
                            // Skip header
                            fgetcsv($handle);
                            // Sum consumption
                            while (($row = fgetcsv($handle)) !== false) {
                                $consumption = floatval($row[2]); // Consumption column (kWh)
                                $daily_total += $consumption;
                                $interval_count++;
                            }
                            fclose($handle);
                        } else {
                            // Fallback if CSV not found
                            $daily_total = 23.87; // Based on 716 kWh / 30 days
                            $interval_count = 48; // Assumed intervals
                            echo "console.error('CSV file not found, using fallback daily total: $daily_total kWh');";
                        }

                        // Calculate monthly total
                        $days_in_data = $interval_count / 48; // Assuming 48 intervals per day
                        if ($days_in_data < 1) $days_in_data = 1; // At least one day
                        $daily_average = $daily_total / $days_in_data;
                        $base_monthly = round($daily_average * 30, 2); // Monthly total (kWh)

                        // Generate 24-month actual data (Apr 2023–Mar 2025)
                        $months = ['Apr 2023', 'May 2023', 'Jun 2023', 'Jul 2023', 'Aug 2023', 'Sep 2023', 
                                'Oct 2023', 'Nov 2023', 'Dec 2023', 'Jan 2024', 'Feb 2024', 'Mar 2024',
                                'Apr 2024', 'May 2024', 'Jun 2024', 'Jul 2024', 'Aug 2024', 'Sep 2024', 
                                'Oct 2024', 'Nov 2024', 'Dec 2024', 'Jan 2025', 'Feb 2025', 'Mar 2025'];
                        $forecast_months = ['Apr 2025', 'May 2025', 'Jun 2025', 'Jul 2025', 'Aug 2025', 'Sep 2025'];
                        $energy_actual = [];
                        $co2_actual = [];
                        $cost_actual = [];
                        $seasonal_pattern = [0.98, 0.95, 0.93, 0.92, 0.95, 1.00, 1.05, 1.08, 1.10, 1.15, 1.12, 1.10];
                        $seasonal_sum = array_sum($seasonal_pattern); // 12.33
                        $avg_factor = $seasonal_sum / 12; // ~1.0275

                        // Normalize seasonal pattern
                        $normalized_pattern = array_map(function($factor) use ($avg_factor) {
                            return $factor / $avg_factor;
                        }, $seasonal_pattern);

                        for ($i = 0; $i < 24; $i++) {
                            $seasonal_index = $i % 12;
                            $monthly_energy = round($base_monthly * $normalized_pattern[$seasonal_index], 2);
                            $energy_actual[] = $monthly_energy;
                            $co2_actual[] = round($monthly_energy * 0.193, 2); // CO2 (kg) = Energy * 0.193
                            $cost_actual[] = round($monthly_energy * 0.27, 2); // Cost (£) = Energy * 0.27 £/kWh
                        }

                        // Linear regression for energy
                        $n = 24;
                        $x = range(0, 23);
                        $sum_x = array_sum($x);
                        $sum_y_energy = array_sum($energy_actual);
                        $sum_xy_energy = 0;
                        $sum_xx = 0;
                        for ($i = 0; $i < $n; $i++) {
                            $sum_xy_energy += $x[$i] * $energy_actual[$i];
                            $sum_xx += $x[$i] * $x[$i];
                        }
                        $m_energy = ($n * $sum_xy_energy - $sum_x * $sum_y_energy) / ($n * $sum_xx - $sum_x * $sum_x);
                        $b_energy = ($sum_y_energy - $m_energy * $sum_x) / $n;

                        // Regression accuracy for energy
                        $y_mean_energy = $sum_y_energy / $n;
                        $ss_tot_energy = 0;
                        $ss_res_energy = 0;
                        $mse_energy = 0;
                        $mae_energy = 0;
                        for ($i = 0; $i < $n; $i++) {
                            $y_pred = $m_energy * $i + $b_energy;
                            $ss_tot_energy += pow($energy_actual[$i] - $y_mean_energy, 2);
                            $ss_res_energy += pow($energy_actual[$i] - $y_pred, 2);
                            $mse_energy += pow($energy_actual[$i] - $y_pred, 2);
                            $mae_energy += abs($energy_actual[$i] - $y_pred);
                        }
                        $r2_energy = $ss_tot_energy ? 1 - ($ss_res_energy / $ss_tot_energy) : 0;
                        $mse_energy = $mse_energy / $n;
                        $mae_energy = $mae_energy / $n;

                        // Linear regression for CO2
                        $sum_y_co2 = array_sum($co2_actual);
                        $sum_xy_co2 = 0;
                        for ($i = 0; $i < $n; $i++) {
                            $sum_xy_co2 += $x[$i] * $co2_actual[$i];
                        }
                        $m_co2 = ($n * $sum_xy_co2 - $sum_x * $sum_y_co2) / ($n * $sum_xx - $sum_x * $sum_x);
                        $b_co2 = ($sum_y_co2 - $m_co2 * $sum_x) / $n;

                        // Regression accuracy for CO2
                        $y_mean_co2 = $sum_y_co2 / $n;
                        $ss_tot_co2 = 0;
                        $ss_res_co2 = 0;
                        $mse_co2 = 0;
                        $mae_co2 = 0;
                        for ($i = 0; $i < $n; $i++) {
                            $y_pred = $m_co2 * $i + $b_co2;
                            $ss_tot_co2 += pow($co2_actual[$i] - $y_mean_co2, 2);
                            $ss_res_co2 += pow($co2_actual[$i] - $y_pred, 2);
                            $mse_co2 += pow($co2_actual[$i] - $y_pred, 2);
                            $mae_co2 += abs($co2_actual[$i] - $y_pred);
                        }
                        $r2_co2 = $ss_tot_co2 ? 1 - ($ss_res_co2 / $ss_tot_co2) : 0;
                        $mse_co2 = $mse_co2 / $n;
                        $mae_co2 = $mae_co2 / $n;

                        // Linear regression for cost
                        $sum_y_cost = array_sum($cost_actual);
                        $sum_xy_cost = 0;
                        for ($i = 0; $i < $n; $i++) {
                            $sum_xy_cost += $x[$i] * $cost_actual[$i];
                        }
                        $m_cost = ($n * $sum_xy_cost - $sum_x * $sum_y_cost) / ($n * $sum_xx - $sum_x * $sum_x);
                        $b_cost = ($sum_y_cost - $m_cost * $sum_x) / $n;

                        // Regression accuracy for cost
                        $y_mean_cost = $sum_y_cost / $n;
                        $ss_tot_cost = 0;
                        $ss_res_cost = 0;
                        $mse_cost = 0;
                        $mae_cost = 0;
                        for ($i = 0; $i < $n; $i++) {
                            $y_pred = $m_cost * $i + $b_cost;
                            $ss_tot_cost += pow($cost_actual[$i] - $y_mean_cost, 2);
                            $ss_res_cost += pow($cost_actual[$i] - $y_pred, 2);
                            $mse_cost += pow($cost_actual[$i] - $y_pred, 2);
                            $mae_cost += abs($cost_actual[$i] - $y_pred);
                        }
                        $r2_cost = $ss_tot_cost ? 1 - ($ss_res_cost / $ss_tot_cost) : 0;
                        $mse_cost = $mse_cost / $n;
                        $mae_cost = $mae_cost / $n;

                        // Forecast values (Apr 2025–Sep 2025)
                        $energy_forecast = [];
                        $co2_forecast = [];
                        $cost_forecast = [];
                        $forecast_seasonal = [0.98, 0.95, 0.93, 0.92, 0.95, 1.00]; // Apr–Sep
                        for ($i = 0; $i < 6; $i++) {
                            $month_index = 24 + $i;
                            $base_energy = $m_energy * $month_index + $b_energy;
                            $base_co2 = $m_co2 * $month_index + $b_co2;
                            $base_cost = $m_cost * $month_index + $b_cost;
                            $seasonal_factor = $forecast_seasonal[$i] / $avg_factor;
                            $energy_forecast[] = round($base_energy * $seasonal_factor, 2);
                            $co2_forecast[] = round($base_co2 * $seasonal_factor, 2);
                            $cost_forecast[] = round($base_cost * $seasonal_factor, 2);
                        }

                        // Debugging
                        echo "console.log('Daily Total (kWh):', $daily_total);";
                        echo "console.log('Interval Count:', $interval_count);";
                        echo "console.log('Days in Data:', $days_in_data);";
                        echo "console.log('Daily Average (kWh):', $daily_average);";
                        echo "console.log('Base Monthly (kWh):', $base_monthly);";
                        echo "console.log('Months:', " . json_encode($months) . ");";
                        echo "console.log('Energy Actual:', " . json_encode($energy_actual) . ");";
                        echo "console.log('CO2 Actual:', " . json_encode($co2_actual) . ");";
                        echo "console.log('Cost Actual:', " . json_encode($cost_actual) . ");";
                        echo "console.log('Energy Regression: R²=', $r2_energy, ', MSE=', $mse_energy, ', MAE=', $mae_energy);";
                        echo "console.log('CO2 Regression: R²=', $r2_co2, ', MSE=', $mse_co2, ', MAE=', $mae_co2);";
                        echo "console.log('Cost Regression: R²=', $r2_cost, ', MSE=', $mse_cost, ', MAE=', $mae_cost);";
                        echo "console.log('Forecast Months:', " . json_encode($forecast_months) . ");";
                        echo "console.log('Energy Forecast:', " . json_encode($energy_forecast) . ");";
                        echo "console.log('CO2 Forecast:', " . json_encode($co2_forecast) . ");";
                        echo "console.log('Cost Forecast:', " . json_encode($cost_forecast) . ");";
                        ?>

                        const months = <?php echo json_encode($months); ?>;
                        const forecastMonths = <?php echo json_encode($forecast_months); ?>;
                        const energyActual = <?php echo json_encode($energy_actual); ?>;
                        const co2Actual = <?php echo json_encode($co2_actual); ?>;
                        const costActual = <?php echo json_encode($cost_actual); ?>;
                        const energyForecast = <?php echo json_encode($energy_forecast); ?>;
                        const co2Forecast = <?php echo json_encode($co2_forecast); ?>;
                        const costForecast = <?php echo json_encode($cost_forecast); ?>;

                        let energyChart, co2Chart, costChart, energyForecastChart, co2ForecastChart, costForecastChart;

                        function updateCharts() {
                            const startMonth = document.getElementById('startMonth').value;
                            const endMonth = document.getElementById('endMonth').value;
                            const startIndex = months.indexOf(startMonth);
                            const endIndex = months.indexOf(endMonth);

                            if (startIndex > endIndex) {
                                alert('End month must be after start month');
                                return;
                            }

                            // Slice data for the selected range
                            const filteredMonths = months.slice(startIndex, endIndex + 1);
                            const filteredEnergy = energyActual.slice(startIndex, endIndex + 1);
                            const filteredCo2 = co2Actual.slice(startIndex, endIndex + 1);
                            const filteredCost = costActual.slice(startIndex, endIndex + 1);

                            // Destroy existing charts
                            if (energyChart) energyChart.destroy();
                            if (co2Chart) co2Chart.destroy();
                            if (costChart) costChart.destroy();
                            if (energyForecastChart) energyForecastChart.destroy();
                            if (co2ForecastChart) co2ForecastChart.destroy();
                            if (costForecastChart) costForecastChart.destroy();

                            // Energy Consumption Chart
                            energyChart = new Chart(document.getElementById('energyConsumptionChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: filteredMonths,
                                    datasets: [{
                                        label: 'Energy Consumption (kWh)',
                                        data: filteredEnergy,
                                        borderColor: '#28a745',
                                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                        fill: false,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#28a745'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: false, title: { display: true, text: 'kWh' } },
                                        x: { title: { display: true, text: 'Month' } }
                                    },
                                    plugins: { 
                                        title: { display: true, text: 'Energy Consumption' },
                                        tooltip: { mode: 'index', intersect: false }
                                    },
                                    hover: { mode: 'index', intersect: false }
                                }
                            });

                            // CO2 Emissions Chart
                            co2Chart = new Chart(document.getElementById('co2EmissionsChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: filteredMonths,
                                    datasets: [{
                                        label: 'CO2 Emissions (kg)',
                                        data: filteredCo2,
                                        borderColor: '#dc3545',
                                        backgroundColor: 'rgba(220, 53, 69, 0.2)',
                                        fill: false,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#dc3545'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: false, title: { display: true, text: 'kg' } },
                                        x: { title: { display: true, text: 'Month' } }
                                    },
                                    plugins: { 
                                        title: { display: true, text: 'CO2 Emissions' },
                                        tooltip: { mode: 'index', intersect: false }
                                    },
                                    hover: { mode: 'index', intersect: false }
                                }
                            });

                            // Energy Cost Chart
                            costChart = new Chart(document.getElementById('energyCostChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: filteredMonths,
                                    datasets: [{
                                        label: 'Energy Cost (£)',
                                        data: filteredCost,
                                        borderColor: '#007bff',
                                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                                        fill: false,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#007bff'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: false, title: { display: true, text: '£' } },
                                        x: { title: { display: true, text: 'Month' } }
                                    },
                                    plugins: { 
                                        title: { display: true, text: 'Monthly Energy Cost' },
                                        tooltip: { mode: 'index', intersect: false }
                                    },
                                    hover: { mode: 'index', intersect: false }
                                }
                            });

                            // Energy Consumption Forecast Chart
                            energyForecastChart = new Chart(document.getElementById('energyForecastChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: forecastMonths,
                                    datasets: [{
                                        label: 'Forecasted Energy (kWh)',
                                        data: energyForecast,
                                        borderColor: '#007bff',
                                        backgroundColor: 'rgba(0, 123, 255, 0.2)',
                                        fill: false,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#007bff'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: false, title: { display: true, text: 'kWh' } },
                                        x: { title: { display: true, text: 'Month' } }
                                    },
                                    plugins: { 
                                        title: { display: true, text: 'Energy Consumption Forecast (Next 6 Months)' },
                                        tooltip: { mode: 'index', intersect: false }
                                    },
                                    hover: { mode: 'index', intersect: false }
                                }
                            });

                            // CO2 Emissions Forecast Chart
                            co2ForecastChart = new Chart(document.getElementById('co2ForecastChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: forecastMonths,
                                    datasets: [{
                                        label: 'Forecasted CO2 (kg)',
                                        data: co2Forecast,
                                        borderColor: '#ff6b6b',
                                        backgroundColor: 'rgba(255, 107, 107, 0.2)',
                                        fill: false,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#ff6b6b'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: false, title: { display: true, text: 'kg' } },
                                        x: { title: { display: true, text: 'Month' } }
                                    },
                                    plugins: { 
                                        title: { display: true, text: 'CO2 Emissions Forecast (Next 6 Months)' },
                                        tooltip: { mode: 'index', intersect: false }
                                    },
                                    hover: { mode: 'index', intersect: false }
                                }
                            });

                            // Energy Cost Forecast Chart
                            costForecastChart = new Chart(document.getElementById('costForecastChart').getContext('2d'), {
                                type: 'line',
                                data: {
                                    labels: forecastMonths,
                                    datasets: [{
                                        label: 'Forecasted Cost (£)',
                                        data: costForecast,
                                        borderColor: '#17a2b8',
                                        backgroundColor: 'rgba(23, 162, 184, 0.2)',
                                        fill: false,
                                        tension: 0.4,
                                        pointRadius: 5,
                                        pointBackgroundColor: '#17a2b8'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        y: { beginAtZero: false, title: { display: true, text: '£' } },
                                        x: { title: { display: true, text: 'Month' } }
                                    },
                                    plugins: { 
                                        title: { display: true, text: 'Energy Cost Forecast (Next 6 Months)' },
                                        tooltip: { mode: 'index', intersect: false }
                                    },
                                    hover: { mode: 'index', intersect: false }
                                }
                            });
                        }

                        // Initial chart render
                        updateCharts();

                        new Chart(document.getElementById('energyBreakdownChart').getContext('2d'), {
                            type: 'pie',
                            data: {
                                labels: ['Lighting', 'Heating', 'Hot Water'],
                                datasets: [{
                                    data: [<?php echo $property['lighting_cost_current']; ?>, <?php echo $property['heating_cost_current']; ?>, <?php echo $property['hot_water_cost_current']; ?>],
                                    backgroundColor: ['#007bff', '#ffc107', '#17a2b8'],
                                    borderColor: ['#0056b3', '#e0a800', '#138496'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { title: { display: true, text: 'Current Costs Breakdown' } }
                            }
                        });

                        

                        new Chart(document.getElementById('lightingEfficiencyChart').getContext('2d'), {
                            type: 'pie',
                            data: {
                                labels: ['Low Energy', 'Standard'],
                                datasets: [{
                                    data: [<?php echo $property['low_energy_lighting']; ?>, <?php echo 100 - $property['low_energy_lighting']; ?>],
                                    backgroundColor: ['#28a745', '#dc3545'],
                                    borderColor: ['#218838', '#c82333'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { title: { display: true, text: 'Lighting Efficiency (%)' } }
                            }
                        });
                        </script>
                    </div>

                    <!-- Report Issue Tab -->
                    <div class="tab-pane fade" id="report" role="tabpanel" aria-labelledby="report-tab">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-exclamation-circle text-danger"></i> Report an Issue</h5>
                                <form action="submit_report_process.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    <input type="hidden" name="property_lmk_key" value="<?php echo $lmk_key; ?>">
                                    <div class="mb-3">
                                        <label for="issue_type" class="form-label">Issue Type</label>
                                        <select name="issue_type" id="issue_type" class="form-select" required onchange="toggleOtherIssueField(this)">
                                            <option value="">Select Issue Type</option>
                                            <option value="Mold">Mold</option>
                                            <option value="Dampness">Dampness</option>
                                            <option value="Poor Heating">Poor Heating</option>
                                            <option value="Broken Windows">Broken Windows</option>
                                            <option value="Excessive Energy Bills">Excessive Energy Bills</option>
                                            <option value="Other">Other (please specify)</option>
                                        </select>
                                        <div class="invalid-feedback">Please select an issue type.</div>
                                    </div>

                                    <!-- This field appears only when "Other" is selected -->
                                    <div class="mb-3 d-none" id="other-issue-group">
                                        <label for="other_issue" class="form-label">Specify the Issue</label>
                                        <input type="text" name="other_issue" id="other_issue" class="form-control" placeholder="Specify the Issue" />
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="description" class="form-control" placeholder="Describe the issue" required></textarea>
                                        <div class="invalid-feedback">Please provide a description.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Attach an Image (optional)</label>
                                        <input type="file" name="photo" class="form-control" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                    <label for="video" class="form-label">Attach a Video (optional)</label>
                                        <input type="file" name="video" class="form-control" accept="video/*">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Reports Tab -->
                    <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                        <?php
                        $reports_result = $conn->query("SELECT issue_type, description, submitted_at FROM reports WHERE property_lmk_key = '$lmk_key'");
                        if ($reports_result->num_rows > 0) {
                            echo '<div class="row g-4">';
                            while ($report = $reports_result->fetch_assoc()) {
                                echo "<div class='col-md-6'><div class='card'><div class='card-body'><h6><i class='fas fa-exclamation-triangle text-danger'></i> {$report['issue_type']}</h6><p>{$report['description']}</p><small class='text-muted'>Submitted on: " . date('F d, Y', strtotime($report['submitted_at'])) . "</small></div></div></div>";
                            }
                            echo '</div>';
                        } else {
                            echo "<p class='text-muted'>No reports submitted for this property yet.</p>";
                        }
                        ?>
                    </div>

                    <!-- Energy Tips Tab -->
                    <div class="tab-pane fade" id="tips" role="tabpanel" aria-labelledby="tips-tab">
                        <h5>Tips for Postcode: <?php echo $property['postcode']; ?> <span style="float: right;"><a href="https://www.groundwork.org.uk/energy-and-finance-support-in-england/" target="_blank" class="btn btn-primary">Green Doctor Support</a> <a href="https://www.groundwork.org.uk/greendoctor/get-help/green-doctor-request-for-support/" class="btn btn-primary" target="_blank">Book session</a></span></h5>
                        <div class="row g-4" id="energyTipsContent">
                            <p class="text-muted">Loading energy-saving tip...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<h1 class='text-center text-danger'>Property not found</h1>";
    }

    $conn->close();
    ?>
</div>

<style>
    .tipFadeInOut {
        animation: fadeInOut 5s infinite;
    }
    @keyframes fadeInOut {
        0% { opacity: 0; }
        20% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>

<script>
let tipsInterval;

function startEnergyTips(lmkKey) {
    fetch(`get_energy_tips.php?lmk_key=${lmkKey}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('energyTipsContent').innerHTML = '<p class="text-danger">Error: ' + data.error + '</p>';
                return;
            }
            const tipsDiv = document.getElementById('energyTipsContent');
            tipsDiv.innerHTML = `
                <div id="currentTip" class="col-12">
                    <div class="card shadow-sm border-0 animate__animated animate__fadeIn">
                        <div class="card-body d-flex align-items-center" style="background: linear-gradient(135deg, #e0f7fa, #ffffff); border-left: 5px solid #00bcd4;">
                            <div class="me-3">
                                <i class="fas fa-lightbulb fa-2x text-warning animate__animated animate__flash animate__infinite"></i>
                            </div>
                            <div>
                                <p class="card-text fw-semibold mb-0" style="font-size: 1.1rem; color: #333;">Your personalized energy tip will appear here!</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;


            const tipElement = document.querySelector('#currentTip .card-text');
            function showRandomTip() {
                const randomTip = data[Math.floor(Math.random() * data.length)];
                tipElement.innerHTML = randomTip;
            }

            // Show first tip immediately
            showRandomTip();

            // Clear any existing interval and start a new one
            clearInterval(tipsInterval);
            tipsInterval = setInterval(showRandomTip, 5000);
        })
        .catch(error => console.error('Error fetching tips:', error));
}

// Stop the interval when leaving the tab
document.getElementById('tips-tab').addEventListener('hidden.mdb.tab', () => clearInterval(tipsInterval));

function toggleOtherIssueField(selectElement) {
    const otherGroup = document.getElementById('other-issue-group');
    const otherInput = document.getElementById('other_issue');
    if (selectElement.value === "Other") {
        otherGroup.classList.remove('d-none');
        otherInput.setAttribute('required', 'required');
    } else {
        otherGroup.classList.add('d-none');
        otherInput.removeAttribute('required');
        otherInput.value = ''; // Clear it if not needed
    }
}
</script>

<?php include 'footer.php'; ?>