<link rel="stylesheet" href="css/formulaire.css">

<form class="formulaire--container" action="frontController.php?controller=questions&action=deleted&idQuestion=<?php echo(rawurlencode($_GET['idQuestion'])); ?>" method="post">
    <div class="formulaire-template">
        <h2 class="title">Suppression de question</h2>
        <div>
            <label for="idQuestion">Id de la Question</label>
            <input type="number" name="idQuestion" id="idQuestion" value="<?php echo(htmlspecialchars($_GET['idQuestion'])); ?>" readonly required>
        </div>
        <div>
            <input type="submit" value="Supprimer la question">
        </div>
    </div>
</form>