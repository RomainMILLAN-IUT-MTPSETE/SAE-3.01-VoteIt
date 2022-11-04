<?php
//$question = new Question();
?>

<link rel="stylesheet" href="css/Questions/questions-see.css">
<section class="question-see--container">
    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question"><?php echo($question->getTitreQuestion()) ?></span></h2>
            <p><?php echo($question->getTexteQuestion()) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2><span class="title-sub-see-question">Plan imposé:</span></h2>
            <p><?php echo($question->getPlanQuestion()) ?></p>
        </div>
        <div class="sub-see-question-container" id="sub-see-question-container-delais">
            <h2><span class="title-sub-see-question">Délais:</span></h2>
            <p id="sub-see-question-container-delais-pfirst">Ecriture des réponses: Du <?php echo($question->getDateEcritureDebut()); ?> au <?php echo($question->getDateEcritureFin()); ?></p>
            <p>Vote: Du <?php echo($question->getDateVoteDebut()) ?> au <?php echo($question->getDateVoteFin()) ?></p>
        </div>
    </section>
    <section class="reponse--container">
        <div class="reponse-id--container">
            <p class="reponse-number">Réponse n°1</p>
            <p class="reponse-txt">Voyons s’il était mieux d’être un enfant avant à travers la musique !Voyons s’il était mieux d’être un enfant avant à travers la musique !Voyons s’il était mieux d’être un enfant avant à travers la musique !</p>
            <div class="autheur-and-nb-vote--container">
                <p class="autheur-reponse">Autheur: John Doe</p>
                <span class="nbVote-reponse"><img src="assets/questions/see/like.png" alt="Icone LikeVoteNombre">148</span>
            </div>
        </div>
    </section>
</section>