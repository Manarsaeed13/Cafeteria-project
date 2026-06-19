<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <h2 class="text-center mb-4" style="color: #0D530E; font-weight: bold; font-size: 28px;">Add User</h2>
            
            <form action="/cafetaria-project/login-submit" method="post" enctype="multipart/form-data" 
                  style="background-color: #E7E1B1; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);" class="p-4">
                
                <div class="mb-3">
                    <label for="Name" class="form-label" style="color: #0D530E; font-weight: 600;">Name:</label>
                    <input type="text" class="form-control" id="Name" name="Name" placeholder="Enter your name" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: #0D530E; font-weight: 600;">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label" style="color: #0D530E; font-weight: 600;">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                
                <div class="mb-3">
                    <label for="confirm_password" class="form-label" style="color: #0D530E; font-weight: 600;">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                </div>
                
                <div class="mb-3">
                    <label for="extension" class="form-label" style="color: #0D530E; font-weight: 600;">Ext:</label>
                    <input type="text" class="form-control" id="extension" name="extension" placeholder="Enter Ext">
                </div>

                <div class="mb-3">
                    <label for="room" class="form-label" style="color: #0D530E; font-weight: 600;">Room No:</label>
                    <select name="Room_ID" id="room" class="form-select">
                        <option value="" selected disabled>Select Room</option>
                        <?php if (isset($rooms) && is_array($rooms) && count($rooms) > 0): ?>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= htmlspecialchars($room['ID']) ?>">
                                    <?= htmlspecialchars($room['Room_number']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No rooms found</option>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="profile_picture" class="form-label" style="color: #0D530E; font-weight: 600;">Profile Picture:</label>
                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background-color: #306D29; color: #FBF5DD; font-weight: bold;">Save</button>
                    <button type="reset" class="btn flex-grow-1" style="background-color: #7b836a; color: white; font-weight: bold;">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="public/js/add_user.js"></script>



