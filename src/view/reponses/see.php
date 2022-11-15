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
        use \App\VoteIt\Model\Repository\SectionRepository;
        foreach ($sectionsReponse as $item) {
            ?>
            <div class="text-reponse">
                <div class="title-text-reponse">
                    <h2><?php echo((new SectionRepository())->selectFromIdSection($item->getIdSection())->getTitreSection()) ?></h2>
                    <p><?php echo($item->getTexteSection()) ?></p>
                </div>
            </div>
            <?php
            //var_dump($item);
        }
        ?>
    </div>

</section>