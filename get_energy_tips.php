<?php
header('Content-Type: application/json');

include_once("db.php");

$lmk_key = $_GET['lmk_key'] ?? '';

if (empty($lmk_key)) {
    echo json_encode(['error' => 'No property selected']);
    exit;
}

$result = $conn->query("SELECT p.current_energy_rating, p.construction_age_band, p.property_type, r.issue_type 
                        FROM properties p 
                        LEFT JOIN reports r ON p.lmk_key = r.property_lmk_key 
                        WHERE p.lmk_key = '$lmk_key' LIMIT 1");
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $tips = [];

    // General Tips (Blog Style with Links)
    $tips[] = "<h4><i class='fas fa-plug text-success'></i> Power Down Like a Pro</h4>
               <p>Unplugging chargers and gadgets when not in use tackles 'vampire energy,' which can account for up to 10% of your energy use. Pair this with a smart meter to track consumption in real-time and make smarter choices. <a href='https://energy-efficient-home.campaign.gov.uk/smart-energy-tips/' target='_blank'>Click here for smart meter energy tips</a>. Also, check out this video for quick energy-saving hacks: <a href='https://www.youtube.com/watch?v=f0pybMoCnhU' target='_blank'>Watch the Energy Saving Workshop</a>.</p>
               <blockquote class='blockquote'><p>'Energy efficiency is the cheapest, cleanest, and fastest way to cut costs.' - Energy Saving Trust</p></blockquote>
               <small class='text-muted'>Legend: A quick win for every student’s budget!</small>";

    $tips[] = "<h4><i class='fas fa-shower text-primary'></i> Shower Smarter, Save More</h4>
               <p>Cutting your shower time by 2 minutes saves gallons of hot water. Install a low-flow showerhead to boost efficiency further. For more ways to reduce energy use, get personalized support from Groundwork’s Green Doctor: <a href='https://www.groundwork.org.uk/greendoctor/get-help/green-doctor-request-for-support/' target='_blank'>Request Green Doctor support</a>.</p>
               <blockquote class='blockquote'><p>'Small changes in daily habits lead to big savings.' - Eco Warrior</p></blockquote>
               <small class='text-muted'>Legend: Every drop counts—literally!</small>";

    $tips[] = "<h4><i class='fas fa-lightbulb text-warning'></i> Light Up Your Life Efficiently</h4>
               <p>Swap old bulbs for LEDs—they last longer, use less energy, and brighten your study space. LEDs can save up to 80% on lighting costs compared to traditional bulbs. Learn more about effective lighting: <a href='https://energysavingtrust.org.uk/advice/lighting/' target='_blank'>Click here for lighting tips</a>.</p>
               <blockquote class='blockquote'><p>'The future is bright with energy-efficient lighting.' - Green Living</p></blockquote>
               <small class='text-muted'>Legend: Shine smart, save smarter!</small>";

    // EPC Rating Based Tips
    if ($row['current_energy_rating'] < 'C') {
        $tips[] = "<h4><i class='fas fa-temperature-high text-danger'></i> Boost Your EPC Game</h4>
                   <p>Your EPC rating is {$row['current_energy_rating']}—time to level up! Adding insulation to walls, lofts, and floors, and sealing drafts can push you to a C or better. You may be eligible for the Great British Insulation Scheme to cover costs: <a href='https://www.gov.uk/apply-great-british-insulation-scheme' target='_blank'>Apply for an insulation grant</a>. Also, check your tenant rights to request landlord improvements: <a href='https://www.gov.uk/private-renting' target='_blank'>Learn about tenant rights</a>.</p>
                   <blockquote class='blockquote'><p>'Insulation is like giving your home a warm hug that saves money.' - Energy Expert</p></blockquote>
                   <small class='text-muted'>Legend: A cozy home is an efficient home!</small>";
    } elseif ($row['current_energy_rating'] >= 'C' && $row['current_energy_rating'] <= 'D') {
        $tips[] = "<h4><i class='fas fa-leaf text-success'></i> Keep Your Green Streak Going</h4>
                   <p>With a {$row['current_energy_rating']} rating, you’re on track! Maintain it by switching to LED lighting and improving ventilation. For more tips, explore Groundwork’s energy support programs: <a href='https://www.groundwork.org.uk/energy-and-finance-support-in-england/' target='_blank'>Get energy and finance support</a>.</p>
                   <blockquote class='blockquote'><p>'Consistency in small actions builds a sustainable future.' - Climate Advocate</p></blockquote>
                   <small class='text-muted'>Legend: Stay green, stay keen!</small>";
    } else {
        $tips[] = "<h4><i class='fas fa-trophy text-warning'></i> Energy Champion Status</h4>
                   <p>A {$row['current_energy_rating']} rating? You’re killing it! Share tips with housemates and host a ‘low-energy living’ night. Learn more about maintaining efficiency: <a href='https://energy-efficient-home.campaign.gov.uk/smart-energy-tips/' target='_blank'>Explore smart energy strategies</a>.</p>
                   <blockquote class='blockquote'><p>'Leading by example inspires change.' - Sustainability Guru</p></blockquote>
                   <small class='text-muted'>Legend: You’re the MVP of energy saving!</small>";
    }

    // Construction Age Based Tips
    if (strpos($row['construction_age_band'], "1900-1929") !== false || strpos($row['construction_age_band'], "1930-1949") !== false) {
        $tips[] = "<h4><i class='fas fa-history text-muted'></i> Old House, New Tricks</h4>
                   <p>Your {$row['construction_age_band']} home has character but needs love. Retrofit walls, roofs, and windows with insulation—think of it as a modern makeover. Draft stoppers are a cheap DIY fix. Check if you qualify for insulation grants: <a href='https://www.gov.uk/apply-great-british-insulation-scheme' target='_blank'>Apply here</a>. Also, review the Renters’ Rights Bill for landlord obligations: <a href='https://www.gov.uk/government/publications/guide-to-the-renters-rights-bill/guide-to-the-renters-rights-bill' target='_blank'>Read the Renters’ Rights Bill</a>.</p>
                   <blockquote class='blockquote'><p>'Old homes can learn new energy-saving habits.' - RetroFit Pro</p></blockquote>
                   <small class='text-muted'>Legend: Vintage vibes, modern savings!</small>";
    } elseif (strpos($row['construction_age_band'], "1950-1966") !== false) {
        $tips[] = "<h4><i class='fas fa-tools text-info'></i> Mid-Century Energy Boost</h4>
                   <p>Built in {$row['construction_age_band']}, your place could use cavity wall and loft insulation. It’s like putting a hat and coat on your house! Explore funding options: <a href='https://www.gov.uk/apply-great-british-insulation-scheme' target='_blank'>Great British Insulation Scheme</a>. For tenant rights on property upgrades, visit: <a href='https://www.gov.uk/private-renting' target='_blank'>Tenant Rights Guidance</a>.</p>
                   <blockquote class='blockquote'><p>'A well-insulated home is a happy home.' - Home Energy Guide</p></blockquote>
                   <small class='text-muted'>Legend: Retrofit for retro cool!</small>";
    } elseif (strpos($row['construction_age_band'], "2003") !== false || strpos($row['construction_age_band'], "2007") !== false) {
        $tips[] = "<h4><i class='fas fa-building text-primary'></i> Modern Efficiency Hacks</h4>
                   <p>Your {$row['construction_age_band']} home is newer—nice! Keep it efficient with smart thermostats and power strips. Learn smart heating strategies: <a href='https://energy-efficient-home.campaign.gov.uk/smart-energy-tips/' target='_blank'>Click here for smart heating tips</a>. Watch this video for more ideas: <a href='https://www.youtube.com/watch?v=f0pybMoCnhU' target='_blank'>Energy Saving Workshop</a>.</p>
                   <blockquote class='blockquote'><p>'New homes need smart habits to stay efficient.' - Tech Eco</p></blockquote>
                   <small class='text-muted'>Legend: Modern living, modern saving!</small>";
    }

    // Issue Based Tips
    $issues = [];
    $issues_result = $conn->query("SELECT DISTINCT issue_type FROM reports WHERE property_lmk_key = '$lmk_key'");
    while ($issue = $issues_result->fetch_assoc()) {
        $issues[] = $issue['issue_type'];
    }

    foreach ($issues as $issue) {
        switch ($issue) {
            case "Broken Windows":
                $tips[] = "<h4><i class='fas fa-window-close text-danger'></i> Fix Those Drafty Windows</h4>
                           <p>Drafty windows letting cold in? Use cling film or bubble wrap as a quick fix. Push your landlord for double-glazing upgrades, and know your rights: <a href='https://www.gov.uk/private-renting' target='_blank'>Tenant Rights Guidance</a>. If it’s an emergency, get help: <a href='https://www.gov.uk/homelessness-help-from-council' target='_blank'>24/7 Housing Support</a>.</p>
                           <blockquote class='blockquote'><p>'A sealed window is a saved penny.' - Frugal Student</p></blockquote>
                           <small class='text-muted'>Legend: Keep the breeze out, keep the cash in!</small>";
                break;
            case "Poor Heating":
                $tips[] = "<h4><i class='fas fa-thermometer-quarter text-warning'></i> Warm Up Wisely</h4>
                           <p>Is your heating a letdown? Layer up, use a hot water bottle, and request a programmable thermostat. Learn smart heating strategies: <a href='https://energy-efficient-home.campaign.gov.uk/smart-energy-tips/' target='_blank'>Smart Heating Tips</a>. If heating issues persist, check tenant rights: <a href='https://www.gov.uk/government/publications/guide-to-the-renters-rights-bill/guide-to-the-renters-rights-bill' target='_blank'>Renters’ Rights Bill</a>.</p>
                           <blockquote class='blockquote'><p>'A warm room starts with smart heating.' - Cozy Living</p></blockquote>
                           <small class='text-muted'>Legend: Stay toasty without toasting your budget!</small>";
                break;
            case "Excessive Energy Bills":
                $tips[] = "<h4><i class='fas fa-dollar-sign text-success'></i> Slash Those Bills</h4>
                           <p>Bills eating your budget? Switch to a time-of-use tariff, turn off lights, and do an energy audit. Get help with energy costs: <a href='https://www.gov.uk/get-help-energy-bills' target='_blank'>Help with Energy Bills</a>. Learn about fuel poverty: <a href='https://assets.publishing.service.gov.uk/media/6024fcabd3bf7f031e1bdc80/CCS207_CCS0221018682-001_CP_391_Sustainable_Warmth_Print.pdf' target='_blank'>Fuel Poverty Guide</a> and <a href='https://assets.publishing.service.gov.uk/media/67e3d47bdcd2d93561195be6/Methodology_Handbook_2025.pdf' target='_blank'>Methodology Handbook</a>.</p>
                           <blockquote class='blockquote'><p>'Control your energy, control your wallet.' - Money Saver</p></blockquote>
                           <small class='text-muted'>Legend: More money for late-night snacks!</small>";
                break;
            case "Mold":
                $tips[] = "<h4><i class='fas fa-biohazard text-danger'></i> Mold Be Gone</h4>
                           <p>Mold creeping in? Open windows daily, use a dehumidifier, and clean with vinegar. Read expert advice: <a href='https://www.gov.uk/government/publications/damp-and-mould-understanding-and-addressing-the-health-risks-for-rented-housing-providers/understanding-and-addressing-the-health-risks-of-damp-and-mould-in-the-home--2' target='_blank'>Damp and Mould Solutions</a>. If unresolved, seek emergency housing support: <a href='https://www.gov.uk/homelessness-help-from-council' target='_blank'>24/7 Housing Support</a>.</p>
                           <blockquote class='blockquote'><p>'Fresh air is the enemy of mold.' - Healthy Home</p></blockquote>
                           <small class='text-muted'>Legend: Breathe easy with a clean space!</small>";
                break;
            case "Dampness":
                $tips[] = "<h4><i class='fas fa-water text-primary'></i> Dry Out Damp Days</h4>
                           <p>Damp walls ruining your vibe? Hang laundry outside, use bowls of salt for moisture, and fix leaks. Get professional guidance: <a href='https://www.gov.uk/government/publications/damp-and-mould-understanding-and-addressing-the-health-risks-for-rented-housing-providers/understanding-and-addressing-the-health-risks-of-damp-and-mould-in-the-home--2' target='_blank'>Damp and Mould Solutions</a>. Know your rights: <a href='https://www.gov.uk/private-renting' target='_blank'>Tenant Rights Guidance</a>.</p>
                           <blockquote class='blockquote'><p>'A dry home is a happy home.' - Damp Busters</p></blockquote>
                           <small class='text-muted'>Legend: Kick damp to the curb!</small>";
                break;
        }
    }

    // Store or update tips in database
    foreach ($tips as $tip) {
        $sql = "INSERT INTO energy_tips (property_lmk_key, tip_text) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE tip_text = VALUES(tip_text)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $lmk_key, $tip);
        $stmt->execute();
    }

    // Fetch all tips for this property
    $final_tips = [];
    $tips_result = $conn->query("SELECT tip_text FROM energy_tips WHERE property_lmk_key = '$lmk_key'");
    while ($tip_row = $tips_result->fetch_assoc()) {
        $final_tips[] = $tip_row['tip_text'];
    }

    echo json_encode($final_tips);
} else {
    echo json_encode(['error' => 'Property not found']);
}

$conn->close();
?>