<?php 

    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    $user_dao = new UserDAO($conn, $BASE_URL);
    $movie_dao = new MovieDAO($conn, $BASE_URL);

    $user_data = $user_dao->verifyToken(true);

    $id = filter_input(INPUT_GET, "id");

    if (empty($id)) {

        $message->setMessage("Filme não encontrado", "error", "index.php");

    } else {

        $movie = $movie_dao->findById($id);

        if (!$movie) {

            $message->setMessage("Filme não encontrado", "error", "index.php");

        }

    }

    if($movie->image == "") {

        $movie->image = "movie_cover.jpg";

    }

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-1">
                    <h1><?= $movie->title ?></h1>
                    <p class="page-description">Altere os dados do filme no formulário abaixo:</p>
                    <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="update">
                        <input type="hidden" name="id" value="<?= $movie->id ?>">
                        <div class="form-group">
                            <label for="title">Título</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do filme" value="<?= $movie->title ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Imagem:</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="length">Duracão:</label>
                            <input type="text" class="form-control" id="length" name="length" placeholder="Digite a duração do filme" value="<?= $movie->length ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Categoria:</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="Ação" <?= $movie->category === "Ação" ? "selected" : "" ?>>Ação</option>
                                <option value="Animação" <?= $movie->category === "Animação" ? "selected" : "" ?>>Animação</option>
                                <option value="Aventura" <?= $movie->category === "Aventura" ? "selected" : "" ?>>Aventura</option>
                                <option value="Comédia" <?= $movie->category === "Comédia" ? "selected" : "" ?>>Comédia</option>
                                <option value="Documentário" <?= $movie->category === "Documentário" ? "selected" : "" ?>>Documentário</option>
                                <option value="Drama" <?= $movie->category === "Drama" ? "selected" : "" ?>>Drama</option>
                                <option value="Fantasia" <?= $movie->category === "Fantasia" ? "selected" : "" ?>>Fantasia</option>
                                <option value="Ficção Científica" <?= $movie->category === "Ficção Científica" ? "selected" : "" ?>>Ficção Científica</option>
                                <option value="Musical" <?= $movie->category === "Musical" ? "selected" : "" ?>>Musical</option>
                                <option value="Romance" <?= $movie->category === "Romance" ? "selected" : "" ?>>Romance</option>
                                <option value="Suspense" <?= $movie->category === "Suspense" ? "selected" : "" ?>>Suspense</option>
                                <option value="Terror" <?= $movie->category === "Terror" ? "selected" : "" ?>>Terror</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trailer">Trailer:</label>
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer do filme" value="<?= $movie->trailer ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição:</label>
                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Digite a descrição do filme" required><?= $movie->description ?></textarea>
                        </div>
                        <input type="submit" class="btn card-btn" value="Editar filme">
                    </form>
                </div>
                <div class="col-md-3">
                    <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>
                </div>
            </div>
        </div>
    </div>

<?php 

    require_once("templates/footer.php");

?>