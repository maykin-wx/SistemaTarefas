<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['adicionar'])) {
        if (!empty($_POST['data']) && !empty($_POST['descricao'])) {
            $tarefa = [
                'data' => $_POST['data'],
                'descricao' => $_POST['descricao']
            ];

            if (!isset($_SESSION['tarefas'])) {
                $_SESSION['tarefas'] = [];
            }

            $_SESSION['tarefas'][] = $tarefa;
        }
    }

    if (isset($_POST['destruir_session'])) {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']); // Redireciona para recarregar a página após destruir a sessão
        exit;
    }

    if (isset($_POST['excluir_tarefa'])) {
        $indice = $_POST['indice'];
        unset($_SESSION['tarefas'][$indice]);
        $_SESSION['tarefas'] = array_values($_SESSION['tarefas']); // Reindexa o array
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarefas</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
          crossorigin="anonymous" defer></script>
</head>
<body class="bg-light">

  <div class="container d-flex justify-content-center align-items-center min-vh-100 mt-5">
    <div class="card shadow-sm p-4 border-0 w-100" style="max-width: 800px;">
      
      <header class="bg-info text-white p-4 text-center">
        <h2>Página de Tarefas</h2>
      </header>

      <div class="p-4">
        <form method="POST">
          <div class="form-group">
            <label for="data">Data:</label>
            <input type="date" class="form-control" id="data" name="data" required>
          </div>
          <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
          </div>
          <button type="submit" name="adicionar" class="btn btn-info btn-block">Adicionar Tarefa</button>
        </form>
      </div>

      <div class="p-4">
        <h3>Tarefas Cadastradas</h3>
        <?php if (isset($_SESSION['tarefas']) && count($_SESSION['tarefas']) > 0): ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($_SESSION['tarefas'] as $index => $tarefa): ?>
                <tr>
                  <td><?php echo htmlspecialchars($tarefa['data']); ?></td>
                  <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                  <td>
                    <form method="POST" style="display:inline;">
                      <input type="hidden" name="indice" value="<?php echo $index; ?>">
                      <button type="submit" name="excluir_tarefa" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p class="text-muted">Nenhuma tarefa cadastrada ainda.</p>
        <?php endif; ?>
      </div>

      <div class="p-4">
        <form method="POST">
          <button type="submit" name="destruir_session" class="btn btn-dark btn-block">Apagar todas as tarefas</button>
        </form>
      </div>

    </div>
  </div>

</body>
</html>