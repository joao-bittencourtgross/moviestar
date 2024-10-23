<?php 

    require_once("db.php");
    require_once("globals.php");
    require_once("models/Message.php");
    require_once("models/Movie.php");
    require_once("models/Review.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("dao/ReviewDAO.php");

    $message = new Message($BASE_URL);
    $user_dao = new UserDAO($conn, $BASE_URL);
    $movie_dao = new MovieDAO($conn, $BASE_URL);
    $review_dao = new ReviewDAO($conn, $BASE_URL);

    $user_data = $user_dao->verifyToken();

    $type = filter_input(INPUT_POST, "type");

    if($type === "create") {

        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");
        $movies_id = filter_input(INPUT_POST, "movies_id");
        $users_id = $user_data->id;

        $review_object = new Review();

        $movie_data = $movie_dao->findById($movies_id);

        if ($movie_data) {

            if (!empty($rating) && !empty($review) && !empty($movies_id)) {

                $review_object->rating = $rating;
                $review_object->review = $review;
                $review_object->users_id = $users_id;
                $review_object->movies_id = $movies_id;

                $review_dao->create($review_object);

            } else {

                $message->setMessage("Preencha todos os campos", "error", "back");

            }

        } else {

            $message->setMessage("Filme não encontrado", "error", "index.php");

        }

    } else {

        $message->setMessage("Ação inválida", "error", "index.php");

    }
