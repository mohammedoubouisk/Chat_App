<?php
session_start();
// si l'utilisateur s'est connecter
if(isset($_SESSION['user'])){
    // connexion a la base de donnee
    include('connexion_bdd.php');
    // requete pour afficher les messages 
    $req = mysqli_query($conn , "SELECT * FROM message ORDER BY id_m DESC");
    if(mysqli_num_rows($req) == 0){
        // si il n' y a pas encore de message 
        echo "Message vide";
    }else{
        // si oui 
        while($row= mysqli_fetch_assoc($req)){
            // si c'est vous qui avez envoyer le message on utlise ce format
            if($row['email'] == $_SESSION['user']){
                ?>
                    <div class="message your_message">
                        <span>Vous</span>
                        <p><?=$row['msg']?></p>
                        <p class="date"><?=$row['date']?></p>
                    </div>
                <?php
            }else{
                // si vous n'etes pas l'auteur du message , on affiche ce message sur format
                ?>
                    <div class="message others_message">
                        <span><?=$row['email']?></span>
                        <p><?=$row['msg']?></p>
                        <p class="date"><?=$row['date']?></p>
                    </div>
                <?php
            }
        }
    }

}
?>




