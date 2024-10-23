<?php 

    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");

    $user = new User();
    $user_dao = new UserDAO($conn, $BASE_URL);

    $user_data = $user_dao->verifyToken(true);

?>

    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h1 class="page-title">Adicionar filme</h1>
            <p class="page-description">Adicione o filme e sua crítica e compartilhe com o mundo!</p>
            <form action="<?= $BASE_URL ?>movie_process.php" method="POST" id="add-movie-form" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do filme" required>
                </div>
                <div class="form-group">
                    <label for="image">Imagem:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="length">Duracão:</label>
                    <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração do filme" required>
                </div>
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Animação">Animação</option>
                        <option value="Aventura">Aventura</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Documentário">Documentário</option>
                        <option value="Drama">Drama</option>
                        <option value="Fantasia">Fantasia</option>
                        <option value="Ficção Científica">Ficção Científica</option>
                        <option value="Musical">Musical</option>
                        <option value="Romance">Romance</option>
                        <option value="Suspense">Suspense</option>
                        <option value="Terror">Terror</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trailer">Trailer:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer do filme" required>
                </div>
                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Digite a descrição do filme" required></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar filme">
            </form>
        </div>
    </div>

<?php 

    require_once("templates/footer.php");

?>
    