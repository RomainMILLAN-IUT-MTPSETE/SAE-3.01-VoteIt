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

    </section>
</section>
