<link rel="stylesheet" href="css/Reponses/reponses-formulaire.css">
<form class="reponses-formulaire--container" action="frontController.php?controller=reponses&action=created" method="post">
    <h2>Crée une réponse</h2>
    <div>
        <label for="titreQuestion">Identifiant Question</label>
        <input type="number" name="idQuestion" id="idQuestion" placeholder="11"/>
    </div>
    <div>
        <label for="autheur">Auteur</label>
        <input type="text" name="autheur" id="autheur" placeholder="JohnDoe10"/>
    </div>
    <div class="reponse-section--container">
        
    </div>
    <input type="hidden" name="controller" value="questions">
    <input type="hidden" name="action" value="created">
    <input type="submit" value="Poser la question">
</form>