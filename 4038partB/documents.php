<!-- ΕΓΓΡΑΓΑ ΜΑΘΗΜΑΤΟΣ -->

<?php

  // Συμπερίληψη του αρχείου functions.php που περιέχει βοηθητικές συναρτήσεις
  include("functions.php");

  // Έναρξη συνεδρίας
  session_start();

  // Έλεγχος εάν ο χρήστης δεν έχει συνδεθεί, σε αυτή την περίπτωση τον ανακατευθύνει στη σελίδα σύνδεσης
  if(!isset($_SESSION['username']))
  { 
    header("Location: index.php");
  }

  // Ορισμός του session table σε 'documents' 
  $_SESSION['table'] = 'documents';

  // Σύνδεση στη βάση δεδομένων
  connectToDb($conn);

?>

<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Έγγραφα Μαθήματος </title>
    <link rel="stylesheet" href="Style/style.css">

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
      
      <h1> Έγγραφα Μαθήματος </h1>

    </div>

    <!-- Αυτό είναι sidebar menu με τις επιλογές του -->
    <div class="sidebar">

      <!-- Κουμπί για αρχική σελίδα -->
      <a href="homepage.php">
        <button class="sidebar_button"> Αρχική Σελίδα </button>
      </a>

      <!-- Κουμπί για ανακοινώσεις -->
      <a href="announcements.php"> 
        <button class="sidebar_button"> Ανακοινώσεις </button>    
      </a>

      <!-- Κουμπί για επικοινωνία -->
      <a href="communication.php">
        <button class="sidebar_button"> Επικοινωνία </button>   
      </a>

      <!-- Κουμπί για έγγραφα μαθήματος -->
      <a href="documents.php">
        <button class="sidebar_button"> Έγγραφα μαθήματος </button>
      </a>

      <!-- Κουμπί για εργασίες -->
      <a href="homework.php"> 
        <button class="sidebar_button"> Εργασίες </button>
      </a>
    
      <!-- Εμφάνιση μόνο για τους καθηγητές -->
      <?php if($_SESSION['role'] == 'Tutor') { ?>

          <a href="users.php">
            <button class="sidebar_button"> Διαχείριση Χρηστών </button>
          </a>

      <?php } ?>

      <br><br><br><br><br><br><br><br><br>

      <!-- Κουμπί αποσύνδεσης -->
      <a href="logout.php"> 
        <button class="sidebar_button"> Logout </button>
      </a>

    </div>

    <!-- Περιοχή εμφάνισης εγγράφων -->
    <div class="documents">

      <?php

        // Εμφάνιση κουμπιού προσθήκης νέου εγγράφου μόνο για τους εκπαιδευτικούς
        if ($_SESSION['role'] == "Tutor")
        {
      
      ?>
        
      <div class="document_title">
            <a style="font-size: larger;" href="./addDocument.php">Προσθήκη νέου εγγράφου</a> <br> <br>
      </div>

      <!-- Γραμμή -->
      <hr><br>
        
        <?php }
                
          // Εκτέλεση SQL ερωτήματος για ανάγνωση εγγράφων
          $sql = "select * from documents";
      
          $result = $conn->query($sql);
                    
          if($result->num_rows > 0)
          {
            while($row = $result->fetch_assoc())
          {

        ?>
         
      <!-- Τίτλος εγγράφου -->
      <h2 class="document_title"><?php echo $row['title'] ?>

        <!-- Εμφάνιση κουμπιών επεξεργασίας και διαγραφής μόνο για τους εκπαιδευτικούς -->
        <?php if ($_SESSION['role'] == "Tutor"): ?><span style="font-size: smaller; margin-left: 10px;">

          <a href='./delete.php?id=<?php echo $row['id']; ?>' style="font-size: smaller;">[Διαγραφή]</a> 
          <a href='./editDocument.php?id=<?php echo $row['id']; ?>' style="font-size: smaller;">[Επεξεργασία]</a></span>

        <?php endif; ?>

      </h2>

    
      <div class="document_body">

        <!-- Περιγραφή εγγράφου -->
        <p><b><i>Περιγραφή</i></b>: <?php echo $row['description']?></p>

        <!-- Σύνδεσμος για λήψη του εγγράφου -->
        <p><a href="./<?php echo $row['location']; ?>">Download</a></p>
            
      </div>
          
      <?php }
        } 
        else
        {

      ?> 
      
      <h2 class="document_title"> ΔΕΝ ΥΠΑΡΧΟΥΝ ΑΝΑΚΟΙΝΩΣΕΙΣ </h2> 
        
      <?php 
        }
      ?>

    </div>

    <!-- Κουμπί επιστροφής στην κορυφή -->
    <a style="float: right; color: rgb(255, 102, 0)" href="#top"><p class="top">&lt;Top&gt;</p></a>

  </body>

</html>
