<form class="questions-formulaire--container" action="frontController.php?controller=questions&action=deleted&idQuestion=<?php echo($_GET['idQuestion']); ?>" method="post">
    <h2>Suppression de question</h2>
    <div>
        <label for="idQuestion">idQuestion</label>
        <input type="text" name="idQuestion" id="autheur" placeholder="JohnDoe10"/>
    </div>
    <input type="submit" value="Supprimer la question">
</form>