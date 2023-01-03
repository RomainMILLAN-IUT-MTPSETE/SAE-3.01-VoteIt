<link rel="stylesheet" href="css/Dashboard/dashboard-home.css">
<section class="dashboard--container">
    <div class="title--section">
        <h2>Dashboard<span class="colored">:</span></h2>
    </div>

    <section class="dashboard-content">
        <div class="user--container">
            <h2>Permissions utilisateur<span class="colored">:</span></h2>
            <form action="frontController.php?controller=dashboard&action=editPermission" method="post">
                <?php
                foreach ($usersList as $item) {
                    ?>
                    <div class="user-item">
                        <p><?php echo($item->getIdentifiant()) ?></p>
                        <select name="<?php echo($item->getIdentifiant()) ?>" id="<?php echo($item->getIdentifiant()) ?>">
                            <?php
                            if(strcmp($item->getGrade(), "Utilisateur") == 0){
                                ?>
                                <option value="Utilisateur" selected>Utilisateur</option>
                                <option value="Organisateur">Organisateur</option>
                                <option value="Administrateur">Administrateur</option>
                                <?php
                            }else if(strcmp($item->getGrade(), "Organisateur") == 0){
                                ?>
                                <option value="Utilisateur">Utilisateur</option>
                                <option value="Organisateur" selected>Organisateur</option>
                                <option value="Administrateur">Administrateur</option>
                                <?php
                            }else if(strcmp($item->getGrade(), "Administrateur") == 0){
                                ?>
                                <option value="Utilisateur">Utilisateur</option>
                                <option value="Organisateur">Organisateur</option>
                                <option value="Administrateur" selected>Administrateur</option>
                                <?php
                            }
                            ?>

                        </select>

                    </div>
                    <?php
                }
                ?>
                <input type="submit" value="Changer les permission">

            </form>
        </div>
        <div class="number--container">
            <div class="number">
                <h2><?php echo($nbQuestionsActives) ?></h2>
                <?php
                if($nbQuestionsActives>0){
                    echo '<p>Questions actives</p>';
                }else{
                    echo '<p>Question active</p>';
                }
                ?>
            </div>
            <div class="number">
                <h2><?php echo($nbAccounts); ?></h2>
                <?php
                if($nbAccounts>0){
                    echo '<p>Réponses actives</p>';
                }else{
                    echo '<p>Réponse active</p>';
                }
                ?>
            </div>
        </div>
    </section>
    <section class="dashboard-question-content">
        <div class="question-tab-to-proposer">
            <?php
            if(count($idQuestionListToProposer) != 0){
                ?>
                <table>
                    <thead>
                    <th>#</th>
                    <th>Autheur</th>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Ecriture début</th>
                    <th>Ecriture fin</th>
                    <th>Vote début</th>
                    <th>Vote fin</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($idQuestionListToProposer as $item){
                        $question = (new QuestionsRepository())->select($item);
                        ?>

                        <th><?php echo($item); ?></th>
                        <th><?php echo($question->getAutheur()) ?></th>
                        <th><?php echo($question->getTitreQuestion()) ?></th>
                        <th><?php echo($question->getCategorieQuestion()) ?></th>
                        <th><?php echo($question->getDateEcritureDebutFR()) ?></th>
                        <th><?php echo($question->getDateEcritureFinFR()) ?></th>
                        <th><?php echo($question->getDateVoteDebutFR()) ?></th>
                        <th><?php echo($question->getDateVoteFinFR()) ?></th>
                        <th><a href="frontController.php?controller=dashboard&action=changeProposerQuestion&id=<?php echo($item); ?>"><img src="assets/dashboard/edit.png" alt="Icone d'édition pour rendre un question visible"></a></th>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </section>
</section>