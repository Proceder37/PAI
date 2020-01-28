<?php
    session_start();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="Stylesheet" type="text/css" href="../Public/css/style.css" />
    <title>WorkCounter</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="../Public/img/logo.svg">
        <img src="../Public/img/workcounter.svg">
    </div>
    <form action="zaloguj.php", method="post">
        <a href="rejestracja.php"> Rejestracja - załóż darmowe konto!</a>
        <br /><br /> 
        <input name="email" type="text" placeholder="email@email.com">
        <br></br>
        <input name="password" type="password" placeholder="password">
        <br></br>
        <button type="submit">CONTINUE</button>



    </form>

    <?php
        if(isset($_SESSION['blad']))    echo $_SESSION['blad'];
    ?>
</div>
</body>
</html>