<!-- ΑΝΑΚΟΙΝΩΣΕΙΣ -->

<?php

  session_start(); // Έναρξη της συνεδρίας για τον έλεγχο σύνδεσης του χρήστη

    include("functions.php"); // Συμπερίληψη του αρχείου functions.php που περιέχει χρήσιμες συναρτήσεις

    // Έλεγχος εάν ο χρήστης δεν έχει συνδεθεί, στην περίπτωση αυτή γίνεται ανακατεύθυνση προς την σελίδα σύνδεσης
    if(!isset($_SESSION['username']))
    { 
      header("Location: index.php");
    }

    $_SESSION['table'] = 'announcements'; // Ορισμός του πίνακα στον οποίο θα γίνουν οι ενέργειες (στην περίπτωσή μας, ο πίνακας 'announcements')
    
    connectToDb($conn); // Σύνδεση στη βάση δεδομένων

?>

<!DOCTYPE html>

<html>

    <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" href="Style/style.css"> <!-- Σύνδεση του αρχείου CSS -->

      <title> Ανακοινώσεις </title> <!-- Τίτλος της σελίδας -->

      <style>
        hr 
        {
            border: none; /* Αρχικά αφαιρούμε τον προεπιλεγμένο διαχωριστικό χρησιμοποιώντας border: none; */
            border-top: 3px solid black; /* Ορίζουμε την επιθυμητή γραμμή χρησιμοποιώντας border-top */
            margin-left: 50px; /* Ορίζουμε το περιθώριο αριστερά */
            width: calc(100% - 50px); /* Ορίζουμε το πλάτος της γραμμής για να πιάνει όλο το πλάτος της περιοχής */
        } 
      </style>

    </head>

    <body>

      <div class="header">
      
        <h1> Ανακοινώσεις </h1> <!-- Κεφαλίδα της σελίδας -->
  
      </div>
  
      <div class="sidebar">
  
        <!-- Αυτό είναι sidebar menu με τις επιλογές του -->
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

        <?php if($_SESSION['role'] == 'Tutor') { ?>

          <!-- Προσθήκη επιπλέον επιλογών διαχείρισης χρηστών -->
          <a href="users.php">
            <button class="sidebar_button"> Διαχείριση Χρηστών </button>
          </a>

        <?php } ?>

        <br><br><br><br><br><br><br><br><br>

        <!-- Κουμπί για αποσύνδεση -->   
        <a href="logout.php"> 
          <button class="sidebar_button"> Logout </button>
        </a>

      </div>

      <div class="announcements">
        
        <!-- Έλεγχος για τον ρόλο του χρήστη (εάν είναι διδάσκοντας) -->
        <?php if ($_SESSION['role'] == "Tutor") { ?>

        <div class="announcement_title">
            <a style="font-size: larger;" href="./addAnnouncement.php">Προσθήκη νέας Ανακοίνωσης</a> <br> <br> <!-- Προσθήκη συνδέσμου για προσθήκη νέας ανακοίνωσης -->
        </div>

        <!-- Γραμμή -->
        <hr><br>

        <?php }

          // Εκτέλεση ερωτήματος SQL για να επιστραφούν οι ανακοινώσεις από τη βάση δεδομένων
          $sql = "select * from announcements";

          $result = $conn->query($sql);
        
          // Έλεγχος εάν υπάρχουν αποτελέσματα
          if($result->num_rows > 0)
          {

            while($row = $result->fetch_assoc())
            {

        ?>

        <!-- Εμφάνιση των ανακοινώσεων -->
        <h2 class="announcement_title">Ανακοίνωση <?php echo $row['id'] ?>
        
          <!-- Σύνδεσμοι για διαγραφή και επεξεργασία ανακοίνωσης, μόνο για διδάσκοντες -->
          <?php if ($_SESSION['role'] == "Tutor"): ?><span style="font-size: smaller; margin-left: 10px;">
            <a href='./delete.php?id=<?php echo $row['id']; ?>' style="font-size: smaller;">[Διαγραφή]</a> 
            <a href='./editAnnouncement.php?id=<?php echo $row['id']; ?>' style="font-size: smaller;">[Επεξεργασία]</a></span>
          <?php endif; ?>

        </h2>

        <div class="announcement_body">

          <!-- Εμφάνιση ημερομηνίας, θέματος και μηνύματος της ανακοίνωσης -->
          <p class="annoncement_body"><b>Ημερομηνία</b>: <?php echo $row['date'] ?> </p> 
          <p class="annoncement_body"><b>Θέμα</b>: <?php echo $row['subject'] ?> </p> 
          <p class="annoncement_body"><?php echo $row['message'] ?> </p>

        </div>

        <?php }
          } 
          else
          {
        ?> 
      
        <!-- Μήνυμα σε περίπτωση που δεν υπάρχουν ανακοινώσεις -->
        <h2 class="announcement_title">ΔΕΝ ΥΠΑΡΧΟΥΝ ΑΝΑΚΟΙΝΩΣΕΙΣ </h2> 

        <?php 
          }
        ?>

      </div>

      <!-- Σύνδεσμος για επιστροφή στην κορυφή της σελίδας -->
      <a style="float: right; color: rgb(255, 102, 0);" href="#top"><p class="top">&lt;Top&gt;</p></a>

    </body>

    </html>

          