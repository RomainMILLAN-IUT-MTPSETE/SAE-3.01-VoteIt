<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=reponses&action=voted" method="post">
    <div class="formulaire-template">
        <h2 class="title">Voter pour la réponse</h2>
        <div>
            <label for="titleReponse">Titre de la Réponse</label>
            <input type="text" name="titreReponse" id="titreReponse" value="<?php echo(htmlspecialchars($titleReponse)); ?>">
        </div>
        <div>
            <input type="number" name="idReponse" id="idReponse" value="<?php echo(htmlspecialchars($_GET['idReponse'])); ?>" readonly hidden required/>
            <input type="submit" value="Voter pour la réponse">
        </div>
    </div>
</form>