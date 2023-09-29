<html>
<head>
  <meta charset="UTF-8">
  <title>Products</title>
 
  <link rel="stylesheet" type="text/css" href="product.css"> 
</head>
<body>
  <header>
    <div class="top-bar">
      <div class="logo">
        <img src="../graphics/0.png" alt="Logo" >
      </div>
      <div class="patientinfo">
      Welcome, <?php echo $_SESSION['username']; ?>!
      </div>
    </div>
    <nav>
      <ul>
      <li><a href="patientpage.php">Dashboard</a></li> 
        <li><a href="prescriptionpatientview.php">My Prescriptions</a></li> 
        <li><a href="product.php">Medication</a></li> 
        <li><a href="contact.html">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li> 
        <li>
          <form class="search-form" action="product.php" method="post"> 
            <input type="text" name="search_query" placeholder="Search..."> 
            <button type="submit">Search</button>
          </form>
        </li>
      </ul>
    </nav>
  </header>