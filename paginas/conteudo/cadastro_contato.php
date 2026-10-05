<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cadastro de Contatos</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cadastrar contato</h3>
                        </div>

                        <!-- form start -->
                        <form role="form" action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="nome" required placeholder="Digite o nome de contato">
                                </div>

                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control" name="telefone" id="telefone" required placeholder="(00) 00000-0000">
                                </div>

                                <div class="form-group">
                                    <label for="email">Endereço de E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email" required placeholder="Digite um e-mail">
                                </div>

                                <div class="form-group">
                                    <label for="foto">Foto do contato</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto" id="foto">
                                            <label class="custom-file-label" for="foto">Arquivo de imagem</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user ?>">

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                    <label class="form-check-label" for="exampleCheck1">Autorizo o cadastro do meu contato</label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" name="botao" class="btn btn-primary">Cadastrar Contato</button>
                            </div>
                        </form>

                        <?php
                        // Inclui o arquivo de conexão com o banco de dados
                        include('../config/conexao.php');

                        if (isset($_POST['botao'])) {
                            $nome       = $_POST['nome'];
                            $telefone   = $_POST['telefone'];
                            $email      = $_POST['email'];
                            $id_usuario = $_POST['id_user'];

                            $formatP = ["png", "jpg", "jpeg", "JPG", "gif"];

                            if (isset($_FILES['foto'])) {
                                $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

                                if (in_array($extensao, $formatP)) {
                                    $pasta      = "../img/cont/";
                                    $temporario = $_FILES['foto']['tmp_name'];
                                    $novoNome   = uniqid() . ".$extensao";

                                    if (move_uploaded_file($temporario, $pasta . $novoNome)) {
                                        $foto = $novoNome;
                                    } else {
                                        echo "Erro, não foi possível fazer o upload do arquivo!";
                                        $foto = 'avatar_padrao.png';
                                    }
                                } else {
                                    echo "Formato Inválido";
                                    $foto = 'avatar-padrao.png';
                                }
                            } else {
                                $foto = 'avatar_padrao.png';
                            }

                            $cadastro = "INSERT INTO tb_contatos 
                                         (nome_contatos, fone_contatos, email_contatos, foto_contatos, id_user) 
                                         VALUES (:nome, :telefone, :email, :foto, :id_user)";

                            try {
                                $result = $conect->prepare($cadastro);
                                $result->bindParam(':nome', $nome, PDO::PARAM_STR);
                                $result->bindParam(':telefone', $telefone, PDO::PARAM_STR);
                                $result->bindParam(':email', $email, PDO::PARAM_STR);
                                $result->bindParam(':foto', $foto, PDO::PARAM_STR);
                                $result->bindParam(':id_user', $id_usuario, PDO::PARAM_INT);
                                $result->execute();

                                if ($result->rowCount() > 0) {
                                    echo '<div class="container">
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-check"></i> OK!</h5>
                                                Dados inseridos com sucesso !!!
                                            </div>
                                          </div>';

                                    header("Refresh: 5, home.php");
                                } else {
                                    echo '<div class="container">
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                                Dados não inseridos !!!
                                            </div>
                                          </div>';

                                    header("Refresh: 5, home.php");
                                }
                            } catch (PDOException $e) {
                                echo "<strong>ERRO DE PDO = </strong>" . $e->getMessage();
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- right column -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contatos Recentes</h3>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>E-mail</th>
                                        <th style="width: 40px">Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    // Consulta SQL limitando aos últimos 6 contatos do usuário
                                    $select = "SELECT * FROM tb_contatos 
                                               WHERE id_user = :id_user 
                                               ORDER BY id_contatos DESC 
                                               LIMIT 6";

                                    try {
                                        $result = $conect->prepare($select);
                                        $cont = 1;

                                        $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                                        $result->execute();

                                        if ($result->rowCount() > 0) {

                                            while ($show = $result->fetch(PDO::FETCH_OBJ)) {

                                                $fotoContato = !empty($show->foto_contatos)
                                                    ? $show->foto_contatos
                                                    : 'avatar_padrao.png';
                                    ?>

                                                <tr>
                                                    <td><?php echo $cont++; ?></td>

                                                    <td>
                                                        <?php echo $show->nome_contatos; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $show->fone_contatos; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $show->email_contatos; ?>
                                                    </td>

                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="home.php?acao=editar&id=<?php echo $show->id_contatos; ?>"
                                                               class="btn btn-success"
                                                               title="Editar Contato">
                                                                <i class="fas fa-user-edit"></i>
                                                            </a>

                                                            <a href="conteudo/del-contato.php?idDel=<?php echo $show->id_contatos; ?>"
                                                               onclick="return confirm('Deseja remover o contato')"
                                                               class="btn btn-danger"
                                                               title="Remover Contato">
                                                                <i class="fas fa-user-times"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>

                                    <?php
                                            }

                                        } else {
                                    ?>

                                            <tr>
                                                <td colspan="5" class="text-center py-3 text-muted">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Nenhum contato cadastrado no momento.
                                                </td>
                                            </tr>

                                    <?php
                                        }

                                    } catch (PDOException $e) {
                                    ?>

                                        <tr>
                                            <td colspan="5" class="text-center py-3 text-danger">
                                                <strong>ERRO DE PDO:</strong>
                                                <?php echo $e->getMessage(); ?>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<!-- /.content-wrapper -->
