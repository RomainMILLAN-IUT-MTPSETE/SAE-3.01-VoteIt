<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=questions&action=departagedQuestion" method="post">
    <div class="formulaire-template">
        <h2 class="title">Voter pour la réponse</h2>
        <div>
            <label for="reponseSelect">Sélectionner la réponse gagnante</label>
            <select name="reponseSelect" id="reponseSelect">
                <?php
                foreach ($reponsesList as $reponse){
                    ?><option value="<?php echo($reponse->getIdReponse()) ?>"><?php echo($reponse->getTitreReponse()) ?></option><?php
                }
                ?>
            </select>
        </div>

        <div>
            <input type="hidden" name="idQuestion" value="<?php echo($_GET['idQuestion']); ?>">
            <input type="submit" value="Départagement pour la question">
        </div>
    </div>
</form>