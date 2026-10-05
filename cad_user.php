<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>New Agenda 2.0 | Cadastro de Usuário</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="cad_user.php" style="font-size: 25px"><b>Cadastre-se para ter acesso</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Cadastre todos os dados para ter acesso a agenda</p>

      <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="exampleInputFile">Foto do usuário</label>
        <div class="input-group">
            <div class="custom-file">
            <input type="file" class="custom-file-input" name="foto" id="foto">
            <label class="custom-file-label" for="exampleInputFile">Arquivo de imagem</label>
            </div>
            
            <?php

require_once __DIR__ . '/config/conexao.php';

if (isset($_POST['botao'])) {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Preencha todos os campos.";
        exit;
    }

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Foto padrão
    $foto = 'avatar_padrao.png';

    // Pasta das fotos
    $pasta = __DIR__ . '/img/';

    // Cria a pasta se não existir
    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }

    // Verifica se enviou foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {

        $imagem = getimagesize($_FILES['foto']['tmp_name']);

        if ($imagem === false) {
            echo "O arquivo não é uma imagem válida.";
            exit;
        }

        $tipos = array(
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif'
        );

        if (!isset($tipos[$imagem['mime']])) {
            echo "Formato de imagem inválido.";
            exit;
        }

        $extensao = $tipos[$imagem['mime']];

        $novoNome = uniqid() . '.' . $extensao;

        if (move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            $pasta . $novoNome
        )) {
            $foto = $novoNome;
        } else {
            echo "Não foi possível salvar a foto.";
            exit;
        }
    }

    // Verifica se o e-mail já existe
    $consulta = $conect->prepare(
        "SELECT id_user FROM tb_user WHERE email_user = :email"
    );

    $consulta->bindValue(':email', $email, PDO::PARAM_STR);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        echo "Este e-mail já está cadastrado.";
        exit;
    }

    // Cadastra o usuário
    $sql = "INSERT INTO tb_user
            (foto_user, nome_user, email_user, senha_user)
            VALUES
            (:foto, :nome, :email, :senha)";

    try {

        $result = $conect->prepare($sql);

        $result->bindValue(':foto', $foto, PDO::PARAM_STR);
        $result->bindValue(':nome', $nome, PDO::PARAM_STR);
        $result->bindValue(':email', $email, PDO::PARAM_STR);
        $result->bindValue(':senha', $senha_hash, PDO::PARAM_STR);

        $result->execute();

        echo "Cadastro realizado com sucesso!";

        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000);
              </script>';

    } catch (PDOException $e) {

        echo "Erro ao cadastrar usuário.";
        echo "<br>";
        echo $e->getMessage();
    }
}
?>
            

        </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="nome" class="form-control" placeholder="Digite seu Nome..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Digite seu E-mail..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="senha" class="form-control" placeholder="Digite sua Senha..." required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-12" style="margin-bottom: 25px">
            <button type="submit" name="botao" class="btn btn-primary btn-block">Finalizar Cadastro</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      
     
      <!-- /.social-auth-links -->

      
      <p style="text-align: center;">
        <a href="index.php" class="text-center">Voltar para o Login!</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
