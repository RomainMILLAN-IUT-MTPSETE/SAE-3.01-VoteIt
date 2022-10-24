<?php
namespace App\VoteIt\view\profil;
use App\VoteIt\Model\Repository\UtilisateurRepository;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo('css/profil.css') ?>"/>
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

 <img src="<?php echo($user->getMail()) ?>">
<div id="bouton"> <button>Modifier profile : <img src="assets/logo/modif.png"></button></div>

<div id="idgrade">
<h1 ID="iden">
    Identifiant :
</h1>

    <p> <?php echo($user->getIdentifiant()) ?> </p>


<h2 ID="grade">
    Grade :
</h2>
     <p><?php echo($user->getGrade()) ?> </p>
</div>


<h2 ID="souligner">
  E-mail :
</h2>
 <p><?php echo($user->getIconeLink()) ?></p>

<h2 ID="souligner">
    Nom :
</h2>
<p><?php echo($user->getNom()) ?></p>

<h2 ID="souligner">
    Prenom :
</h2>
<p><?php echo($user->getPrenom()) ?> </p>

<h2 ID ="souligner">
    Date de naissance :
</h2>
<p><?php echo($user->getDateNaissance()) ?> </p>



</body>
</html>
