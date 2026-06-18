
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="public/css/user.css">

</head>
<body>

    <div class="d-flex w-100">
        
        <div class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-mug-hot"></i>
                <h2>Cafe</h2>
            </div>

            <ul class="menu">
                <li>
                    <a href="home.php">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>Orders</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="active">
                        <i class="fa-solid fa-user"></i>
                        <span>My Profile</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main-content w-100">

            <div class="header">
                <div>
                    <h1>My Profile</h1>
                    <p>Welcome back, Ahmed</p>
                </div>

                <div class="header-right">
                    <div class="admin-profile">
                        <img src="images/Boy1.jpeg" >
                        <h3>Ahmed Mohamed</h3>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-left">
                    <img src="images/Boy1.jpg" >

                    <div class="profile-info">
                        <div class="name-role">
                            <h2>Ahmed Mohamed</h2>
                            <span>User</span>
                        </div>

                        <p><i class="fa-regular fa-envelope"></i> Ahmed@gmail.com</p>
                        <p><i class="fa-solid fa-phone"></i> +20 123 456 7890</p>
                    </div>
                </div>
            </div>


            <div class="quick-actions">
                <h2>Quick Actions</h2>

                <div class="actions">
                    <a href="home.php" class="card-link" style="text-decoration: none; color: inherit;">
                        <div class="action-card">
                            <i class="fa-solid fa-plus"></i>
                            <h3>Add Product</h3>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
<script src="public/js/user.js"></script>
</body>
</html>