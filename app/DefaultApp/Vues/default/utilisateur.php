<?php
/**
 * utilisateur.php
 * project los-framework
 * user fater04
 * created at 1/27/2022 - 10:31 AM
 */
use systeme\Model\Utilisateur;
?>

<header class="page-title-bar">
    <div class="d-flex flex-column flex-md-row">
        <h3 class="float-start">Liste des utilisateurs</h3>
        <div class="ml-auto">
            <button class="btn btn-outline-primary btn-round ml-auto float-end "  type="button"  data-toggle="modal" data-target="#exampleModal" >
                <i class="fa fa-plus"></i>
                Ajouter un utilisateur
            </button>
        </div>
    </div>
</header>

<div class="col-md-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">

                <table id="list_users" class="table table-hover" style="width:100%">
                    <thead>
                    <tr class="bg-primary text-white">
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Nom Complet</th>
                        <th>Role</th>
                        <th>Statut</th>
                        <th>Derniere connection</th>
                        <th>action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_ajouter_utilisateur">
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
                    <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Pseudo</label>
                            <input type="text" class="form-control"  name="pseudo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Telephone</label>
                            <input type="text" class="form-control"  name="telephone">
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>role</label>
                            <select class="form-control" name="role" required>
                                <option value="" hidden selected>choisir role</option>
                                <option value="admin" >Admin</option>
                                <option value="secretaire" >Secretaire</option>

                            </select>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="add-user"/>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <button type="submit" class="btn  btn-primary">Enregistrer</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


