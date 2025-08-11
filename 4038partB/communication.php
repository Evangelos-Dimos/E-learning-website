<!-- ΕΠΙΚΟΙΝΩΝΙΑ -->

<?php
session_start();
    include("functions.php");

    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $displayMessage = "";
    if(!isset($_SESSION['username'])){ //if login in session is not set
        header("Location: index.php");
        
    }
    $loginame = $_SESSION['username'];

    if (isset($_POST['sendButton']) && $_SERVER['REQUEST_METHOD'] == "POST") {
        $sender = $_POST["sender"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        
        //connect to db
        connectToDb($conn);
        do {
            if(empty($sender) || empty($subject) || empty($message) ||
            stringIsNullOrWhitespace($sender) ||
            stringIsNullOrWhitespace($subject) ||
            stringIsNullOrWhitespace($message)){
                $displayMessage = "All fields required";
                break;
            }
            $sql = "SELECT loginame FROM users WHERE role = 'Tutor' ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $recipient = $row['loginame'];

                    $mail = new PHPMailer();
                    // Settings
                    $mail->IsSMTP();
                    $mail->CharSet = 'UTF-8';
                    $mail->Host       = "mail.example.com";    // SMTP server example
                    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                    $mail->SMTPAuth   = true;                  // enable SMTP authentication
                    $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
                    $mail->Username   = "username";            // SMTP account username example
                    $mail->Password   = "password";            // SMTP account password example
                    // Content
                    $mail->setFrom($loginame);   
                    $mail->addAddress($recipient);              
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    try{
                        $mail->send();
                        $displayMessage = "Message Successfully Sent to Tutors";
                    } catch(Exception $e){
                        $displayMesasge = "Error!" . $e->errorMessage();
                    } 
                }
                break;
            }else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } while (true);
        
        $conn->close();
    }

?>

<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Επικοινωνία</title>
    <link rel="stylesheet" href="Style/style.css"> <!-- Σύνδεση με το αρχείο CSS για το στιλισμό -->

  </head>

<body>

    <div class="header">
        <h1>Επικοινωνία</h1> <!-- Επικεφαλίδα σελίδας -->
    </div>

    <!-- Αυτό είναι sidebar menu με τις επιλογές του -->
    <div class="sidebar">

        <a href="homepage.php">
            <button class="sidebar_button">Αρχική Σελίδα</button>
        </a>

        <a href="announcements.php">
            <button class="sidebar_button">Ανακοινώσεις</button>
        </a>

        <a href="communication.php">
            <button class="sidebar_button">Επικοινωνία</button>
        </a>

        <a href="documents.php">
            <button class="sidebar_button">Έγγραφα μαθήματος</button>
        </a>

        <a href="homework.php">
            <button class="sidebar_button">Εργασίες</button>
        </a>

        <!-- Έλεγχος ρόλου του χρήστη και εμφάνιση επιπλέον επιλογών στο μενού -->
        <?php if($_SESSION['role'] == 'Tutor') { ?>

          <a href="users.php">
            <button class="sidebar_button">Διαχείριση Χρηστών</button>
          </a>

        <?php } ?>

        <br><br><br><br><br><br><br><br><br>

        <a href="logout.php">
          <!-- Κουμπί αποσύνδεσης -->
            <button class="sidebar_button">Logout</button>
        </a>

    </div>

    <div class="communication">

      <p class="communication_description"> Μπορείτε να αποστείλετε e-mail στον διδάσκοντα:<ul class="bullets">
        <li>Μέσω web φόρμας</li>
        <li>Με χρήση e-mail διεύθυνσης</li> </ul> 
      </p>

      <!-- Μορφοποιημένο σαν heading 2 -->
      <h2 class="communication_title"> Αποστολή e-mail μέσω web φόρμας</h2>

      <div class="communication_body">                

        <form action="" method="post">

          <label for="sender"><b>Αποστολέας:</b></label>
          <textarea id="sender" name="sender" placeholder="Εισαγωγή email..."><?php echo $loginame ?></textarea>
          <br>

          <label for="subject"><b>Θέμα:</b></label>
          <textarea id="subject" name="subject" placeholder="Εισαγωγή θέματος..."></textarea>
          <br>

          <label for="message"><b>Κείμενο:</b></label>
          <textarea id="message" name="message" placeholder="Εισαγωγή κειμένου..."></textarea>
          <br>

          <input class="button" type="submit" value="Αποστολή" name="sendButton">
          
          <div style="color: red;">
            <?php echo $displayMessage ?>
          </div>

        </form><br>

      </div>

      <!-- Μορφοποιημένο σαν heading 2 -->
      <h2 class="communication_title"> Αποστολή e-mail με χρήση e-mail διεύθυνσης </h2>

      <div class="communication_body">

        Εναλλακτικά μπορείτε να αποστείλετε e-mail στην<br>
        παρακάτω διεύθυνση ηλεκτρονικού ταχυδρομείου<br>
        <?php 
          
          connectToDb($conn);

          $sql = "SELECT loginame FROM users where role = 'Tutor' ";
          $tutor_email = "";
          $result = $conn->query($sql);
          if($result)
          {
            while($row = $result->fetch_assoc())
            {
              $tutor_email = $row['loginame'];
        ?> 

        <a style="font-size:large;" href = "mailto: <?php echo $tutor_email ?>"><?php echo $tutor_email ?></a><br></h3> 
        
        <?php }
          
          }
          else
          {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        ?>
                  
        </div>
        
    </div>

  </body>

</html>