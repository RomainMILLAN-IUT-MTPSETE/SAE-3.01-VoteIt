<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=questions&action=voted" method="post">
    <div class="formulaire-template">
        <h2 class="title">Voter pour la réponse</h2>
        <?php
        foreach ($reponses as $reponse){
            ?>
            <div>
                <label for="<?php echo($reponse->getIdReponse()) ?>"><?php echo($reponse->getTitreReponse()); ?></label>
                <select name="<?php echo($reponse->getIdReponse()) ?>" id="<?php echo($reponse->getIdReponse()) ?>">
                    <option value=0 selected>À retirer</option>
                    <option value=1>Pas bien</option>
                    <option value=2>Passable</option>
                    <option value=3>Assez Bien</option>
                    <option value=4>Bien</option>
                    <option value=5>Très bien</option>
                </select>
            </div>
            <?php
        }
        ?>

        <div>
            <input type="hidden" name="idQuestion" value="<?php echo($_GET['idQuestion']); ?>">
            <input type="submit" value="Voter pour la réponse">
        </div>
    </div>
</form>