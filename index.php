<?php 

    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    $movie_dao = new MovieDAO($conn, $BASE_URL);

    $latest_movies = $movie_dao->getLatestMovies();

    $action_movies = $movie_dao->getMoviesCategory("Ação");

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Filmes novos</h2>
        <p class="section-description">Veja os últimos filmes adicionados no MovieStar</p>
        <div class="movies-container">
            <?php foreach ($latest_movies as $movie) : ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if (count($latest_movies) == 0) : ?>
                <p class="empty-list">Nenhum filme encontrado.</p>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja os melhores filmes de ação</p>
        <div class="movies-container">
            <?php foreach ($action_movies as $movie) : ?>
                <?php require("templates/movie_card.php") ?>
            <?php endforeach; ?>
            <?php if (count($action_movies) == 0) : ?>
                <p class="empty-list">Nenhum filme encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

<?php 

    require_once("templates/footer.php");

?>
    