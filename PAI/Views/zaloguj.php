<?php

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM uzytkownicy WHERE email='$email' AND haslo ='$password'";
        
        if($rezultat = @$polaczenie->query($sql))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $user = $wiersz['email'];

                $rezultat->free();

                header('Location: start.php');

            }
            else
            {
                
            }
        }


        $polaczenie->close();
    }


?>