<!-- ΠΡΟΣΘΗΚΗ ΧΡΗΣΤΗ -->

<?php

    session_start(); // Έναρξη συνεδρίας

    include("functions.php"); // Εισαγωγή αρχείου functions.php που περιέχει χρήσιμες συναρτήσεις
    $errorMessage = ""; // Αρχικοποίηση μεταβλητής για ενδεχόμενο μήνυμα σφάλματος

    // Έλεγχος εάν έχει υποβληθεί η φόρμα και αν η μέθοδος αιτήματος είναι POST
    if (isset($_POST['submitButton']) && $_SERVER['REQUEST_METHOD'] == "POST") 
    { 
        // Λήψη δεδομένων από τη φόρμα
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $loginame = $_POST["loginame"];
        $password = $_POST["password"];
        
        if (isset($_SESSION['role'])) 
        {
            $role = $_SESSION['role'];
        } 
        else 
        {
            $role = 0; // Ορισμός προεπιλεγμένης τιμής για τον ρόλο του χρήστη
        }

        connectToDb($conn); // Σύνδεση στη βάση δεδομένων

        do 
        {
            // Έλεγχος εάν τα πεδία είναι κενά ή δεν έχουν οριστεί
            if (empty($firstName) || empty($lastName) || empty($loginame) || empty($password) || empty($role) ||
                stringIsNullOrWhitespace($firstName) || 
                stringIsNullOrWhitespace($lastName) || 
                stringIsNullOrWhitespace($loginame) ||
                stringIsNullOrWhitespace($password) || 
                !isset($_POST['role']))
                {
                    $errorMessage = "All fields are required!"; // Μήνυμα σφάλματος
                    break;
                }
                // Έλεγχος εάν η διεύθυνση email υπάρχει ήδη στη βάση δεδομένων
                if(emailExists($loginame))
                {
                    $errorMessage = "Email already exists. Please enter a different one!"; // Μήνυμα σφάλματος
                    break;
                }

                // Εκτέλεση εντολής SQL για την εισαγωγή νέου χρήστη στη βάση δεδομένων
                $sql = "INSERT INTO users (firstName, lastName, loginame, password, role)
                    VALUES ('$firstName', '$lastName', '$loginame', '$password', '$role')";

                if ($conn->query($sql)) // Έλεγχος επιτυχίας εκτέλεσης της εντολής SQL
                {
                    echo "New record created successfully"; // Μήνυμα επιτυχίας
                    header("Location: users.php"); // Ανακατεύθυνση στη σελίδα users.php
                    die; // Τερματισμός εκτέλεσης του σεναρίου PHP
                } 
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error; // Μήνυμα σφάλματος SQL
                }
            }
            while(true);
            
            $conn->close(); // Κλείσιμο σύνδεσης με τη βάση δεδομένων
    }
?>

<!DOCTYPE html>

<html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Style/style.css?v=<?php echo time(); ?>" />
        <title>Προσθήκη Χρήστη</title>
    </head>

    <body style="background-color: rgb(255, 102, 0);">

    <div class="edit_2">

        <div class="add_body">

            <!-- Έναρξη φόρμας για προσθήκη νέου χρήστη -->
            <form action="" method="post">
                <br>

                <!-- Κρυφό πεδίο για την αποθήκευση του email του χρήστη -->
                <input type="hidden" name="loginame" value="<?php echo $loginame;?>">

                <!-- Εισαγωγή ονόματος -->
                <label for="firstName"> <?php echo "Όνομα:"?> </label>
                <textarea id="firstName" name="firstName"></textarea> <br><br>

                <!-- Εισαγωγή επωνύμου -->
                <label for="lastName"> <?php echo "Επίθετο:"?> </label>
                <textarea id="lastName" name="lastName"></textarea> <br><br>
            
                <!-- Εισαγωγή email -->
                <label for="loginame"> <?php echo "Email:"?> </label>
                <textarea id="loginame" name="loginame"></textarea> <br><br>

                <!-- Εισαγωγή κωδικού πρόσβασης -->
                <label for="password"> <?php echo "Κωδικός:"?> </label>
                <textarea id="password" name="password"></textarea> <br><br>

                <!-- Επιλογή ρόλου του χρήστη (Φοιτητής ή Καθηγητής) -->
                <label for="student">Student</label>
                <input type="radio" id="student" name="role" value="Student"> <br><br>

                <label for="tutor">Tutor</label>
                <input type="radio" id="tutor" name="role" value="Tutor"> <br><br>

                <!-- Κουμπί υποβολής φόρμας -->
                <input class="button" style="font-size:20px;" type="submit" value="Προσθήκη" name="submitButton">
                <!-- Κουμπί επιστροφής στη λίστα των χρηστών -->
                <input class="button" style="font-size:20px;" type="button" onclick="window.location.href='./users.php'" value="Πίσω"> <br>

            </form>

            <!-- Μήνυμα λάθους σε περίπτωση που δεν συμπληρωθούν όλα τα πεδία -->
            <p class="center"><?php echo $errorMessage ?></p>

            </div>

        </div>

    </body>
</html>
