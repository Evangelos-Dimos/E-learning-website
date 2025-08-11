<!-- ΕΡΓΑΣΙΕΣ -->

<?php 

  // Έλεγχος σύνδεσης χρήστη και επιστροφή στην αρχική σελίδα σύνδεσης εάν δεν είναι συνδεδεμένος
  session_start();
  include("functions.php");
  if(!isset($_SESSION['username'])) { 
    header("Location: login.php");
  }

  // Ορισμός του πίνακα για ανάκτηση δεδομένων εργασιών
  $_SESSION['table'] = 'homework';
  connectToDb($conn);
?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Style/style.css">
  <title>Εργασίες</title>
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

  <!-- Επικεφαλίδα σελίδας -->
  <div class="header">
    <h1>Εργασίες</h1>
  </div>

  <!-- Αυτό είναι sidebar menu με τις επιλογές του -->
  <div class="sidebar">

    <a href="homepage.php"><button class="sidebar_button">Αρχική Σελίδα</button></a>
    <a href="announcements.php"><button class="sidebar_button">Ανακοινώσεις</button></a>
    <a href="communication.php"><button class="sidebar_button">Επικοινωνία</button></a>
    <a href="documents.php"><button class="sidebar_button">Έγγραφα μαθήματος</button></a>
    <a href="homework.php"><button class="sidebar_button">Εργασίες</button></a>

    <!-- Εμφάνιση κουμπιού διαχείρισης χρηστών μόνο για καθηγητές -->
    <?php if($_SESSION['role'] == 'Tutor') { ?>
      <a href="users.php"><button class="sidebar_button">Διαχείριση Χρηστών</button></a>
    <?php } ?>
    
    <br><br><br><br><br><br><br><br><br>

    <!-- Κουμπί αποσύνδεσης -->
    <a href="logout.php"><button class="sidebar_button">Logout</button></a>
  </div>

  <!-- Κύριο περιεχόμενο σελίδας -->
  <div class="homework">

    <!-- Εμφάνιση κουμπιού προσθήκης εργασίας μόνο για διαχειριστές -->
    <?php if ($_SESSION['role'] == "Tutor") { ?>
      <div class="homework_title">
        <a style="font-size: larger;" href="./addHomework.php">Προσθήκη νέας εργασίας</a> <br> <br>
      </div>

      <!-- Γραμμή -->
      <hr><br>
      
    <?php } ?>

  

    <!-- Εμφάνιση εργασιών -->
    <?php
      $sql = "SELECT * FROM homework";
      $result = $conn->query($sql);
      
      if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
          <!-- Κάθε εργασία -->
          <h2 class="homework_title">Εργασία <?php echo $row['id'] ?>
            <!-- Εμφάνιση κουμπιών διαγραφής και επεξεργασίας μόνο για διαχειριστές -->
            <?php if ($_SESSION['role'] == "Tutor"): ?><span style="font-size: smaller; margin-left: 10px;">

              <a href='./delete.php?id=<?php echo $row['id']; ?>' style="font-size: smaller;">[Διαγραφή]</a> 
              <a href='./editHomework.php?id=<?php echo $row['id']; ?>' style="font-size: smaller;">[Επεξεργασία]</a></span>

            <?php endif; ?>
          </h2>

          <!-- Περιεχόμενο εργασίας -->
          <div class="homework_body">

            <p><b>Στόχοι:</b> Οι στόχοι της εργασίας είναι:<br><p class="homework_body"><?php echo $row['goals'] ?> </p></p>
            <p><b>Εκφώνηση </b>:<p style="font-style: normal; margin-left: 50px;"> Κατεβάστε την εκφώνηση από -> <a href="./<?php echo $row["location"]?>">εδώ</a></p></p>
            <p><b>Παραδοτέα: </b><p style="font-style: normal; margin-left: 50px;"><?php echo $row['required_files'] ?> </p></p>
            <p style="border-bottom: solid black"><b style="color: red;">Ημερομηνία Παράδοσης: </b><span style="font-style: normal;"><?php echo $row['date']; ?></span></p>   

          </div>
    <?php
        }
      } 
      else 
      {
    ?> 
        <!-- Μήνυμα εάν δεν υπάρχουν εργασίες -->
        <h2 class="homework_title">ΔΕΝ ΥΠΑΡΧΟΥΝ ΑΝΑΚΟΙΝΩΣΕΙΣ</h2> 
    <?php } ?>
  </div>

  <!-- Κουμπί επιστροφής στην κορυφή της σελίδας -->
  <a style="float: right; color: rgb(255, 102, 0)" href="#top"><p class="top">&lt;Top&gt;</p></a>
</body>

</html>