<?php
/**
 * datatables.php
 * courrier
 * @author : fater04
 * @created :  14:43 - 2024-08-29
 **/
require_once '../../../vendor/autoload.php';
$pdo = \app\DefaultApp\DefaultApp::connection();
if (isset($_GET['users'])) {
    function get_total_all_records($connection)
    {
        $req = "SELECT * FROM utilisateur  ";
        $statement = $connection->prepare($req);
        $statement->execute();
        return $statement->rowCount();
    }

    $query = '';
    $output = array();
    $query .= "SELECT * FROM utilisateur  ";
    if (isset($_POST["search"]["value"])) {
        $query .= 'where id LIKE "%' . $_POST["search"]["value"] . '%" ';
    }
    if (isset($_POST["order"])) {
        $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $query .= 'ORDER BY id DESC ';
    }

    if ($_POST["length"] != -1) {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
    $option = '';
    foreach ($result as $row) {
        $i = $row['statut'];
        if ($i == 'oui') {
            $i = 'Debloquer';
            $option = '<a href="javascript:void(0)" data-toggle="tooltip"
                                               title="Bloquer Utilisateur" id="bloker_user' . $row['id'] . '" data-id="' . $row['id'] . '"
                                               class="btn btn-outline-primary">
                                                <i class="fa fa-lock"></i>';
        } else {
            $i = 'Bloquer';
            $option = ' <a href="javascript:void(0)" data-toggle="tooltip"
                                               title="Debloquer Utilisateur" id="debloker_user' . $row['id'] . '" data-id="' . $row['id'] . '"
                                               class="btn btn-outline-primary">
                                                <i class="fa fa-unlock"></i>
                                            </a>';
        }
        $sub_array = array();
        $sub_array[] = $row['pseudo'];
        $sub_array[] = $row['email'];
        $sub_array[] = $row['nom'];
        $sub_array[] = $row['role'];
        $sub_array[] = $i;
        $sub_array[] = $row['derniere_connection'];
        $sub_array[] = '       <div class="btn-group btn-group-toggle btn-group-flat">
                                        <a href="javascript:void(0)" data-toggle="modal"
                                           data-target="#bd-example-modal-lg' . $row['id'] . '"
                                           data-toggle="tooltip" title="Modifier Utilisateur"
                                           class="btn btn-outline-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>' . $option . '
                                        <a href="javascript:void(0)"
                                           data-toggle="tooltip" id="delete_utilisateur' . $row['id'] . '" data-id="' . $row['id'] . '"
                                           title="Suprimer Utilisateur" class="btn btn-outline-primary">
                                            <i class="fa fa-trash"></i>
                                        </a>
  <div class="modal fade " id="bd-example-modal-lg' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_modifier_utilisateur' . $row['id'] . '">
                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>Nom Complet</label>
                            <input type="text" class="form-control" name="nomcomplet"
                                   value="'.$row['nom'].'" required>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="'.$row['email'].'"
                                   required>
                        </div>
                    </div>
                    <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Pseudo</label>
                            <input type="text" class="form-control" value="'.$row['pseudo'].'"  name="pseudo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-default">
                            <label>Telephone</label>
                            <input type="text" class="form-control" value="'.$row['telephone'].'"  name="telephone">
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-group-default">
                            <label>role</label>
                            <select class="form-control" name="role" required>
                                <option value="'.$row['role'].'" hidden selected>'.$row['role'].'</option>
                                <option value="admin" >Admin</option>
                                <option value="secretaire" >Secretaire</option>

                            </select>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="id" value="'.$row['id'].'"/>
                        <input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
                        <button type="submit" class="btn  btn-primary">Modifier</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
                              
<script>  
$("#delete_utilisateur' . $row['id'] . '").on("click", (function (e) { 
         Swal.fire({
             icon: "question",
            title: "Voulez-vous supprimer  cet utilisateur ?",
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "OUI",
            showCancelButton: true,
            cancelButtonText: "NON"
        }).then((result) => {
            if (result.isConfirmed) {
              $("#ajax-loading").show();
            const id = $(this).data("id");
                 e.preventDefault();
                 $.ajax({
            url: "app/DefaultApp/traitements/traitements.php?delete_user=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
              $("#ajax-loading").hide();
                Swal.fire({
                    icon: "info",
                    title: data,
                     allowOutsideClick: false, 
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#list_users").DataTable().ajax.reload();
            }
        });
            } 
            else if (result.isDismissed) {
                 window.close();
            }
        }); })); 
$("#bloker_user' . $row['id'] . '").on("click", (function (e) { 
         Swal.fire({
             icon: "question",
            title: "Voulez-vous Bloquer  cet utilisateur ?",
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "OUI",
            showCancelButton: true,
            cancelButtonText: "NON"
        }).then((result) => {
            if (result.isConfirmed) {
              $("#ajax-loading").show();
            const id = $(this).data("id");
                 e.preventDefault();
                 $.ajax({
            url: "app/DefaultApp/traitements/traitements.php?bloker_user=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
             $("#ajax-loading").hide();
                Swal.fire({
                    icon: "info",
                    title: data,
                     allowOutsideClick: false, 
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#list_users").DataTable().ajax.reload();
            }
        });
            } 
            else if (result.isDismissed) {
                 window.close();
            }
        }); })); 
$("#debloker_user' . $row['id'] . '").on("click", (function (e) { 
         Swal.fire({
             icon: "question",
            title: "Voulez-vous Debloquer  cet utilisateur ?",
            allowOutsideClick: false,
            showConfirmButton: true,
            confirmButtonText: "OUI",
            showCancelButton: true,
            cancelButtonText: "NON"
        }).then((result) => {
            if (result.isConfirmed) {
              $("#ajax-loading").show();
            const id = $(this).data("id");
                 e.preventDefault();
                 $.ajax({
            url: "app/DefaultApp/traitements/traitements.php?debloker_user=" + id,
            type: "GET",
            data: "",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
       $("#ajax-loading").hide();
                Swal.fire({
                    icon: "info",
                    title: data,
                     allowOutsideClick: false, 
                    showConfirmButton: false,
                    timer: 1500
                });
                $("#list_users").DataTable().ajax.reload();
            }
        });
            } 
            else if (result.isDismissed) {
                 window.close();
            }
        }); })); 
$("#form_modifier_utilisateur' . $row['id'] . '").submit(function (e) {
     $("#ajax-loading").show();
        e.preventDefault();
       var formData = new FormData(this);
        $.ajax({
            type: "POST",
                    url: "app/DefaultApp/traitements/traitements.php?modifier_utilisateur",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
            $("#ajax-loading").hide();
            var obj = $.parseJSON(data);
            if (obj.status === "ok") {
                Swal.fire({
                        icon: "success",
                        title: obj.message,
                         allowOutsideClick: false, 
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $("#form_modifier_utilisateur' . $row['id'] . '")[0].reset();
                    $("#bd-example-modal-lg' . $row['id'] . '").modal("toggle");
                   $("#list_users").DataTable().ajax.reload();
                }
        }
        });

    });
    </script>';
        $data[] = $sub_array;
    }
    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => get_total_all_records($pdo),
        "data" => $data
    );
    echo json_encode($output);

}