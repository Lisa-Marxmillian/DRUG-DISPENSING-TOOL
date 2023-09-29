<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Administrator Page</title>
  <link rel="stylesheet" type="text/css" href="adminpage.css">
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="../graphics/0.png" alt="Logo">
      </div>
      <div class="admin-info">
        <h2>Welcome back, <?php echo $_SESSION['username']; ?>!</h2>
    </div>
    </div>
    <nav>
      <ul>
        <li><a href="adminpage.php">Home</a></li>
        <li><a href="drugmodify.php">Products</a></li>
        <li><a href="allusers.php">Users</a></li>
        <li><a href="../logout.php">Logout</a></li> 
        
      </ul>
    </nav>
  </header>
  