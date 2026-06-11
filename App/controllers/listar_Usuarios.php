<?php
require_once '../config/database.php';

// Consulta os usuários
$stmt = $pdo->query("SELECT id, email, data_criacao FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>E-mail</th>
        <th>Data de Criação</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?php echo $usuario['id']; ?></td>
            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
            <td><?php echo $usuario['data_criacao']; ?></td>
            <td>
                <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a> |
                <a href="deletar_usuario.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>