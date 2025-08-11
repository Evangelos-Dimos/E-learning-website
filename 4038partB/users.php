<!-- ΧΡΗΣΤΕΣ -->

<?php

    session_start();

        // Συμπερίληψη του αρχείου functions.php που περιέχει συναρτήσεις χρήσιμες για το πρόγραμμα
        include("functions.php");

        // Έλεγχος αν ο χρήστης δεν έχει συνδεθεί. Αν δεν έχει, τον ανακατευθύνει στη σελίδα σύνδεσης.
        if(!isset($_SESSION['username']))
        { 
            header("Location: index.php");
        }

        $_SESSION['table'] = 'users';
        connectToDb($conn);

?>

<!DOCTYPE html>

    <html>

        <head>

            <meta charset="UTF-8">
            <link rel="stylesheet" href="Style/style.css?v=<?php echo time(); ?>">
            <title> Διαχείριση Χρηστών </title>
            <style>
                .fl-table td {padding: 10px;} 
            </style>
    
        </head>

        <body>

            <div class="header">
      
                <h1> Διαχείριση Χρηστών </h1>
  
            </div>
  
            <!-- Αυτό είναι sidebar menu με τις επιλογές του -->
            <div class="sidebar">
  
                <a href="homepage.php">
                    <button class="sidebar_button"> Αρχική Σελίδα </button>
                </a>
  
                <a href="announcements.php"> 
                    <button class="sidebar_button"> Ανακοινώσεις </button>    
                </a>
  
                <a href="communication.php">
                    <button class="sidebar_button"> Επικοινωνία </button>   
                </a>
  
                <a href="documents.php">
                    <button class="sidebar_button"> Έγγραφα μαθήματος </button>
                </a>
  
                <a href="homework.php"> 
                <button class="sidebar_button"> Εργασίες </button>
                </a>

                <!-- Το κουμπί Διαχείριση Χρηστών είναι διαθέσιμο μόνο για καθηγητές -->
                <?php if($_SESSION['role'] == 'Tutor') { ?>

                    <a href="users.php">
                        <button class="sidebar_button"> Διαχείριση Χρηστών </button>
                    </a>

                <?php } ?>      
                
                <br><br><br><br><br><br><br><br><br>

                <a href="logout.php">   
                    <button class="sidebar_button"> Logout </button>
                </a>

            </div>
        
            <div class="user">

                <div class="user_body">

                    <thead>
                    <?php

                        // Ερώτημα SQL για την επιλογή όλων των χρηστών από τον πίνακα users
                        $query = "SELECT * FROM users"; 

                        // Έναρξη γραμμής πίνακα
                        echo '<table class="fl-table"> 
                        <tr> 
                            <td> <font face="Arial">First Name</font> </td> 
                            <td> <font face="Arial">Last Name</font> </td> 
                            <td> <font face="Arial">Email</font> </td> 
                            <td> <font face="Arial">Password</font> </td> 
                            <td> <font face="Arial">Role</font> </td> 
                        </tr>';
                        // Τέλος γραμμής πίνακα
                    ?>
                    </thead>

                    <?php   

                        // Εκτέλεση του ερωτήματος προς τη βάση δεδομένων και εμφάνιση των αποτελεσμάτων
                        if ($result = $conn->query($query)) 
                        {
                            while ($row = $result->fetch_assoc()) 
                            {
                                // Ανάθεση τιμών σε μεταβλητές από τα αποτελέσματα του ερωτήματος
                                $firstName = $row["firstName"];
                                $lastName = $row["lastName"];
                                $loginame = $row["loginame"];
                                $password = $row["password"];
                                $role = $row["role"];

                                $password = hidePwd($password); 

                                // Εμφάνιση των δεδομένων σε μια γραμμή πίνακα
                                echo "<tr> 
                                    <td>$firstName</td> 
                                    <td>$lastName</td> 
                                    <td>$loginame</td> 
                                    <td>$password</td> 
                                    <td>$role</td>
                                    <td> <a href='./editUser.php?loginame=$row[loginame]'>[Επεξεργασία] </a>
                                    <td> <a href='./delete.php?loginame=$row[loginame]'>[Διαγραφή] </a>
                                </tr>";
                            }
                            $result->free(); // Απελευθέρωση του αποτελέσματος
                        }
                ?>
            
            </div>

            <div style="text-align:center;float:left;">
                <!-- Σύνδεσμος για προσθήκη νέου χρήστη -->
                <a style="font-size: larger;" href='./addUser.php' > Προσθήκη Χρήστη
            </div> 

        </div>
    </body>

</html>