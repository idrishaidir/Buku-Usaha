<?php

include 'config/database.php'; 

if (isset($_POST['kirim'])) {
    
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $subjek   = mysqli_real_escape_string($conn, $_POST['subjek']);
    $pesan    = mysqli_real_escape_string($conn, $_POST['pesan']);

    
    if (!empty($nama) && !empty($email) && !empty($whatsapp) && !empty($subjek) && !empty($pesan)) {
        
    
        $sql = "INSERT INTO pesan_kontak (nama, email, whatsapp, subjek, pesan) 
                VALUES ('$nama', '$email', '$whatsapp', '$subjek', '$pesan')";

    
        if (mysqli_query($conn, $sql)) {
    
            echo "<script>
                    alert('Terima kasih, $nama! Pesan Anda telah kami terima dan akan segera diproses.');
                    window.location.href = 'kontak.php';
                  </script>";
        } else {
    
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    } else {
    
        echo "<script>
                alert('Mohon lengkapi semua data formulir!');
                window.history.back();
              </script>";
    }
} else {
    header("Location: kontak.php");
    exit();
}
?>