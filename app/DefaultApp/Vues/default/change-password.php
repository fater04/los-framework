<?php
/**
 * change-password.php
 * project gestion
 * user fater04
 * created at 1/27/2022 - 9:42 AM
 */
?>
<div class="col-lg-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title">
                <h4 class="card-title">Modifier mot de passe</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="new-user-info">
                <form method="post" >
                    <div class="row ">
                        <div class="form-group col-md-12">
                            <label for="pass">Ancien mot de passe :</label>
                            <input type="password" class="form-control"  name="password0" placeholder="ancien mot de passe" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="pass">Nouveau mot de passe :</label>
                            <input type="password" class="form-control"  name="password1" placeholder="nouveau mot de passe" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="rpass">Confirmer nouveau mot de passe :</label>
                            <input type="password" class="form-control"  name="password2" placeholder="confirmer mot de passe " required>
                        </div>
                    </div>
                    <div class="card-footer pt-4">
                    <input type="submit" value="Modifier" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
