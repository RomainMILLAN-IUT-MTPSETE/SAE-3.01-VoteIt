<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=questions&action=deleted&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])); ?>" method="post">
    <div class="formulaire-template">
        <h2 class="title">Suppression de question</h2>
        <div>
            <label for="idQuestion">Nom de la question</label>
            <input type="text" name="titleQuestion" id="titleQuestion" value="<?php echo(htmlspecialchars($question->getTitreQuestion())); ?>" readonly required>
        </div>
        <div>
            <input type="number" name="idQuestion" id="idQuestion" value="<?php echo(htmlspecialchars($question->getIdQuestion())); ?>" readonly hidden required>
            <input type="submit" value="Supprimer la question">
        </div>
    </div>
</form>