<!-- Κεφαλίδα σελίδας -->

<?php
  // Εκκίνηση της συνεδρίας
  session_start();

  // Έλεγχος εάν ο χρήστης δεν έχει συνδεθεί, αν όχι τον ανακατευθύνουμε στη σελίδα σύνδεσης
  if(!isset($_SESSION['username']))
  { 
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Τίτλος της σελίδας και σύνδεσμος με το αρχείο CSS -->
    <title> Αρχική Σελίδα </title>
    <link rel="stylesheet" href="Style/style.css">
  </head>

  <body>
    <!-- Κεφαλίδα σελίδας -->
    <div class="header">
      <h1> Αρχική σελίδα </h1>
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

      <!-- Εμφάνιση κουμπιού για διαχείριση χρηστών μόνο εάν ο ρόλος του χρήστη είναι Tutor -->
      <?php if($_SESSION['role'] == 'Tutor') { ?>
        <a href="users.php">
          <button class="sidebar_button"> Διαχείριση Χρηστών </button>
        </a>
      <?php } ?>
      
      <!-- Κενά και κουμπί αποσύνδεσης -->
      <br><br><br><br><br><br><br><br><br>

      <a href="logout.php"> 
        <button class="sidebar_button"> Logout </button>
      </a>

    </div>

    <!-- Περιεχόμενο της αρχικής σελίδας -->
    <div class="description">

      <!-- Κείμενο καλωσορίσματος και περιγραφής του ιστότοπου -->
      <p class="description_title">
        Καλωσορίσατε στον ιστοχώρο μας!
      </p>

      <p class="description_1st_part">
        Ο ιστοχώρος μας αποτελεί έναν προορισμό για εκμάθηση της HTML και άλλων σχετικών τεχνολογιών. 
        Μέσω αυτού του ιστοχώρου, έχουμε θέσει στόχο να παρέχουμε πλήρεις και εύκολα κατανοητές 
        πληροφορίες για την δημιουργία ιστοσελίδων με χρήση της HTML. Ο ιστοχώρος μας αποτελείται από τις παρακάτω ιστοσελίδες:
      </p>

      <p class="description_2nd_part">
        1. <strong class="bold-text">Ανακοινώσεις</strong>: Σε αυτήν την ιστοσελίδα μπορείτε να βρείτε όλες τις τελευταίες ανακοινώσεις 
        και ενημερώσεις που αφορούν τον ιστοχώρο μας και τις δραστηριότητές μας.<br>
        2. <strong class="bold-text">Επικοινωνία</strong>: Εδώ μπορείτε να βρείτε πληροφορίες επικοινωνίας μαζί μας. Αν έχετε ερωτήσεις, 
        παρατηρήσεις ή προτάσεις, μην διστάσετε να επικοινωνήσετε μαζί μας μέσω της φόρμας επικοινωνίας που παρέχεται.<br>
        3. <strong class="bold-text">Έγγραφα μαθήματος</strong>: Σε αυτήν την ιστοσελίδα θα βρείτε όλα τα απαραίτητα έγγραφα μάθησης, 
        όπως εγχειρίδια, παραδείγματα κώδικα και παρουσιάσεις, που θα σας βοηθήσουν να κατανοήσετε καλύτερα τις έννοιες της HTML.<br>
        4. <strong class="bold-text">Εργασίες</strong>: Σε αυτήν την ιστοσελίδα μπορείτε να βρείτε όλες τις εργασίες που απαιτούνται 
        για την εκμάθηση της HTML. Εδώ θα βρείτε εκφωνήσεις, οδηγίες και πληροφορίες σχετικά με την παράδοση των εργασιών.
        Ελπίζουμε ότι ο ιστοχώρος μας θα σας βοηθήσει να εμβαθύνετε στον κόσμο της HTML και 
        να αποκτήσετε νέες γνώσεις και δεξιότητες στον τομέα του διαδικτύου.
      </p>

      <p class="description_epilogue">
        Καλή Περιήγηση!
      </p>

      <!-- Εικόνα που προσθέτει ενδιαφέρον -->
      <img src="Images/HTML_CHILD.png" class="image">

    </div>

  </body>

</html>
