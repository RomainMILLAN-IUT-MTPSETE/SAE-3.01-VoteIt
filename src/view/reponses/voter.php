<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=reponses&action=voted" method="post">
    <div class="formulaire-template">
        <h2 class="title">Voter pour la réponse</h2>
        <div>
            <label for="idReponse">Id de la Réponse</label>
            <input type="number" name="idReponse" id="idReponse" value="<?php echo($_GET['idReponse']); ?>" readonly required/>
        </div>
        <div>
            <input type="submit" value="Voter pour la réponse">
        </div>
    </div>
</form>