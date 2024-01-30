<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>conexion | chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if(isset($_POST['button_inscription'])){
        // se connect a la base de donnee
        include "connexion_bdd.php";
        // extraire les info de la formolaire
        extract($_POST);
        if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != "" && isset($mdp2) && $mdp2 != ""){
            // verification que les moes de pass sont diff
            if($mdp1 != $mdp2){
                $error = "les Mots de passes sont differents !";
            }else{
                // si non ,  verification si l'email existe
                $req  = mysqli_query($conn , "SELECT * FROM ulilisateur WHERE email = '$email'");
                if(mysqli_num_rows($req) == 0){
                    // sica n'existe pas , creation le compte
                    $req = mysqli_query($conn , "INSERT INTO ulilisateur VALUES (null , '$email' , '$mdp1')");
                    if($req){
                        // si le compte a ete creer , creation une variable pour afficher un message dans la page de connexion
                        $_SESSION['message'] = "<p class='message_inscription'>Votre compte a ete creer avec succes </p>";
                        // redirection vers la page de connexion
                        header("location:index.php");

                    }
                }else{
                    // si ca exist
                    $error = "Cet Email existe deja !";
                }
            }
        }else{
            $error = "Veillez remplir tous les champs * ";
        }

    }
    ?>
    <form action="" method="POST" class="from_connexion_inscription">
        <h1>INSCRIPTION</h1>
        <P class="message_error">
            <?php if(isset($error)){
                echo $error;
                
            }
            ?>
        </P>
        <label>Adresse Mail</label>
        <input type="email" name="email">

        <label>Mots de passe</label>
        <input type="password" name="mdp1" class="mdp1">

        <label>Confirmation Mots de passe</label>
        <input type="password" name="mdp2" class="mdp2">

        <input type="submit" value="INSCRIPTION"  name="button_inscription">
        <p class="link">Vous avez  de compte ?</p><a href="inscription.php">creer une compte</a>

    </form>

    <script src="script.js"></script>
    
</body>
</html>