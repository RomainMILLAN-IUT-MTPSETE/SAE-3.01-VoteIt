<link rel="stylesheet" href="css/Dashboard/dashboard-home.css">
<section class="dashboard--container">
    <div class="title--section">
        <h2>Dashboard<span class="colored">:</span></h2>
    </div>

    <section class="dashboard-content">
        <div class="user--container">
            <h2>Permission utilisateur<span class="colored">:</span></h2>
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
                <h2><?php echo((new \App\VoteIt\Model\Repository\QuestionsRepository())->countNbQuestionActive()) ?></h2>
                <p>Question active</p>
            </div>
            <div class="number">
                <h2><?php echo((new \App\VoteIt\Model\Repository\UtilisateurRepository())->countNbAccount()); ?></h2>
                <p>Réponse active</p>
            </div>
        </div>
    </section>
</section>