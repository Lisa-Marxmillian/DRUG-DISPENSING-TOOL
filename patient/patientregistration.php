
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Patient Registration</title>
  <link rel="stylesheet" type="text/css" href="patientregistration.css">
</head>
<body>
  <div class="cont">
    <div class="form">
      
        <form action="patientform.php" method="POST" target="blank">
          <h1>PATIENT DETAILS</h1>
              
              First Name:&nbsp;<input type="text" name="fname"><br><br>
              Second Name:&nbsp;<input type="text" name="lname"><br><br>
              Address:&nbsp;<input type="text" name="address"><br><br>
              <label for="userType">User Type:</label>
              <select name="userType" id="userType">
                  <option value="regular">Regular User</option>
                  <option value="api">API User</option>
              </select>><br><br>
              Access Type:&nbsp;
        <select name="accessType">
          <option value="Read-only">Read-only</option>
          <option value="Read-Write">Read-Write</option>
          <option value="Resource-specific">Read-Write</option>
          <option value="Scope-based">Read-Write</option>
        </select>
        <br><br>
        Product Type:&nbsp;
        <select name="productType">
          <option value="Medication">Medication</option>
          <option value="Prescription">Prescription</option>
              </select>
        <br><br>
              E-mail:&nbsp;<input type="email" name="email"><br><br>
              Mobile: &nbsp <input type = "tel" name = "mobile"> <br><br>
              Birth Date:&nbsp;<input type="date" name="BirthDate"><br><br>
              Username: &nbsp<input type = "text" name = "username">  <br><br>
              Password:&nbsp;<input type="password" name="pwd"><br><br>
              Confirm Password: <input type="password" name="confirm_pwd" required><br><br>
              &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<input type="submit" value="SUBMIT" >&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
              <input type="reset" value="RESET">
            
        </form>
       </body>
    </div>
  </div>
</body>
</html>
