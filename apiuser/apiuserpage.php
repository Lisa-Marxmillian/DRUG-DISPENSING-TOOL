<?php
session_start();
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard </title>

    <link rel="stylesheet" type="text/css" href="../patient/patientpage.css">
</head>

<body>
    <?php include "../patient/patientheader.php"; ?>
    <main>
        <section class="profile-section">
            <h2>Profile Information</h2>
            <?php

            require_once("../dbconnect.php");

            $username = $_SESSION['username'];

            $sql = "SELECT * FROM apiuser WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p><strong>Full Name:</strong> " . $row['username'] . "</p>";
                    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                    echo "<p><strong>Phone:</strong> " . $row['phoneno'] . "</p>";

                    // Check if the patient is also an API user
                    $apiUser = isApiUser($conn, $username);

                    if ($apiUser) {
                        echo "<button onclick='subscribeToApiProduct()'>Subscribe to API Product</button>";
                    }
                } else {
                    echo "<p>Subscription Registered successfully.</p>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }

            mysqli_close($conn);

            function isApiUser($conn, $username)
            {
                $sql = "SELECT * FROM apiuser WHERE username = ?";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        return true;
                    }
                }

                return false;
            }
            ?>
        </section>
    </main>

        <label for="productType">Product Type:</label>
        <select id="productType" name="productType">
            <option value="Medication">Medication</option>
            <option value="Prescription">Prescription</option>
        </select><br>

        <button type="button" onclick="subscribeToApiProduct()">Subscribe</button>
    </form>

    <script>
        function subscribeToApiProduct() {
            // Get the username from the session or wherever you store it
            var username = "<?php echo $_SESSION['username']; ?>";

            // Prepare the data to be sent
            var data = new URLSearchParams();
            data.append('username', username);
            data.append('productType', document.getElementById('productType').value);

            // Make the fetch request
            fetch('subscribe_api_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: data,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Subscription failed. Please try again.');
                    }
                    return response.text();
                })
                .then(result => {
                    // Handle the success response
                    alert(result);
                })
                .catch(error => {
                    // Handle the error
                    alert(error.message);
                });
        }
    </script>

    <?php include("../patientfooter.php"); ?>
</body>

</html>
