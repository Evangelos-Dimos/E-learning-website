<!-- ΕΠΕΞΕΡΓΑΣΙΑ ΕΓΓΡΑΦΟΥ ΜΑΘΗΜΑΤΟΣ -->

<?php

    session_start();
    include("functions.php");
    connectToDb($conn);

    $id = "";
    $title = "";
    $description = "";
    $location = "";

    $errorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        // Ελέγχουμε αν έχει οριστεί ο παράμετρος id στο URL
        if (!isset($_GET["id"]))
        {
            header("Location: documents.php");
            exit;
        }   

        // Αποθηκεύουμε την τιμή του id από το URL
        $id = $_GET["id"];

        // Επιλέγουμε το έγγραφο με βάση το id από τη βάση δεδομένων
        $sql = "SELECT * FROM documents WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        // Αν δεν βρεθεί έγγραφο με το συγκεκριμένο id, ανακατευθύνουμε στην αρχική σελίδα
        if(!$row)
        {
            header("Location: index.php");
            exit;
        }

        // Αποθηκεύουμε τις πληροφορίες του εγγράφου από τη βάση στις αντίστοιχες μεταβλητές
        $title = $row['title'];
        $description = $row['description'];
        $location = $row['location'];

    }
    else 
    {
        // Αν η φόρμα έχει υποβληθεί με μέθοδο POST, αναλαμβάνουμε την ενημέρωση των δεδομένων του εγγράφου
        $id = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $location = uploadFile("documentToUpload");

        do
        {
            // Έλεγχος για την ύπαρξη κενών πεδίων
            if(empty($title) || empty($description) || empty($location) ||
            stringIsNullOrWhitespace($title) || 
            stringIsNullOrWhitespace($description) || 
            stringIsNullOrWhitespace($location))
            {
                $errorMessage = "All fields are required!";
                break;
            }

            // Ενημέρωση των δεδομένων του εγγράφου στη βάση δεδομένων
            $sql = "UPDATE documents 
            SET title ='$title', description ='$description', location ='$location'
            WHERE id='$id' ";

            $result = $conn->query($sql);

            // Αν η ενημέρωση πραγματοποιηθεί με επιτυχία, ανακατευθύνουμε στη σελίδα εγγράφων
            if ($result) 
            {
                echo "record edited successfully";
                header("Location: documents.php");
                die;
            } 
            else 
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
                break;
            }

        }
        while(true);
    
    }

    $conn->close();

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <link rel="stylesheet" href="Style/style.css?v=<?php echo time(); ?>" />
        <title>Επεξεργασία Εγγράφου</title>

    </head>

    <body style="background-color: rgb(255, 102, 0);">

        <div class="edit">

            <div class="edit_body">

            <!-- Φόρμα επεξεργασίας εγγράφου -->
            <form  action="" method="post" enctype="multipart/form-data">
                
                <br>
                <input type="hidden" name="id" value="<?php echo $id;?>">

                <!-- Πεδίο τίτλου -->
                <label for="title"> <?php echo "Τίτλος"?> </label>
                <textarea id="title" name="title"><?php echo $title?></textarea><br><br>

                <!-- Πεδίο περιγραφής -->
                <label for="description"> <?php echo "Περιγραφή"?> </label>
                <textarea id="description" name="description"><?php echo $description ?></textarea><br><br>

                <!-- Πεδίο ανέβασματος αρχείου -->
                <label for="fileToUpload" style="font-size: larger;">Αρχείο:</label>
                <input style="font-size: 20px; vertical-align: middle;" type="file" name="documentToUpload" id="fileToUpload"><br><br>

                <!-- Κουμπί υποβολής φόρμας -->
                <input class="button" style="font-size:20px; margin-left: 100px;" type="submit" value="Ενημέρωση" name="submitButton">
                <!-- Κουμπί επιστροφής πίσω -->
                <input class="button" style="font-size:20px;" type="button" onclick="window.location.href='./documents.php'" value="Πίσω"> <br><br>

            </form>

        </div>

        <!-- Εμφάνιση μηνύματος σφάλματος -->
        <p class="center"><?php echo $errorMessage ?></p>

        </div>
        
    </body>

</html>
