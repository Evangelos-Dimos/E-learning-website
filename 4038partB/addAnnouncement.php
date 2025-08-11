<!-- ΠΡΟΣΘΗΚΗ ΑΝΑΚΟΙΝΩΣΗΣ -->

<?php

  session_start();

  include("functions.php");

  $errorMessage = "";

  // Έλεγχος εάν η φόρμα υποβλήθηκε και η μέθοδος αιτήματος είναι POST
  if (isset($_POST['submitButton']) && $_SERVER['REQUEST_METHOD'] == "POST") 
  { 

    // Αποθήκευση της τρέχουσας ημερομηνίας
    $date = date("Y-m-d");
    // Λήψη των δεδομένων από τη φόρμα
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Σύνδεση στη βάση δεδομένων
    connectToDb($conn);

    do 
    {
        
      // Έλεγχος εάν όλα τα πεδία έχουν συμπληρωθεί και εάν δεν είναι κενά
      if (empty($subject) || empty($message) ||  
          stringIsNullOrWhitespace($subject) || stringIsNullOrWhitespace($message)) 
          {
          
            $errorMessage = "All fields are required!";
            break;
          }

      // Εισαγωγή των δεδομένων στη βάση δεδομένων
      $sql = "INSERT INTO announcements (date, subject, message)
              VALUES ('$date', '$subject', '$message')";

      if ($conn->query($sql)) 
      {

        // Αν η εισαγωγή ολοκληρωθεί επιτυχώς, μετάβαση στη σελίδα announcements.php
        header("Location: announcements.php");
        die;
      }
      else
      {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }

    } 
    while (true);

    // Κλείσιμο της σύνδεσης με τη βάση δεδομένων
    $conn->close();

  }

?>


<!DOCTYPE html>

<html>

  <head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="Style/style.css?v=<?php echo time(); ?>" />
    <title>Προσθήκη Ανακοίνωσης</title>

  </head>

  <body style="background-color: rgb(255, 102, 0);">

    <div class="edit">

      <div class="add_body">

        <!-- Φόρμα για την προσθήκη ανακοίνωσης -->
        <form  action="" method="post">

            <br>
            <input type="hidden" name="id" value="<?php echo $id?>">

            <label for="subject">Θέμα:</label>
            <textarea id="subject" name="subject"></textarea> <br><br>

            <label for="message">Μήνυμα:</label>
            <textarea id="message" name="message"></textarea> <br><br>

            <!-- Κουμπί υποβολής φόρμας -->
            <input class="button" style="font-size:20px; margin-left: 0px;" type="submit" value="Προσθήκη" name="submitButton">

            <!-- Κουμπί επιστροφής στη λίστα με τις ανακοινώσεις -->
            <input class="button" style="font-size:20px;" type="button" onclick="window.location.href='announcements.php'" value="Πίσω"> <br><br>

        </form>

      </div>

      <!-- Εμφάνιση ενδεχόμενου μηνύματος λάθους -->
      <p class="center"><?php echo $errorMessage ?></p>

    </div>

  </body>

</html>
