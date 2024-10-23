<?php 

    require_once("db.php");
    require_once("globals.php");
    require_once("models/Message.php");
    require_once("models/Movie.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");

    $user_dao = new UserDAO($conn, $BASE_URL);
    $message = new Message($BASE_URL);
    $movie_dao = new MovieDAO($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    $user_data = $user_dao->verifyToken();

    if ($type === "create") {

        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");

        $movie = new Movie();

        if(!empty($title) && !empty($description) && !empty($trailer) && !empty($category) && !empty($length)) {

            $movie->title = $title;
            $movie->description = $description;
            $movie->trailer = $trailer;
            $movie->category = $category;
            $movie->length = $length;
            $movie->users_id = $user_data->id;

            if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $image_types = ["image/jpeg", "image/jpg", "image/png"];

                if (in_array($image["type"], $image_types)) {

                    if (in_array($image["type"], ["image/jpeg", "image/jpg"])) {
                        $image_file = imagecreatefromjpeg($image["tmp_name"]);
                    } else {
                        $image_file = imagecreatefrompng($image["tmp_name"]);
                    }
    
                    $image_name = $movie->imageGenerateName();
    
                    imagejpeg($image_file, "./img/movies/" . $image_name, 100);
    
                    $movie->image = $image_name;
    
                } else {
                    $message->setMessage("Formato de imagem inválido", "error", "back");
                }

            }

            $movie_dao->create($movie);

        } else {

            $message->setMessage("Preencha todos os campos", "error", "back");

        }

    } else if ($type === "delete") {

        $id = filter_input(INPUT_POST, "id");

        $movie = $movie_dao->findById($id);

        if ($movie) {

            if ($movie->users_id == $user_data->id) {

                $movie_dao->destroy($movie->id);

            } else {

                $message->setMessage("Você não tem permissão para deletar este filme", "error", "index.php");

            }

        } else {

            $message->setMessage("Filme não encontrado", "error", "index.php");

        }

    } else if($type === "update") {

        $title = filter_input(INPUT_POST, "title");
        $description = filter_input(INPUT_POST, "description");
        $trailer = filter_input(INPUT_POST, "trailer");
        $category = filter_input(INPUT_POST, "category");
        $length = filter_input(INPUT_POST, "length");
        $id = filter_input(INPUT_POST, "id");

        $movie_data = $movie_dao->findById($id);

        if($movie_data) {

            if ($movie_data->users_id === $user_data->id) {

                if (!empty($title) && !empty($description) && !empty($trailer) && !empty($category) && !empty($length)) {
                    $movie_data->title = $title;
                    $movie_data->description = $description;
                    $movie_data->trailer = $trailer;
                    $movie_data->category = $category;
                    $movie_data->length = $length;
    
                    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
    
                        $image = $_FILES["image"];
                        $image_types = ["image/jpeg", "image/jpg", "image/png"];
        
                        if (in_array($image["type"], $image_types)) {
        
                            if (in_array($image["type"], ["image/jpeg", "image/jpg"])) {
                                $image_file = imagecreatefromjpeg($image["tmp_name"]);
                            } else {
                                $image_file = imagecreatefrompng($image["tmp_name"]);
                            }
            
                            $image_name = $movie_data->imageGenerateName();
            
                            imagejpeg($image_file, "./img/movies/" . $image_name, 100);
            
                            $movie_data->image = $image_name;
            
                        } else {

                            $message->setMessage("Formato de imagem inválido", "error", "back");

                        }
        
                    }

                    $movie_dao->update($movie_data);

                } else {

                    $message->setMessage("Preencha todos os campos", "error", "back");

                }


            } else {

                $message->setMessage("Você não tem permissão para editar este filme", "error", "index.php");

            }

        } else {

            $message->setMessage("Filme não encontrado", "error", "index.php");

        }

    } else {

        $message->setMessage("Tipo de ação inválida", "error", "index.php");

    }