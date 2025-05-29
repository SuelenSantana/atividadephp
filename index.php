<?php
include_once 'Database.php';
include_once 'Pet.php';
include_once 'Procedure.php';

$database = new Database();
$db = $database->getConnection();

$pet = new Pet($db);
$procedure = new Procedure($db);

// Processar formulários
if($_POST){
    // Cadastrar Pet
    if(isset($_POST['add_pet'])){
        $pet->name = $_POST['name'];
        $pet->species = $_POST['species'];
        $pet->breed = $_POST['breed'];
        $pet->birth_date = $_POST['birth_date'];
        $pet->owner_name = $_POST['owner_name'];
        $pet->owner_phone = $_POST['owner_phone'];
        $pet->create();
    }
    // Atualizar Pet
    elseif(isset($_POST['update_pet'])){
        // Código aqui
    }
    // Excluir Pet
    elseif(isset($_POST['delete_pet'])){
        $pet->id = $_POST['id'];
        $pet->delete();
    }
    // Cadastrar Procedimento
    elseif(isset($_POST['add_procedure'])){
       // Código aqui
    }
    // Atualizar Procedimento
    elseif(isset($_POST['update_procedure'])){
        $procedure->id = $_POST['procedure_id'];
        $procedure->procedure_name = $_POST['procedure_name'];
        $procedure->procedure_date = $_POST['procedure_date'];
        $procedure->description = $_POST['description'];
        $procedure->veterinarian = $_POST['veterinarian'];
        $procedure->update();
    }
    // Excluir Procedimento
    elseif(isset($_POST['delete_procedure'])){
        // Código aqui
    }
}

$pets = $pet->read();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clínica Veterinária Animal Care</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header { background-color:green; color: white; padding: 20px; }
        .procedure-table { margin-top: 20px; background-color: #f8f9fa; padding: 15px; border-radius: 5px; }
        .card-header h5 { margin-bottom: 0; }
    </style>
</head>
<body>
    <div class="header text-center">
        <h1>Clínica Veterinária</h1>
    </div>

    <div class="container mt-5">
        <!-- Formulário para Adicionar Pet -->
        <div class="card mb-4">
            <div class="card-header text-white" style="background-color: green;">
                <h5>Cadastrar Novo Pet</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Nome do Pet" required>
                        </div>
                        <div class="col-md-3">
                            <select name="species" class="form-select" required>
                                <option value="">Espécie</option>
                                <option value="Cão">Cão</option>
                                <option value="Gato">Gato</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="breed" class="form-control" placeholder="Raça">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="birth_date" class="form-control" placeholder="Data Nascimento">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="owner_name" class="form-control" placeholder="Nome do Dono" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="owner_phone" class="form-control" placeholder="Telefone" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="add_pet" class="btn btn-success" style="background-color: green;">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Pets e Procedimentos -->
        <?php while ($row = $pets->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5><?php echo $row['name']; ?> (<?php echo $row['species']; ?>)</h5>
                            <p>Dono: <?php echo $row['owner_name']; ?> - Tel: <?php echo $row['owner_phone']; ?></p>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-warning edit-pet" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editPetModal"
                                    data-id="<?php echo $row['id']; ?>"
                                    data-name="<?php echo $row['name']; ?>"
                                    data-species="<?php echo $row['species']; ?>"
                                    data-breed="<?php echo $row['breed']; ?>"
                                    data-birth_date="<?php echo $row['birth_date']; ?>"
                                    data-owner_name="<?php echo $row['owner_name']; ?>"
                                    data-owner_phone="<?php echo $row['owner_phone']; ?>">
                                Editar
                            </button>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_pet" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Tem certeza que deseja excluir este pet e todos seus procedimentos?')">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Formulário para Adicionar Procedimento -->
                    <form method="post" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="hidden" name="pet_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="procedure_name" class="form-control" placeholder="Procedimento" required>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="procedure_date" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="veterinarian" class="form-control" placeholder="Veterinário" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="description" class="form-control" placeholder="Descrição">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" name="add_procedure" class="btn btn-primary">+</button>
                            </div>
                        </div>
                    </form>

                    <!-- Lista de Procedimentos -->
                    <?php 
                    $procedures = $procedure->readByPet($row['id']);
                    if($procedures->rowCount() > 0): ?>
                        <div class="procedure-table">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Procedimento</th>
                                        <th>Descrição</th>
                                        <th>Veterinário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($proc = $procedures->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y', strtotime($proc['procedure_date'])); ?></td>
                                            <td><?php echo $proc['procedure_name']; ?></td>
                                            <td><?php echo $proc['description']; ?></td>
                                            <td><?php echo $proc['veterinarian']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-procedure"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editProcedureModal"
                                                        data-id="<?php echo $proc['id']; ?>"
                                                        data-name="<?php echo $proc['procedure_name']; ?>"
                                                        data-date="<?php echo $proc['procedure_date']; ?>"
                                                        data-vet="<?php echo $proc['veterinarian']; ?>"
                                                        data-desc="<?php echo $proc['description']; ?>">
                                                    Editar
                                                </button>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="procedure_id" value="<?php echo $proc['id']; ?>">
                                                    <button type="submit" name="delete_procedure" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Tem certeza que deseja excluir este procedimento?')">
                                                        Excluir
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Modais -->
        <!-- Modal Editar Pet -->
        <div class="modal fade" id="editPetModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Pet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_pet_id">
                            <div class="mb-3">
                                <input type="text" name="name" id="edit_name" class="form-control" placeholder="Nome" required>
                            </div>
                            <div class="mb-3">
                                <select name="species" id="edit_species" class="form-select" required>
                                    <option value="Cão">Cão</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="breed" id="edit_breed" class="form-control" placeholder="Raça">
                            </div>
                            <div class="mb-3">
                                <input type="date" name="birth_date" id="edit_birth_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="owner_name" id="edit_owner_name" class="form-control" placeholder="Dono" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="owner_phone" id="edit_owner_phone" class="form-control" placeholder="Telefone" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="update_pet" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Procedimento -->
        <div class="modal fade" id="editProcedureModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Procedimento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <input type="hidden" name="procedure_id" id="edit_procedure_id">
                            <div class="mb-3">
                                <input type="text" name="procedure_name" id="edit_procedure_name" class="form-control" placeholder="Procedimento" required>
                            </div>
                            <div class="mb-3">
                                <input type="date" name="procedure_date" id="edit_procedure_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="veterinarian" id="edit_veterinarian" class="form-control" placeholder="Veterinário" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="description" id="edit_description" class="form-control" placeholder="Descrição"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="update_procedure" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preencher modal de edição de pet
        document.querySelectorAll('.edit-pet').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('edit_pet_id').value = button.dataset.id;
                document.getElementById('edit_name').value = button.dataset.name;
                document.getElementById('edit_species').value = button.dataset.species;
                document.getElementById('edit_breed').value = button.dataset.breed;
                document.getElementById('edit_birth_date').value = button.dataset.birth_date;
                document.getElementById('edit_owner_name').value = button.dataset.owner_name;
                document.getElementById('edit_owner_phone').value = button.dataset.owner_phone;
            });
        });

        // Preencher modal de edição de procedimento
        document.querySelectorAll('.edit-procedure').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('edit_procedure_id').value = button.dataset.id;
                document.getElementById('edit_procedure_name').value = button.dataset.name;
                document.getElementById('edit_procedure_date').value = button.dataset.date;
                document.getElementById('edit_veterinarian').value = button.dataset.vet;
                document.getElementById('edit_description').value = button.dataset.desc;
            });
        });
    </script>
</body>
</html>