<?php
    session_start();

    if(isset($_POST['email']))
    {
        //udana walidacja
        $wszystko_OK=true;

        //Sprawdzamy nazwe
        $nick=$_POST['nick'];

        //Sprawdzenie dlugosci nicka
        if((strlen($nick))<3 || (strlen($nick) >20))
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']="Nick musi posidać od 3 do 20 znaków!";
        }

        //Sprawdzanie polskich znakow itp
        if(ctype_alnum($nick)==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr(bez PL znaków)";
        }

        //Sprawdz email
        $email=$_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $wszystko_OK=false;
            $_SESSION['e_email']="Podaj poprawy adres e-mail!";
        }

        //Sprawdz haslo
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if((strlen($haslo1)< 8 ) || (strlen($haslo1)>20))
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Hasło musi posidać od 8 do 20 znaków";
        }

        if($haslo1!=$haslo2)
        {
            $wszystko_OK=false;
            $_SESSION['e_haslo']="Podane hasla nie sa takie same";
        }

        $haslo_hash= password_hash($haslo1, PASSWORD_DEFAULT);

        //Sprawdzanie regulaminu
        if(!isset($_POST['regulamin']))
        {
            $wszystko_OK=false;
            $_SESSION['e_regulamin']="Zatwierdz regulamin";
        }

        //Sprawdzanie Bota
        $sekret= "6LdDUtMUAAAAAGbBHRrdW6BBNp8TCzU1ZnRxDA9d";

        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

        $odpowiedz=json_decode($sprawdz);

        if($odpowiedz->success==false)
        {
            $wszystko_OK=false;
            $_SESSION['e_bot']="Potwierdz ze nie jestes botem";
        }

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                //czy email juz istnieje
                $rezultat=$polaczenie->query("SELECT id_uzytkownik FROM uzytkownicy WHERE email='$email'");
                if(!$rezultat) throw new Exception($polaczenie->error);
                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_email']="Istnieje juz konto z takim e-mailem";
                }
                //czy nick juz istnieje
                $rezultat=$polaczenie->query("SELECT id_uzytkownik FROM uzytkownicy WHERE nick='$nick'");

                if(!$rezultat) throw new Exception($polaczenie->error);
                $ile_takich_nickow = $rezultat->num_rows;
                if($ile_takich_nickow>0)
                {
                    $wszystko_OK=false;
                    $_SESSION['e_nick']="Istnieje juz taki nick.";
                }

                
                if($wszystko_OK==true)
                {
                    //Dodajemy do bazy
                    if($polaczenie->query("INSERT INTO uzytkownicy VALUES(null,'$nick','$email','$haslo_hash')"))
                    {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: witamy.php');
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }
                }

                $polaczenie->close();
            }
        }
        catch(Exception $e)
        {
            echo 'Blad serwera! ';
            echo '<br />Informacja deweloperska: '.$e;
        }
    }

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="Stylesheet" type="text/css" href="../Public/css/style.css" />
    <title>WorkCounter - załóż darmowe konto</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<div class="container">
    <form method="post">
    Nickname: <br /> <input type="text" name="nick"/> 

    <?php

        if(isset($_SESSION['e_nick']))
        {
            echo'<div class="error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
        }

    ?><br />

    Email: <br /> <input type="text" name="email"/> 
    <?php

        if(isset($_SESSION['e_email']))
        {
            echo'<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }

    ?><br />
    Password: <br /> <input type="password" name="haslo1"/> 
    <?php

        if(isset($_SESSION['e_haslo']))
        {
            echo'<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }

    ?><br />
    
    Confirm Password: <br /> <input type="password" name="haslo2"/> <br />
    <label>
        <input type="checkbox" name="regulamin" /> Accept Rules
    </label>
    <?php

        if(isset($_SESSION['e_regulamin']))
        {
            echo'<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }

    ?><br />
    <div class="g-recaptcha" data-sitekey="6LdDUtMUAAAAAGyNsSK3CIauyvAKNL1aDMcfLASw"> </div>
    <?php

        if(isset($_SESSION['e_bot']))
        {
            echo'<div class="error">'.$_SESSION['e_bot'].'</div>';
            unset($_SESSION['e_bot']);
        }

    ?><br />

    <input type="submit" value="Zarejestruj sie" />
    </form>
</div>
</body>
</html>