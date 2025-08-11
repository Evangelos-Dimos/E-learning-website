<!-- ΕΠΕΞΕΡΓΑΣΙΑ ΕΡΓΑΣΙΑΣ -->

<?php

    session_start();
    include("functions.php");
    connectToDb($conn);

    $id = "";
    $goals = "";
    $location = "";
    $required_files = "";
    $date = "";
    $errorMessage = "";

    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {

        // Ελέγχουμε αν έχει οριστεί ο παράμετρος id στο URL
        if (!isset($_GET["id"]))
        {
            header("Location: homework.php");
            exit;
        }

        // Αποθηκεύουμε την τιμή του id από το URL
        $id = $_GET["id"];

        // Επιλέγουμε την εργασία με βάση το id από τη βάση δεδομένων
        $sql = "SELECT * FROM homework WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        // Αν δεν βρεθεί εργασία με το συγκεκριμένο id, ανακατευθύνουμε στην αρχική σελίδα
        if(!$row)
        {
            header("Location: index.php");
            exit;
        }

        // Αποθηκεύουμε τις πληροφορίες της εργασίας από τη βάση στις αντίστοιχες μεταβλητές
        $goals = $row['goals'];
        $location = $row['location'];
        $required_files = $row['required_files'];
        $date = $row['date'];

    }
    else
    {

        // Αν η φόρμα έχει υποβληθεί με μέθοδο POST, αναλαμβάνουμε την ενημέρωση των δεδομένων της εργασίας
        $id = $_POST["id"];
        $goals = $_POST["goals"];
        $required_files = $_POST["required_files"];
        $date = $_POST["date"];
        $location = uploadFile("homeworkToUpload");

        do
        {
            // Έλεγχος για την ύπαρξη κενών πεδίων ή μη έγκυρης μορφής ημερομηνίας
            if(empty($goals) || empty($location) || empty($required_files) || empty($date) || 
            stringIsNullOrWhitespace($goals) || 
            stringIsNullOrWhitespace($location) ||
            stringIsNullOrWhitespace($required_files) ||
            stringIsNullOrWhitespace($date))
            {
                $errorMessage = "All fields are required or wrong date format";
                break;
            }

            // Ενημέρωση των δεδομένων της εργασίας στη βάση δεδομένων
            $sql = "UPDATE homework
            SET goals ='$goals', location ='$location', required_files ='$required_files', date = '$date'
            WHERE id='$id' ";

            $result = $conn->query($sql);

            // Αν η ενημέρωση πραγματοποιηθεί με επιτυχία, ανακατευθύνουμε στη σελίδα εργασιών
            if ($result) 
            {

            echo "record edited successfully";
            header("Location: homework.php");
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
        <title>Επεξεργασία Εργασίας</title>

    </head>

    <body style="background-color: rgb(255, 102, 0);">

        <div class="edit_2">

            <div class="edit_body">

                <!-- Φόρμα επεξεργασίας πληροφοριών εργασίας -->
                <form  action="" method="post" enctype="multipart/form-data">

                    <br>

                    <!-- Κρυφό πεδίο για την αποθήκευση του ID της εργασίας -->
                    <input type="hidden" name="id" value="<?php echo $id;?>">

                    <!-- Πεδίο εισαγωγής στόχων της εργασίας -->
                    <label for="goals"> <?php echo "Στόχοι:"?> </label>
                    <textarea id="goals" name="goals"><?php echo $goals?></textarea> <br><br>

                    <!-- Πεδίο εισαγωγής απαιτούμενων αρχείων -->
                    <label for="required_files"> <?php echo "Απαιτούμενα αρχεία:"?> </label>
                    <textarea id="required_files" name="required_files"><?php echo $required_files ?></textarea><br><br>

                    <!-- Πεδίο εισαγωγής ημερομηνίας παράδοσης -->
                    <label for="date"> <?php echo "Ημερομηνία Παράδοσης:"?> </label>
                    <textarea id="date" name="date"><?php echo $date ?></textarea><br><br>

                    <!-- Πεδίο ανέβασματος αρχείου εκφώνησης -->
                    <label for="fileToUpload">Εκφώνηση:</label>
                    <input style="font-size: 20px;" type="file" name="homeworkToUpload" id="fileToUpload"> <br><br>

                    <!-- Κουμπί υποβολής φόρμας για ενημέρωση -->
                    <input class="button" style="font-size:20px; margin-left: 140px" type="submit" value="Ενημέρωση" name="submitButton">
                    <!-- Κουμπί επιστροφής στην προηγούμενη σελίδα -->
                    <input class="button" style="font-size:20px;" type="button" onclick="window.location.href='./homework.php'" value="Πίσω"> <br> <br>

                </form>
            </div>

            <!-- Εμφάνιση πιθανού μηνύματος σφάλματος -->
            <p class="center"><?php echo $errorMessage ?></p>

        </div>

    </body>

</html>
