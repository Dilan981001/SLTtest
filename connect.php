<?php
$uniname = $_POST['uniname'];
$uniaddress = $_POST['uniaddress'];
$unidate = $_POST['unidate'];
$uniid = $_POST['uniid'];
$uniwhnumber = $_POST['uniwhnumber'];
$prename = $_POST['prename'];
$preid = $_POST['preid'];
$prewhnum = $_POST['prewhnum'];
$prenum = $_POST['prenum'];
$preemail = $_POST['preemail'];
$secname = $_POST['secname'];
$secid = $_POST['secid'];
$secwhnum = $_POST['secwhnum'];
$secnum = $_POST['secnum'];
$secemail = $_POST['secemail'];

$conn = new mysqli('localhost', 'root', '', 'slttest');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
  
    $checkQuery = "SELECT uniname FROM data WHERE uniname = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $uniname);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Union name is not unique. Please choose a different name.";
    } else {
       
        $insertQuery = "INSERT INTO data (uniname, uniaddress, unidate, uniid, uniwhnumber, prename, preid, prewhnum, prenum, preemail, secname, secid, secwhnum, secnum, secemail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);

        
        $stmt->bind_param("sssssssssssssss", $uniname, $uniaddress, $unidate, $uniid, $uniwhnumber, $prename, $preid, $prewhnum, $prenum, $preemail, $secname, $secid, $secwhnum, $secnum, $secemail);

       
   

        if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
         $uploadDir = 'Uploads/'; 
         $uploadFile = $uploadDir . basename($_FILES['fileToUpload']['name']); 

 
          $counter = 1;
          while (file_exists($uploadFile)) {
        $info = pathinfo($uploadFile);
        $uploadFile = $uploadDir . $info['filename'] . "_$counter." . $info['extension'];
        $counter++;
    }

          if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
         echo "successfully uploaded. File path: $uploadFile";
    } 
}       else {
         echo "No file uploaded or an error occurred.";
}



        
       
        if ($stmt->execute()) {
            echo "Registration successful...";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
