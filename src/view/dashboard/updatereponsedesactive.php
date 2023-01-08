<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=dashboard&action=updatereponsedesactive" method="post">
    <div class="formulaire-template">
        <h2 class="title">Mettre à jour la reponse désactivée</h2>
        <div>
            <label for="titreReponse">Titre</label>
            <input type="text" name="titreReponse" id="titreReponse" placeholder="Titre de la reponse" readonly value="<?php echo($titre) ?>"/>
        </div>
        <div>
            <input type="hidden" name="idReponse" id="idReponse" placeholder="Identifiant de la reponse" readonly value="<?php echo($id); ?>"/>
            <input type="submit" value="Mettre à jour la reponse">
        </div>
    </div>
</form>