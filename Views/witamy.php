<?php
    session_start();

    if(!isset($_SESSION['udanarejestracja']))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['udanarejestracja']);
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="Stylesheet" type="text/css" href="../Public/css/style.css" />
    <title>WorkCounter</title>
</head>
<body>
        Dziękujemy za rejestracje w serwisie! Możesz już zalogować się na swoje konto!<br /><br />
        <a href="index.php"> Zaloguj się na swoje konto!</a>
  
    <?php
        if(isset($_SESSION['blad']))    echo $_SESSION['blad'];
    ?>

</body>
</html>