<?php 
$pageTitle = "Token";
include ('adminheader.php');
?>
<html>
<body>
    <div class="container">
        <h2>Generate API Token</h2>

        <form action="generatetoken.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    Access Type:&nbsp;
    <select name="accessType">
        <option value="Read-only">Read-only</option>
        <option value="Read-Write">Read-Write</option>
        <option value="Resource-specific">Resource-specific</option>
        <option value="Scope-based">Scope-based</option>
    </select>
    <br><br>

    Product Type:&nbsp;
    <select name="productType">
        <option value="Medication">Medication</option>
        <option value="Prescription">Prescription</option>
    </select>

    <button type="submit">Generate Token</button>
</form>

    </div>
</body>
</html>
