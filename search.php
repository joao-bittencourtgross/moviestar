<?php 

    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    $movie_dao = new MovieDAO($conn, $BASE_URL);

    $q = filter_input(INPUT_GET, "q");

    $movies = $movie_dao->findByTitle($q);

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title" id="search-title">Você está buscando por: <span id="search-result"><?= $q ?></span></h2>
        <p class="section-description">Resultados de busca retornados com base na sua pesquisa.</p>
        <div class="movies-container">
            <?php foreach ($movies as $movie) : ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if (count($movies) == 0) : ?>
                <p class="empty-list">Nenhum filme encontrado, <a href="<?= $BASE_URL ?>" class="back-link">voltar</a></p>
            <?php endif; ?>
        </div>
    </div>

<?php 

    require_once("templates/footer.php");

?>