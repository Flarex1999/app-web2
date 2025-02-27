<?php
$session = session();
?>



<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>
<form method="get" action="<?= site_url('compte/creer_compte_backend') ?>" target="_blank">
    <button class="submit-button" type="submit" name="submit">
        <img src="<?= base_url('uploads/add-scenario.png') ?>" alt="Eye Icon" class="small-eye" style="width: 30px;">
    </button>
</form>

<br>
<table>
    <tr>
        <th>ID</th>
        <th>Login</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Role</th>
        <th>Etat</th>
        <th>Action</th>
    </tr>
    <?php foreach ($afficher_tp as $profil): ?>

        <?php if ($profil['cpt_login'] == $session->get('user')): ?>
            <tr style="background-color: #cefad0;">
                <td>
                    <?= $profil['cpt_id'] ?>
                </td>
                <td>
                    <?= $profil['cpt_login'] ?>
                </td>
                <td>
                    <?= $profil['pfl_nom'] ?>
                </td>
                <td>
                    <?= $profil['pfl_prenom'] ?>
                </td>
                <td>
                    <?= $profil['pfl_email'] ?>
                </td>
                <td>
                    <?= $profil['pfl_role'] ?>
                </td>
                <td
                    style="background-color: <?= ($profil['pfl_etat'] == 'A') ? 'rgba(0, 128, 0, 0.3)' : 'rgba(255, 0, 0, 0.3)' ?>">
                    <?= $profil['pfl_etat'] ?>
                </td>
                <td>

                    <form method="post" action="<?= site_url('/compte/gerer_etat_profil') ?>">
                        <input type="hidden" name="profil_id" value="<?= $profil['cpt_id'] ?>">
                        <button class="submit-button" type="submit" name="action" value="A">Activer</button>
                        <button class="submit-button" type="submit" name="action" value="D">Desactiver</button>
                    </form>

                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (!empty($afficher_tp) && is_array($afficher_tp)): ?>


        <?php foreach ($afficher_tp as $profil): ?>

            <?php if ($profil['cpt_login'] != $session->get('user')): ?>
                <tr>
                    <td>
                        <?= $profil['cpt_id'] ?>
                    </td>
                    <td>
                        <?= $profil['cpt_login'] ?>
                    </td>
                    <td>
                        <?= $profil['pfl_nom'] ?>
                    </td>
                    <td>
                        <?= $profil['pfl_prenom'] ?>
                    </td>
                    <td>
                        <?= $profil['pfl_email'] ?>
                    </td>
                    <td>
                        <?= $profil['pfl_role'] ?>
                    </td>
                    <td
                        style="background-color: <?= ($profil['pfl_etat'] == 'A') ? 'rgba(0, 128, 0, 0.3)' : 'rgba(255, 0, 0, 0.3)' ?>">
                        <?= $profil['pfl_etat'] ?>
                    </td>
                    <td>

                        <form method="post" action="<?= site_url('/compte/gerer_etat_profil') ?>">
                            <input type="hidden" name="profil_id" value="<?= $profil['cpt_id'] ?>">
                            <button class="submit-button" type="submit" name="action" value="A">Activer</button>
                            <button class="submit-button" type="submit" name="action" value="D">Desactiver</button>
                        </form>

                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Aucun compte pour le moment</p>
<?php endif; ?>

<script>
    function activerDesactiver(action, userId) {
        // You can perform an AJAX request here to activate or deactivate the user
        // Example AJAX request:
        // $.ajax({
        //     url: '/compte/activer_desactiver',
        //     type: 'POST',
        //     data: { action: action, userId: userId },
        //     success: function (response) {
        //         // Handle the response
        //         alert(response);
        //     }
        // });
        alert('User ' + userId + ' has been ' + (action === 'A' ? 'activated' : 'deactivated'));
    }
</script>