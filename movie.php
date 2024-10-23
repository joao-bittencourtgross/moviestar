<?php 

    require_once("templates/header.php");
    require_once("models/Movie.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    $id = filter_input(INPUT_GET, "id");

    $movie;

    $movie_dao = new MovieDAO($conn, $BASE_URL);
    $review_dao = new ReviewDAO($conn, $BASE_URL);

    if(empty($id)) {

        $message->setMessage("Filme não encontrado", "error", "index.php");

    } else {

        $movie = $movie_dao->findById($id);

        if(!$movie) {

            $message->setMessage("Filme não encontrado", "error", "index.php");

        }

    }

    if($movie->image == "") {

        $movie->image = "movie_cover.jpg";

    }

    $user_owns_movie = false;

    if(!empty($user_data)) {

        if ($movie->users_id == $user_data->id) {

            $user_owns_movie = true;

        }

        $already_reviewed = $review_dao->hasAlreadyReviewed($movie->id, $user_data->id);

    }

    $movie_reviews = $review_dao->getMoviesReview($movie->id);

?>

    <div id="main-container" class="container-fluid">
        <div class="row">
            <div class="offset-md-1 col-md-6 movie-container">
                <h1 class="page-title"><?= $movie->title ?></h1>
                <p class="movie-details">
                    <span>Duração: <?= $movie->length ?></span>
                    <span class="pipe"></span>
                    <span><?= $movie->category ?></span>
                    <span class="pipe"></span>
                    <span><i class="fas fa-star"></i> <?= $movie->rating ?></span>
                </p>
                <iframe src="<?= $movie->trailer ?>" width="560px" height="315px" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <p><?= $movie->description ?></p>
            </div>
            <div class="col-md-4">
                <div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>
            </div>
            <div class="offset-md-1 col-md-10" id="reviews-container">
                <h3 id="reviews-title">Avaliações:</h3>
                <?php if(!empty($user_data) && !$user_owns_movie && !$already_reviewed) : ?>
                    <div class="col-md-12" id="review-form-container">
                        <h4>Envie sua avaliação</h4>
                        <p class="page-description">Preencha o formulário com a nota e comentário sobre o filme</p>
                        <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
                            <input type="hidden" name="type" value="create">
                            <input type="hidden" name="movies_id" value="<?= $movie->id ?>">
                            <div class="form-group">
                                <label for="rating">Nota:</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="1">1 estrela</option>
                                    <option value="2">2 estrelas</option>
                                    <option value="3">3 estrelas</option>
                                    <option value="4">4 estrelas</option>
                                    <option value="5">5 estrelas</option>
                                    <option value="6">6 estrelas</option>
                                    <option value="7">7 estrelas</option>
                                    <option value="8">8 estrelas</option>
                                    <option value="9">9 estrelas</option>
                                    <option value="10">10 estrelas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Comentário:</label>
                                <textarea name="review" id="review" class="form-control" rows="3" placeholder="O que você achou do filme?"></textarea>
                            </div>
                            <input type="submit" class="btn card-btn" value="Enviar comentário">
                        </form>
                    </div>
                <?php endif; ?>
                <?php foreach ($movie_reviews as $review) : ?>
                    <?php require("templates/user_review.php"); ?>
                <?php endforeach; ?>
                <?php if (count($movie_reviews) == 0) : ?>
                    <p id="empty-list" class="review-empty-list">Este filme ainda não possui avaliações...</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php

    require_once("templates/footer.php");

?>