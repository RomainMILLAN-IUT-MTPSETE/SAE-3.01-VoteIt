<link rel="stylesheet" href="css/Reponses/reponses-see.css">
<section class="reponse-see--container">
    <?php //var_dump($reponse); ?>

    <div class="title-reponse--container">
        <div class="title">
            <h2>Réponse n°<?php echo($reponse->getIdReponse()); ?>:</h2>
        </div>
        <p class="title-p"><?php echo($reponse->getTitreReponse()); ?></p>
    </div>
    <hr WIDTH="400px">
    <div class="text-reponse--container">
        <?php
        foreach ($sectionsReponse as $item) {
            var_dump($item);
        }
        ?>
    </div>

</section>