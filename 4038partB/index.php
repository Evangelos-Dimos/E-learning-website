<!-- ΣΥΝΔΕΣΗ -->

<?php 
    session_start(); // Έναρξη της συνεδρίας

    include("functions.php"); // Συμπερίληψη του αρχείου λειτουργιών

    $errorMessage = ""; // Αρχικοποίηση μηνύματος σφάλματος

    if(isset($_SESSION['username'])) // Αν ο χρήστης είναι ήδη συνδεδεμένος, ανακατεύθυνση στην αρχική σελίδα
    {
        header("Location: homepage.php"); 
        exit; 
    }

    // Ελέγχουμε εάν έχει υποβληθεί η φόρμα σύνδεσης
    if (isset($_POST['submitButton']) && $_SERVER['REQUEST_METHOD'] == "POST")
    { 
        // Λαμβάνουμε τα στοιχεία σύνδεσης από τη φόρμα
        $loginame = $_POST['loginame'];
        $password = $_POST['password'];

        // Σύνδεση στη βάση δεδομένων
        connectToDb($conn);

        // Εκτέλεση ερωτήματος για τον έλεγχο του χρήστη
        $query = "select * from users where loginame = '$loginame'";
        $result = mysqli_query($conn, $query); 

        if ($result) 
        {
            if ($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] == $password) 
                {
                    // Αποθήκευση στοιχείων συνεδρίας και ανακατεύθυνση στην αρχική σελίδα
                    $_SESSION['username'] = $loginame;
                    $_SESSION['role'] = $user_data['role'];
                    header("Location: homepage.php");
                    die;
                }
                else
                {
                    $errorMessage = "Λάθος κωδικός πρόσβασης";
                }
            }
            else
            {
                $errorMessage = "Δεν υπάρχει χρήστης με αυτά τα στοιχεία";
            }
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }   
    }
?>

<!DOCTYPE html>

<html>

    <head>

        <meta charset="UTF-8">
        <link rel="stylesheet" href="Style/style.css?v=<?php echo time(); ?>" />
        <title>Πιστοποίηση</title>

    </head>

    <body>

        <div class="header">

            <h1> ΠΙΣΤΟΠΟΙΗΣΗ </h1>

        </div>

        <div class="login">

            <form style="border: 2px solid black;" action="" method="post">

                <p class="login_body">

                    <!-- Textbox για email και password -->
                    <label for="login">Email:</label>
                    <input type="text" id="loginame" name="loginame" placeholder="Εισαγωγή email..."><br><br>

                    <label for="pwd">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Εισαγωγή κωδικού..."> <br><br>

                    <!-- Κουμπί για εισόδο -->
                    <input class="submit_button" type="submit" value="Είσοδος" name="submitButton"> <br> <br>

                </p>    

                <p class="login_message"><?php echo $errorMessage ?></p> <!-- Εμφάνιση μηνύματος σφάλματος -->

            </form>

        </div>

    </body>

</html>
