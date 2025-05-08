<?php
$page_title = "Energy Tips";
include 'header.php';
?>

<h3 class="mb-4"><b>Energy Saving Tips</b></h3>
<div class="row g-4" id="tips">
    <?php
    include_once("db.php");

    $user_id = $_SESSION['user_id'];
    $properties_result = $conn->query("SELECT DISTINCT r.property_lmk_key, p.building_reference_number 
                                        FROM reports r 
                                        JOIN properties p ON r.property_lmk_key = p.lmk_key 
                                        WHERE r.user_id = $user_id");

    if ($properties_result->num_rows > 0) {
        while ($property = $properties_result->fetch_assoc()) {
            $lmk_key = $property['property_lmk_key'];
            $building_ref = $property['building_reference_number'];
            ?>
            <div class="col-12 mb-4">
                <h3 class="text-primary">Tips for Building Ref: <?php echo $building_ref; ?></h3>
                <div class="row g-3" id="tips_<?php echo $lmk_key; ?>">
                    <p class="text-muted">Loading energy-saving tip...</p>
                </div>
            </div>
            <script>
            let tipsInterval_<?php echo $lmk_key; ?>;

            function startEnergyTips_<?php echo $lmk_key; ?>() {
                fetch('get_energy_tips.php?lmk_key=<?php echo $lmk_key; ?>')
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('tips_<?php echo $lmk_key; ?>').innerHTML = '<p class="text-danger">Error: ' + data.error + '</p>';
                            return;
                        }
                        const tipsDiv = document.getElementById('tips_<?php echo $lmk_key; ?>');
                        tipsDiv.innerHTML = `
                            <div class="col-12">
                                <div class="card blog-card">
                                    <div class="card-body tipFadeInOut" style="border-left: 5px solid #3498db;">
                                        <div id="currentTip_<?php echo $lmk_key; ?>"></div>
                                    </div>
                                </div>
                            </div>
                        `;

                        const tipElement = document.getElementById('currentTip_<?php echo $lmk_key; ?>');
                        function showRandomTip() {
                            const randomTip = data[Math.floor(Math.random() * data.length)];
                            tipElement.innerHTML = randomTip;
                        }

                        // Show first tip immediately
                        showRandomTip();

                        // Clear any existing interval and start a new one
                        // clearInterval(tipsInterval_<?php echo $lmk_key; ?>);
                        // tipsInterval_<?php echo $lmk_key; ?> = setInterval(showRandomTip, 5000);
                    })
                    .catch(error => console.error('Error fetching tips:', error));
            }

            // Start tips when page loads
            startEnergyTips_<?php echo $lmk_key; ?>();
            </script>
            <?php
        }
    } else {
        echo "<p class='text-muted'>No properties associated with your reports yet. Submit a report to get personalized tips!</p>";
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
    .blog-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .blog-card h4 {
        color: #2c3e50;
        margin-bottom: 15px;
    }
    .blog-card p {
        color: #555;
        line-height: 1.6;
    }
    .blog-card a {
        color: #007bff;
        text-decoration: underline;
        transition: color 0.3s;
    }
    .blog-card a:hover {
        color: #0056b3;
    }
    .blog-card .blockquote {
        border-left: 4px solid #3498db;
        padding-left: 15px;
        margin: 15px 0;
        font-style: italic;
        color: #777;
    }
    .blog-card small {
        display: block;
        margin-top: 10px;
        color: #888;
        font-size: 0.9em;
    }
</style>

<?php include 'footer.php'; ?>