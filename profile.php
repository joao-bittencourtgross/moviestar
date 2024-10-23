<?php 

    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user = new User();
    $user_dao = new UserDAO($conn, $BASE_URL);
    $movie_dao = new MovieDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "id");

    if(empty($id)) {

        if (!empty($user_data)) {

            $id = $user_data->id;

        } else {

            $message->setMessage("Usuário não encontrado!", "error", "index.php");

        }

    } else {

        $user_data = $user_dao->findById($id);

        if (!$user_data) {

            $message->setMessage("Usuário não encontrado!", "error", "index.php");

        }

    }

    $full_name = $user->getFullName($user_data);

    if ($user_data->image == "") {

        $user_data->image = "user.png";

    }

    $user_movies = $movie_dao->getMoviesByUserId($id);

?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-8 offset-md-2">
            <div class="row profile-container">
                <div class="col-md-12 about-container">
                    <h1 class="page-title"><?= $full_name ?></h1>
                    <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $user_data->image ?>');"></div>
                    <h3 class="about-title">Sobre:</h3>
                    <?php if (!empty($user_data->bio)) : ?>
                        <p class="profile-description"><?= $user_data->bio ?></p>
                    <?php else : ?>
                        <p class="profile-description">O usuário ainda não escreveu nada aqui!</p>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 added-movies-container">
                    <h3>Filmes que enviou:</h3>
                    <div class="movies-container">
                        <?php foreach ($user_movies as $movie) : ?>
                            <?php require("templates/movie_card.php"); ?>
                        <?php endforeach; ?>
                        <?php if (count($user_movies) == 0) : ?>
                            <p class="empty-list">O usuário ainda não enviou nenhum filme!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 

    require_once("templates/footer.php");

?>