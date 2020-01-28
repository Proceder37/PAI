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
        
        if($rezultat = @$polaczenie->query(
            sprintf("SELECT * FROM uzytkownicy WHERE email='%s' ",
            mysqli_real_escape_string($polaczenie,$email))))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow>0)
            {
                $wiersz = $rezultat->fetch_assoc();
                
                if(password_verify($password,$wiersz['haslo']))
                {

                

                    $_SESSION['zalogowany']=true;
                    
                    $user = $wiersz['email'];

                    unset($_SESSION['blad']);
                    $rezultat->free();

                    header('Location: start.html');
                }
                else
                {
                    $_SESSION['blad']= '<span style="color:red">Nieprawidłowy login lub haslo!</span>';
                    header('Location: index.php');
                }
            
            }
            else
            {
                $_SESSION['blad']= '<span style="color:red">Nieprawidłowy login lub haslo!</span>';
                header('Location: index.php');
            }
        }


        $polaczenie->close();
    }


?>