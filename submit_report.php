<?php
$page_title = "Submit Report";
include 'header.php';
?>

<h3 class="mb-4"><b>Submit a Report</b></h3>
<div class="form-container">
    <form action="submit_report_process.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="property" class="form-label">Select Property</label>
            <select name="property_lmk_key" id="property" class="form-select" required>
                <option value="">Choose a Property</option>
                <?php
                include_once("db.php");
                $result = $conn->query("SELECT lmk_key, address, postcode FROM properties");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['lmk_key']}'>{$row['postcode']}</option>";
                }
                $conn->close();
                ?>
            </select>
            <div class="invalid-feedback">Please select a property.</div>
        </div>
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
            <input type="text" name="other_issue" id="other_issue" class="form-control" placeholder="Specify the issue" />
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Describe the issue" required></textarea>
            <div class="invalid-feedback">Please provide a description.</div>
        </div>
        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Video</label>
            <input type="file" name="video" id="video" class="form-control" accept="video/*">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit</button>
    </form>
</div>
<script>
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