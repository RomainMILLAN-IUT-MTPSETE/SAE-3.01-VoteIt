<link rel="stylesheet" href="css/Questions/questions-home.css" type="text/css" >
    <section class="button-top">
        <?php
        use \App\VoteIt\Lib\ConnexionUtilisateur;
        if(ConnexionUtilisateur::estConnecte()){
        $user = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select(ConnexionUtilisateur::getLoginUtilisateurConnecte());

            if((strcmp($user->getGrade(), "Organisateur") == 0) OR (strcmp($user->getGrade(), "Administrateur") == 0)){
                ?><a href="frontController.php?controller=questions&action=create"><button id="buttonTop">Proposer une Question <img id="imgButtonTop" src="assets/questions/home/button-newquestion.png" alt="Icone de nouvelle question"></button></a><?php
            }

        }
        ?>
    </section>
    <section class="listeQuestion">
           <p id="question-title">
               <?php
               if(count($questions)<=1){
                   echo 'Question';
               }else{
                   echo 'Questions';
               }
               ?> (<?php
               echo count($questions)
               ?>)
               <span class="colored">:</span>
           </p>
       <a href="#" id="filtre" style="display:none;">Filtrer <img id="imgFiltre" src="assets/questions/home/filter.png" alt="Icone de filtre"></a>
    </section>
    <?php
        foreach ($questions as $id) { ?>
            <a href="frontController.php?controller=questions&action=see&idQuestion=<?php echo(rawurlencode($id->getIdQuestion())); ?>"><div class="question-id--container">
                    <div id="titreQuestion" >
                        <?php
                        echo htmlspecialchars($id->getTitreQuestion());
                        ?>
                    </div>
                    <div id="auteurEtCategorie">
                        <div id="auteur">
                            <?php
                            $idAutheur = $id->getAutheur();
                            $autheur = (new \App\VoteIt\Model\Repository\UtilisateurRepository())->select($idAutheur);
                            echo htmlspecialchars($autheur->getNom()) . " " . htmlspecialchars($autheur->getPrenom())
                            ?>
                        </div>
                        <div id="categorie">
                            <?php echo htmlspecialchars($id->getCategorieQuestion());?>
                        </div>
                    </div>
                </div></a>

        <?php } ?>



