<?php
include 'includes/conn.php';
include 'includes/functions.php';
requireRole('admin');

$message = '';
$message_type = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $role = $_POST['role'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        
        // Check if username already exists
        $check_stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check_stmt->execute([$username]);
        
        if ($check_stmt->rowCount() > 0) {
            $message = "Username already exists!";
            $message_type = "danger";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $password, $email, $role, $first_name, $last_name]);
            $message = "User added successfully!";
            $message_type = "success";
        }
    }
    
    if (isset($_POST['add_subject'])) {
        $name = $_POST['name'];
        $code = $_POST['code'];
        $description = $_POST['description'];
        
        // Check if subject code already exists
        $check_stmt = $pdo->prepare("SELECT id FROM subjects WHERE code = ?");
        $check_stmt->execute([$code]);
        
        if ($check_stmt->rowCount() > 0) {
            $message = "Subject code already exists!";
            $message_type = "danger";
        } else {
            $stmt = $pdo->prepare("INSERT INTO subjects (name, code, description) VALUES (?, ?, ?)");
            $stmt->execute([$name, $code, $description]);
            $message = "Subject added successfully!";
            $message_type = "success";
        }
    }
    
    if (isset($_POST['update_user'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        
        // Check if username already exists (excluding current user)
        $check_stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $check_stmt->execute([$username, $user_id]);
        
        if ($check_stmt->rowCount() > 0) {
            $message = "Username already exists!";
            $message_type = "danger";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, first_name = ?, last_name = ?, email = ?, role = ? WHERE id = ?");
            $stmt->execute([$username, $first_name, $last_name, $email, $role, $user_id]);
            $message = "User updated successfully!";
            $message_type = "success";
        }
    }
    
    if (isset($_POST['update_password'])) {
        $user_id = $_POST['user_id'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($new_password !== $confirm_password) {
            $message = "Passwords do not match!";
            $message_type = "danger";
        } elseif (strlen($new_password) < 6) {
            $message = "Password must be at least 6 characters long!";
            $message_type = "danger";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);
            $message = "Password updated successfully!";
            $message_type = "success";
        }
    }
    
    if (isset($_POST['update_subject'])) {
        $subject_id = $_POST['subject_id'];
        $name = $_POST['name'];
        $code = $_POST['code'];
        $description = $_POST['description'];
        
        // Check if subject code already exists (excluding current subject)
        $check_stmt = $pdo->prepare("SELECT id FROM subjects WHERE code = ? AND id != ?");
        $check_stmt->execute([$code, $subject_id]);
        
        if ($check_stmt->rowCount() > 0) {
            $message = "Subject code already exists!";
            $message_type = "danger";
        } else {
            $stmt = $pdo->prepare("UPDATE subjects SET name = ?, code = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $code, $description, $subject_id]);
            $message = "Subject updated successfully!";
            $message_type = "success";
        }
    }
}

// Handle delete actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    
    switch ($action) {
        case 'delete_user':
            $result = deleteUser($pdo, $id);
            if ($result === true) {
                $message = "User deleted successfully!";
                $message_type = "success";
            } else {
                $message = $result;
                $message_type = "danger";
            }
            break;
            
        case 'delete_subject':
            $result = deleteSubject($pdo, $id);
            if ($result === true) {
                $message = "Subject deleted successfully!";
                $message_type = "success";
            } else {
                $message = $result;
                $message_type = "danger";
            }
            break;
            
        case 'delete_classroom':
            $result = deleteClassroom($pdo, $id);
            if ($result === true) {
                $message = "Classroom deleted successfully!";
                $message_type = "success";
            } else {
                $message = $result;
                $message_type = "danger";
            }
            break;
    }
}

// Get statistics and data
$total_students = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
$total_teachers = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn();
$total_classrooms = $pdo->query("SELECT COUNT(*) FROM classrooms")->fetchColumn();
$total_subjects = $pdo->query("SELECT COUNT(*) FROM subjects")->fetchColumn();

$users = $pdo->query("SELECT * FROM users ORDER BY role, first_name")->fetchAll();
$subjects = $pdo->query("SELECT * FROM subjects ORDER BY name")->fetchAll();
$classrooms = $pdo->query("SELECT c.*, u.first_name, u.last_name 
                          FROM classrooms c 
                          LEFT JOIN users u ON c.teacher_id = u.id 
                          ORDER BY c.name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de administração - Gestão de notas dos alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            padding: 0;
        }
        .sidebar .nav-link {
            color: white;
            padding: 1rem 1.5rem;
            border-left: 4px solid transparent;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        .stat-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .password-toggle {
            cursor: pointer;
            transition: color 0.3s;
        }
        .password-toggle:hover {
            color: #667eea !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="d-flex flex-column p-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                        <h5>Gerenciamento de notas</h5>
                        <small>Painel do Administrador</small>
                    </div>
                    
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#dashboard" data-bs-toggle="tab">
                                <i class="fas fa-tachometer-alt me-2"></i>Painel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users" data-bs-toggle="tab">
                                <i class="fas fa-users me-2"></i>Gerenciar usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#subjects" data-bs-toggle="tab">
                                <i class="fas fa-book me-2"></i>Assuntos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#classrooms" data-bs-toggle="tab">
                                <i class="fas fa-chalkboard me-2"></i>Salas de aula
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-4 py-4">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="tab-content">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>Painel do Administrador</h2>
                            <span>Bem-Vindo, <?php echo $_SESSION['first_name']; ?>!</span>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card stat-card bg-primary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_students; ?></h4>
                                                <p>Total de Alunos</p>
                                            </div>
                                            <i class="fas fa-user-graduate fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stat-card bg-success text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_teachers; ?></h4>
                                                <p>Total de Professores</p>
                                            </div>
                                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stat-card bg-warning text-dark">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_classrooms; ?></h4>
                                                <p>Salas de Aula</p>
                                            </div>
                                            <i class="fas fa-chalkboard fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stat-card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4><?php echo $total_subjects; ?></h4>
                                                <p>Assuntos</p>
                                            </div>
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Usuários recentes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Papel</th>
                                                        <th>Nome de Usuário</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach(array_slice($users, 0, 5) as $user): ?>
                                                    <tr>
                                                        <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                                        <td><span class="badge bg-secondary"><?php echo $user['role']; ?></span></td>
                                                        <td><?php echo $user['username']; ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Visão Geral das Salas de Aulas</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Salas de Aula</th>
                                                        <th>Professor</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach(array_slice($classrooms, 0, 5) as $classroom): ?>
                                                    <tr>
                                                        <td><?php echo $classroom['name']; ?></td>
                                                        <td><?php echo $classroom['first_name'] . ' ' . $classroom['last_name']; ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Tab -->
                    <div class="tab-pane fade" id="users">
                        <h2 class="mb-4">Gerenciar Usuários</h2>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Adicionar um Novo Usuário</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-3" name="first_name" placeholder="First Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-3" name="last_name" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control mb-3" name="email" placeholder="Email">
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select mb-3" name="role" required>
                                                <option value="">Selecione a Função</option>
                                                <option value="admin">Administrador</option>
                                                <option value="teacher">Professor</option>
                                                <option value="student">Aluno</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control" name="password" id="new_password" placeholder="Password" required>
                                                <span class="input-group-text password-toggle" onclick="togglePassword('new_password', 'new_password_icon')">
                                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" name="add_user" class="btn btn-primary w-100">Adicionar Usuário</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Todos os Usuários</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Nome do Email</th>
                                                <th>Email</th>
                                                <th>Papel</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($users as $user): ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                                <td><?php echo $user['username']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td>
                                                    <span class="badge bg-<?php 
                                                        switch($user['role']) {
                                                            case 'admin': echo 'danger'; break;
                                                            case 'teacher': echo 'success'; break;
                                                            case 'student': echo 'primary'; break;
                                                            default: echo 'secondary';
                                                        }
                                                    ?>"><?php echo $user['role']; ?></span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" 
                                                            data-id="<?php echo $user['id']; ?>"
                                                            data-username="<?php echo $user['username']; ?>"
                                                            data-firstname="<?php echo $user['first_name']; ?>"
                                                            data-lastname="<?php echo $user['last_name']; ?>"
                                                            data-email="<?php echo $user['email']; ?>"
                                                            data-role="<?php echo $user['role']; ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                                                            data-id="<?php echo $user['id']; ?>"
                                                            data-username="<?php echo $user['username']; ?>">
                                                        <i class="fas fa-key"></i> Senha
                                                    </button>
                                                    <a href="?action=delete_user&id=<?php echo $user['id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                        <i class="fas fa-trash"></i> Deletar
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects Tab -->
                    <div class="tab-pane fade" id="subjects">
                        <h2 class="mb-4">Gerenciar Assuntos</h2>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Adicionar um Novo Assunto</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" name="name" placeholder="Subject Name" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" name="code" placeholder="Subject Code" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" name="description" placeholder="Description">
                                        </div>
                                    </div>
                                    <button type="submit" name="add_subject" class="btn btn-primary">Adicionar Assunto</button>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Todos os Assuntos</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Código</th>
                                                <th>Descrição</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($subjects as $subject): ?>
                                            <tr>
                                                <td><?php echo $subject['id']; ?></td>
                                                <td><?php echo $subject['name']; ?></td>
                                                <td><?php echo $subject['code']; ?></td>
                                                <td><?php echo $subject['description']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSubjectModal"
                                                            data-id="<?php echo $subject['id']; ?>"
                                                            data-name="<?php echo $subject['name']; ?>"
                                                            data-code="<?php echo $subject['code']; ?>"
                                                            data-description="<?php echo $subject['description']; ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <a href="?action=delete_subject&id=<?php echo $subject['id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this subject? This will also delete all grades associated with it.')">
                                                        <i class="fas fa-trash"></i> Deletar
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Classrooms Tab -->
                    <div class="tab-pane fade" id="classrooms">
                        <h2 class="mb-4">Gerenciar Salas de Aulas</h2>
                        
                        <div class="card">
                            <div class="card-header">
                                <h5>Todas as salas de Aula</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                                <th>Professor</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($classrooms as $classroom): ?>
                                            <tr>
                                                <td><?php echo $classroom['id']; ?></td>
                                                <td><?php echo $classroom['name']; ?></td>
                                                <td><?php echo $classroom['description']; ?></td>
                                                <td><?php echo $classroom['first_name'] . ' ' . $classroom['last_name']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-users"></i> View Students
                                                    </button>
                                                    <a href="?action=delete_classroom&id=<?php echo $classroom['id']; ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Are you sure you want to delete this classroom? This will also delete all grades and student associations.')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuário</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="mb-3">
                            <label class="form-label">Nome do Usuário</label>
                            <input type="text" class="form-control" name="username" id="edit_username" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sobrenome</label>
                                    <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Papel</label>
                            <select class="form-select" name="role" id="edit_role" required>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mudar Senha</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="password_user_id">
                        <div class="mb-3">
                            <label class="form-label">Nome do Usuário</label>
                            <input type="text" class="form-control" id="password_username" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nova Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="new_password" id="change_password" required>
                                <span class="input-group-text password-toggle" onclick="togglePassword('change_password', 'change_password_icon')">
                                    <i class="fas fa-eye" id="change_password_icon"></i>
                                </span>
                            </div>
                            <div class="form-text">A senha deve ter no mínimo 6 caracteres.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                                <span class="input-group-text password-toggle" onclick="togglePassword('confirm_password', 'confirm_password_icon')">
                                    <i class="fas fa-eye" id="confirm_password_icon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="update_password" class="btn btn-primary">Mudar Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Assunto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="subject_id" id="edit_subject_id">
                        <div class="mb-3">
                            <label class="form-label">Nome do Assunto</label>
                            <input type="text" class="form-control" name="name" id="edit_subject_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Código do Assunto</label>
                            <input type="text" class="form-control" name="code" id="edit_subject_code" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <input type="text" class="form-control" name="description" id="edit_subject_description">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="update_subject" class="btn btn-primary">Atualizar Assunto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activate tab from URL hash
        document.addEventListener('DOMContentLoaded', function() {
            var triggerTabList = [].slice.call(document.querySelectorAll('a[data-bs-toggle="tab"]'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            });

            // Edit User Modal
            var editUserModal = document.getElementById('editUserModal')
            editUserModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                var userId = button.getAttribute('data-id')
                var username = button.getAttribute('data-username')
                var firstName = button.getAttribute('data-firstname')
                var lastName = button.getAttribute('data-lastname')
                var email = button.getAttribute('data-email')
                var role = button.getAttribute('data-role')
                
                var modal = this
                modal.querySelector('#edit_user_id').value = userId
                modal.querySelector('#edit_username').value = username
                modal.querySelector('#edit_first_name').value = firstName
                modal.querySelector('#edit_last_name').value = lastName
                modal.querySelector('#edit_email').value = email
                modal.querySelector('#edit_role').value = role
            })

            // Change Password Modal
            var changePasswordModal = document.getElementById('changePasswordModal')
            changePasswordModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                var userId = button.getAttribute('data-id')
                var username = button.getAttribute('data-username')
                
                var modal = this
                modal.querySelector('#password_user_id').value = userId
                modal.querySelector('#password_username').value = username
            })

            // Edit Subject Modal
            var editSubjectModal = document.getElementById('editSubjectModal')
            editSubjectModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget
                var subjectId = button.getAttribute('data-id')
                var name = button.getAttribute('data-name')
                var code = button.getAttribute('data-code')
                var description = button.getAttribute('data-description')
                
                var modal = this
                modal.querySelector('#edit_subject_id').value = subjectId
                modal.querySelector('#edit_subject_name').value = name
                modal.querySelector('#edit_subject_code').value = code
                modal.querySelector('#edit_subject_description').value = description
            })
        });

        // Password toggle functionality
        function togglePassword(passwordFieldId, iconId) {
            var passwordField = document.getElementById(passwordFieldId);
            var icon = document.getElementById(iconId);
            
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Password strength indicator (optional enhancement)
        function checkPasswordStrength(password) {
            var strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;
            
            return strength;
        }
    </script>
</body>
</html>