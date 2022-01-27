<?php
/**
 * change-password.php
 * project gestion
 * user fater04
 * created at 1/27/2022 - 9:42 AM
 */
?>
<div class="col-lg-9">
    <div class="iq-card">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title">Modifier mot de passe</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <div class="new-user-info">
                <form method="post" action="" >
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pass">Nouveau mot de passe :</label>
                            <input type="password" class="form-control"  name="password1" placeholder="nouveau mot de passe" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rpass">Confirmer nouveau mot de passe :</label>
                            <input type="password" class="form-control"  name="password2" placeholder="confirmer mot de passe " required>
                        </div>
                    </div>
                    <input type="hidden"  name="id" value="<?=$id?>"/>
                    <input type="submit" value="Modifier" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
