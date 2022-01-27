<?php
/**
 * utilisateur.php
 * project los-framework
 * user fater04
 * created at 1/27/2022 - 10:31 AM
 */

use systeme\Model\Utilisateur;

?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="float-start">Liste des utilisateurs</h3>
            <button class="btn btn-primary btn-round ml-auto float-end " data-bs-toggle="modal"
                    data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">
                <i class="fa fa-plus"></i>
                Ajouter un utilisateur
            </button>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr class="table-primary">
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Nom Complet</th>
                        <th>Role</th>
                        <th>Statut</th>
                        <th>Last_login</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if (isset($listeutilisateur)) {
                        foreach ($listeutilisateur as $user1) {
                            ?>
                            <tr>
                                <td><?= $user1->getPseudo(); ?></td>
                                <td><?= $user1->getEmail(); ?></td>
                                <td><?= $user1->getNom(); ?>&nbsp;<?= $user1->getPrenom(); ?></td>
                                <td><?= Utilisateur::getRoleById($user1->getId()) ?></td>
                                <td><?php $i = $user1->getStatut();
                                    if ($i == '0') {
                                        echo 'Debloquer';
                                    } else {
                                        echo 'Bloquer';
                                    } ?></td>
                                <td><?= $user1->getDerniereConnection() ?></td>
                                <td class="small">
                                    <div class="btn-group btn-group-toggle btn-group-flat">
                                        <a href="" data-bs-toggle="modal"
                                           data-bs-target="#exampleModal<?=$user1->getId()?>" data-bs-whatever="@getbootstrap"
                                           data-toggle="tooltip" title="Modifier Utilisateur"
                                           class="button btn button-icon bg-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="utilisateur&id=<?= $user1->getId() ?>" data-toggle="tooltip"
                                           title="Suprimer Utilisateur" class="button btn button-icon bg-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php
                                        if ($i == '0') { ?>
                                            <a href="utilisateur&id=<?= $user1->getId() ?>&bq" data-toggle="tooltip"
                                               title="Bloquer Utilisateur"
                                               class="button btn button-icon bg-warning">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a href="utilisateur&id=<?= $user1->getId() ?>&dbq" data-toggle="tooltip"
                                               title="Debloquer Utilisateur"
                                               class="button btn button-icon bg-warning">
                                                <i class="fa fa-unlock"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </td>
                                <div class="modal fade" id="exampleModal<?=$user1->getId()?>" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modifier Utilisateur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Nom Complet</label>
                                                            <input type="text" class="form-control" name="nomcomplet"
                                                                   placeholder="entrez nom complet" value="<?=$user1->getNom()?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" value="<?=$user1->getEmail()?>"
                                                                   name="email" placeholder="entrez email"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group form-group-default">
                                                            <label>role</label>
                                                            <select class="form-control" name="role" required>
                                                                <option value="<?= $user1->getRole(); ?>"
                                                                        aria-hidden="true"
                                                                        aria-selected=""><?= \systeme\Model\Utilisateur::getRoleById($user1->getId()); ?></option>
                                                                <?= \systeme\Model\Utilisateur::createRoles() ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-default">
                                                            <label>Pseudo</label>
                                                            <input type="text" value="<?=$user1->getPseudo()?>"  class="form-control" placeholder="entrez pseudo" name="pseudo">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 pr-0">
                                                            <div class="form-group form-group-default">
                                                                <label>Password</label>
                                                                <input type="password" class="form-control" value="0000000000" name="password" placeholder="Password"
                                                                       required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 pr-0">
                                                            <div class="form-group form-group-default">
                                                                <label>Confirm-Password</label>
                                                                <input type="password" class="form-control" value="0000000000" name="password2" placeholder="Password"
                                                                       required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="edit-user"/>
                                                        <input type="hidden" name="user_id" value="<?= $user1->getId(); ?>"/>
                                                        <input type="hidden" name="old_role"   value="<?= $user1->getRole(); ?>"/>
                                                        <button type="submit" class="btn  btn-primary">Send message</button>
                                                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>

                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </tr>

                        <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter Utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>Nom Complet</label>
                            <input type="text" class="form-control" name="nomcomplet"
                                   placeholder="entrez nom complet" required>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="entrez email"
                                   required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>role</label>
                            <select class="form-control" name="role" required>
                                <option value="" hidden selected>choisir role</option>
                                <?= Utilisateur::createRoles() ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label>Pseudo</label>
                            <input type="text" class="form-control" placeholder="entrez pseudo" name="pseudo">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-0">
                            <div class="form-group form-group-default">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0">
                            <div class="form-group form-group-default">
                                <label>Confirm-Password</label>
                                <input type="password" class="form-control" name="password2" placeholder="Password"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="add-user"/>
                        <button type="submit" class="btn  btn-primary">Send message</button>
                        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
