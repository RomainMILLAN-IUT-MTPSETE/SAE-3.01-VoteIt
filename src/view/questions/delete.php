<link rel="stylesheet" href="css/Questions/questions-formulaire.css">
<form class="questions-formulaire--container" action="frontController.php?controller=questions&action=deleted&idQuestion=<?php echo($_GET['idQuestion']); ?>" method="post">
    <h2>Suppression de question</h2>
    <div>
        <p for="idQuestion">êtes-vous sûr de vouloir supprimer cette question ?</p>
    </div>
    <input type="submit" value="Supprimer la question">
</form>