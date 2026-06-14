<div class="d-flex justify-content-center align-items-center py-5">
    <form method="post" action="login_controller.php" id="loginForm" class="p-5 rounded-4 shadow-lg w-100" style="max-width: 450px; background-color: #E7E1B1;" novalidate>
        <h1 class="text-center fw-bold mb-5 text-success">Cafeteria Login</h1>

       <!-- email -->
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-success">Email Address</label>
            <input type="email" name="email" id="email" class="form-control form-control-lg border-2 border-success" placeholder="name@gmail.com" required>
            <div class="invalid-feedback">Please enter a valid email.</div>
        </div>

       <!-- pass -->
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold text-success">Password</label>
            <input type="password" name="password" id="password" class="form-control form-control-lg border-2 border-success" placeholder="Enter password" required minlength="6">
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
        </div>

  <!-- login -->
        <button type="submit" class="btn btn-success w-100 btn-lg text-white fw-bold mt-2 shadow-sm">Login</button>

        <div class="text-center mt-4">
            <a href="#" class="text-decoration-none fw-bold text-success">Forget Password?</a>
        </div>
    </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault(); 
        event.stopPropagation();
        this.classList.add('was-validated');
    }
});
</script>
