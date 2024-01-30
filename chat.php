<?php
// demarer la session
session_start();
if(!isset($_SESSION['user'])){
    // si l'utilisateur n'est pas connecter
    // redirection vers la page de connnexion
    header("location:index.php");
}
// email de l'utilisateur
$user = $_SESSION['user'] 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$user?> | CHAT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat">
        <div class="button-email">
            <span><?=$user?></span>
            <a href="deconnexion.php" class="Deconnexion_btn">Deconnexion</a>
        </div>
<!-- message ************************** -->
        <div class="messages_box">
            <?php
            include('messages.php');
            ?>
        </div>

        <!-- fin message ****************** -->
        <?php
        // envoi des messages
        if(isset($_POST['send'])){
            // recuperons le message
            $message = $_POST['message'];
            // connexion a la base se donnee 
            include('connexion_bdd.php');
            // verification si le champs n'est pas vide 
            if(isset($message) && $message != ""){
                // inserer le message dans la base de donnees 
                $req = mysqli_query($conn , "INSERT INTO message VALUES (NULL , '$user' , '$message',NOW())");
                // on actualise la page
                header('location:chat.php');
            }else{
                // si le message est vide on actualise la page
                header('location:chat.php');
            }
        }
        ?>



        <form action="" class="send_message" method="POST">
            <textarea name="message" cols="30" rows="2" placeholder="votre message"></textarea>
            <input type="submit" value="Envoyer" name="send">
        </form>

 


    </div>
    

    <script>
        // on actualise automatique le chat utlisant AJAX
        var message_box = document.querySelector('.messages_box');
        setInterval(function(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    message_box.innerHTML = this.responseText;
                }
            }
            xhttp.open("GET","messages.php" , true) ;//recuperation de la page message
            xhttp.send();

         },0) //actualise le chat tous les 500ms
        
    </script>
</body>
</html>