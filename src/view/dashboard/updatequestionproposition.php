<link rel="stylesheet" href="css/formulaire.css">
<form class="formulaire--container" action="frontController.php?controller=dashboard&action=updatequestionproposition" method="post">
    <div class="formulaire-template">
        <h2 class="title">Mettre à jour la proposition de la question</h2>
        <div>
            <label for="idQuestion">Identifiant</label>
            <input type="text" name="idQuestion" id="" placeholder="Identifiant de la question" readonly value="<?php echo($id); ?>"/>
        </div>
        <div>
            <label for="titreQuestion">Titre</label>
            <input type="text" name="titreQuestion" id="titreQuestion" placeholder="Titre de la question" readonly value="<?php echo($titre) ?>"/>
        </div>
        <div>
            <input type="submit" value="Mettre à jour la question">
        </div>
    </div>
</form>