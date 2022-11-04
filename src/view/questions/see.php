<?php
//$question = new Question();
?>

<link rel="stylesheet" href="css/Questions/questions-see.css">
<section class="question-see--container">
    <section class="sect-see-question">
        <div class="sub-see-question-container">
            <h2><?php echo($question->getTitreQuestion()) ?></h2>
            <p><?php echo($question->getTexteQuestion()) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2>Plan imposé:</h2>
            <p><?php echo($question->getPlanQuestion()) ?></p>
        </div>
        <div class="sub-see-question-container">
            <h2>Délais:</h2>
            <p>Ecriture des réponses: Du <?php echo($question->getDateEcritureDebut()); ?> au <?php echo($question->getDateEcritureFin()); ?></p>
            <p>Vote: Du <?php echo($question->getDateVoteDebut()) ?> au <?php echo($question->getDateVoteFin()) ?></p>
        </div>
    </section>
    <section class="reponse--container">

    </section>
</section>
