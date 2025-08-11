<?php

    // Συνάρτηση για τη σύνδεση στη βάση δεδομένων
    function connectToDb(&$conn)
    {
        // Σύνδεση στη βάση δεδομένων
        //$conn = new mysqli('localhost', 'root', '', 'student4038');

        // Σύνδεση online
        $conn = new mysqli('webpagesdb.it.auth.gr:3306', 'evangdimos', '12345', 'student4038');

        // Έλεγχος εάν η σύνδεση απέτυχε
        if ($conn->connect_error) 
        {
            die('Connection Failed : ' . $conn->connect_error);
        }
    }

    // Συνάρτηση για έλεγχο της μορφής μιας ημερομηνίας
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    // Συνάρτηση για έλεγχο εάν ένα κείμενο είναι κενό ή περιέχει μόνο κενά
    function stringIsNullOrWhitespace($text)
    {
        return ctype_space($text) || $text === "" || $text === null;
    }

    // Συνάρτηση για μεταφόρτωση ενός αρχείου
    function uploadFile($pwd)
    {
        $path_filename_ext = "";

        // Έλεγχος εάν έχει επιλεγεί αρχείο για μεταφόρτωση
        if (($_FILES[$pwd]['name'] != "")) 
        {
            // Φάκελος προορισμού αποθήκευσης αρχείων
            $target_dir = "./uploads/";

            // Πληροφορίες του αρχείου
            $file = $_FILES[$pwd]['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES[$pwd]['tmp_name'];
            $path_filename_ext = $target_dir . $filename . "." . $ext;
        
            // Μεταφόρτωση του αρχείου
            move_uploaded_file($temp_name, $path_filename_ext);
        }

        return $path_filename_ext;
    }

    // Συνάρτηση για απόκρυψη του κωδικού πρόσβασης
    function hidePwd($pwd)
    {
        $length = strlen($pwd);
        $encryptPwd = "";
        
        // Αντικατάσταση κάθε χαρακτήρα του κωδικού με '*'
        for($i = 0; $i < $length; $i++)
        {
            $encryptPwd .= '*';
        }
    
        return $encryptPwd;
    }

    // Συνάρτηση για έλεγχο εάν ένα email υπάρχει ήδη στη βάση δεδομένων
    function emailExists($email)
    {
        // Σύνδεση στη βάση δεδομένων
        connectToDb($conn);

        // Εκτέλεση ερωτήματος για έλεγχο της ύπαρξης του email
        $sql = "SELECT loginame FROM users where loginame = '$email' ";
        $result = $conn
        ->query($sql);

        // Έλεγχος του αποτελέσματος του ερωτήματος
        if($result)
        {
            // Εάν υπάρχουν αποτελέσματα, επαναλαμβάνουμε τα δεδομένα και ελέγχουμε το email
            while ($row = $result->fetch_assoc())
            {
                $existing_email = $row['loginame'];

                // Εάν το email υπάρχει, επιστρέφουμε 1
                if($email == $existing_email){
                    return 1;
                }
            }
        }
        else
        {
            // Εμφάνιση σφάλματος εάν η εκτέλεση του ερωτήματος αποτύχει
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // Επιστροφή 0 αν το email δεν υπάρχει στη βάση δεδομένων
        return 0;
    }

?>