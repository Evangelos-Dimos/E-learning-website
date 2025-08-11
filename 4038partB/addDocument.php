<!-- ΠΡΟΣΘΗΚΗ ΕΓΓΡΑΦΟΥ -->

<?php

    session_start();
    include("functions.php");

    $errorMessage = "";

    // Έλεγχος εάν η φόρμα υποβλήθηκε και η μέθοδος αιτήματος είναι POST
    if (isset($_POST['submitButton']) && $_SERVER['REQUEST_METHOD'] == "POST") 
    {

        // Λήψη των δεδομένων από τη φόρμα
        $title = $_POST["title"];
        $description = $_POST["description"];
        $location = uploadFile("documentToUpload");

        // Σύνδεση στη βάση δεδομένων
        connectToDb($conn);

        do 
        {
            // Έλεγχος εάν όλα τα πεδία έχουν συμπληρωθεί
            if (empty($title) || empty($description) || empty($location) ||
            stringIsNullOrWhitespace($title) || 
            stringIsNullOrWhitespace($description)) 
            {
                $errorMessage = "All fields are required!";
                break;
            }

            // Εισαγωγή των δεδομένων στη βάση δεδομένων
            $sql = "INSERT INTO documents (title, description, location)
                VALUES ('$title', '$description', '$location')";

            if ($conn->query($sql)) 
            {

            // Αν η εισαγωγή ολοκληρωθεί επιτυχώς, μετάβαση στη σελίδα documents.php
            header("Location: documents.php");
            die;

            } 
            else 
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        
        } while (true);

        // Κλείσιμο της σύνδεσης με τη βάση δεδομένων
        $conn->close();
    }
?>

<!DOCTYPE html>

<html>

    <head>

        <meta charset="UTF-8">
        <link rel="stylesheet" href="Style/style.css?v=<?php echo time(); ?>" />
        <title>Προσθήκη Εγγράφου</title>

    </head>

    <body style="background-color: rgb(255, 102, 0);">

        <div class="edit">

            <div class="edit_body">

                <br>
                <!-- Φόρμα για την προσθήκη εγγράφου -->
                <form  action="" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?php echo $id?>">

                    <label for="title" style="font-size: larger;">Τίτλος:</label>
                    <textarea id="title" name="title"></textarea><br><br>

                    <label for="description" style="font-size: larger;">Περιγραφή:</label>
                    <textarea id="description" name="description"></textarea><br><br>

                    <label for="fileToUpload" style="font-size: larger;">Αρχείο:</label>
                    <input style="font-size:20px;" type="file" name="documentToUpload" id="fileToUpload"><br><br>

                    <!-- Κουμπί υποβολής φόρμας -->
                    <input class="button" style="font-size:20px; margin-left: 100px;" type="submit" value="Προσθήκη" name="submitButton">
                    <!-- Κουμπί επιστροφής στη λίστα με τα έγγραφα -->
                    <input class="button" style="font-size:20px;" type="button" onclick="window.location.href='./documents.php'" value="Πίσω"> <br> <br>
                
                </form>
            </div>

            <!-- Εμφάνιση ενδεχόμενου μηνύματος λάθους -->
            <p class="center"><?php echo $errorMessage ?></p>

        </div>

    </body>

</html>
