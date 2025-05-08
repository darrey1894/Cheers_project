<?php
include_once("db.php");
$page_title = "Register";
include 'public_header.php';
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 100%; max-width: 500px; border-radius: 15px; overflow: hidden; animation: slideIn 0.8s ease-out;">
        <div class="card-body p-5">
            <h2 class="text-center mb-4" style="color: #2c3e50;"><i class="fas fa-user-plus"></i> Register</h2>
         
            <form action="register_process.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                    </div>
                    <div class="invalid-feedback">Please provide a valid username.</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="invalid-feedback">Please provide a valid email.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required>
                    </div>
                    <div class="invalid-feedback">Please provide a password.</div>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required>
                    </div>
                    <div class="invalid-feedback">Passwords must match.</div>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-check"></i> Register</button>
                <p class="text-center mt-3">Already have an account? <a href="./" class="text-primary">Login here</a></p>
                <?php
                if (isset($_GET['error'])) {
                    echo "<p class='text-danger text-center mt-2'>" . htmlspecialchars($_GET['error']) . "</p>";
                }
                if (isset($_GET['success'])) {
                    echo "<p class='text-success text-center mt-2'>" . htmlspecialchars($_GET['success']) . "</p>";
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php include 'public_footer.php'; ?>