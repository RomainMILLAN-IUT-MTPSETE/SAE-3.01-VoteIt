<?php
namespace App\VoteIt\view\profil;
use App\VoteIt\Model\Repository\UtilisateurRepository;
?>

<!DOCTYPE html>
<html>
<head>
     <title></title>
</head>
<body>
<?php

$idUser = $_GET['idUtilisateur'];
$user = (new UtilisateurRepository())->select($idUser);

if($user == NULL){
     echo"l'utilisateur n'existe pas";
}



?>
<p>
    <?php echo($user->getIconeLink()) ?>
</p>
<p>
    Identifiant : <?php echo($user->getIdentifiant()) ?>
</p>

<p>
    Grade : <?php echo($user->getGrade()) ?>
</p>
<p>
    E-Mail :<?php echo($user->getMail()) ?>
</p>
<p>
    Nom : <?php echo($user->getNom()) ?>
</p>
<p>
    Prenom : <?php echo($user->getPrenom()) ?>
</p>
<p>
    Date de naissance : <?php echo($user->getDateNaissance()) ?>
</p>
</body>
</html>
