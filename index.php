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
    if(isset($_POST['button_con'])){
        // se connect a la base de donnee
        include "connexion_bdd.php";
        // extraire les info de la formolaire
        extract($_POST);

        if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != ""){
            // verification si les identifiants sont justes
            $req = mysqli_query($conn , "SELECT * FROM ulilisateur WHERE email = '$email' AND mdp = '$mdp1'");
            if(mysqli_num_rows($req) > 0){
                // si les ids sont justes
                // creation d'une session qui conteint l'email
                $_SESSION['user'] = $email;
                // redirection vers la page chat    
                header("location:chat.php");
                // detruire la variable du message d'inscription
                unset($_SESSION['message']);
            }
            else{
                // sinon
                $error = "Email ou mote de passe incorrecte(s)";
            }
        }
        else{
            // si les champs sont vides 
            $error = "veuillez remplir tous les champs * ";
        }
    }
     ?>
    <form action=""  method="POST" class="from_connexion_inscription">
        <h1>CONNEXION</h1>
        <?php
            // affichons le message qui dit q'un compte a ete creer
            if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
            }
         ?>
        <P class="message_error">
            <?php if(isset($error)){
                echo $error;
                
            }
            ?>
        </P>
        <label>Adresse Mail</label>
        <input type="email" name="email" >

        <label>Mots de passe</label>
        <input type="password" name="mdp1" >
        <input type="submit" value="connexion" name='button_con'>
        <p class="link">Vous n'avez pas de compte ?</p><a href="inscription.php">Creer un compte</a>

    </form>
    
</body>
</html>