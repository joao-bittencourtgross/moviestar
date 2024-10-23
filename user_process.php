<?php 

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $user_dao = new UserDAO($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    if ($type === "update") {

        $user_data = $user_dao->verifyToken();

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");

        $user = new User();

        $user_data->name = $name;
        $user_data->lastname = $lastname;
        $user_data->email = $email;
        $user_data->bio = $bio;

        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $image_types = ["image/jpeg", "image/jpg", "image/png"];
           
            if (in_array($image["type"], $image_types)) {

                if (in_array($image["type"], ["image/jpeg", "image/jpg"])) {
                    $image_file = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $image_file = imagecreatefrompng($image["tmp_name"]);
                }

                $image_name = $user->imageGenerateName();

                imagejpeg($image_file, "img/users/" . $image_name, 100);

                $user_data->image = $image_name;

            } else {
                $message->setMessage("Formato de imagem inválido", "error", "back");
            }

        }

        $user_dao->update($user_data);


    } else if ($type === "changepassword") {

        $password = filter_input(INPUT_POST, "password");
        $confirm_password = filter_input(INPUT_POST, "confirmpassword");
        $user_data = $user_dao->verifyToken();

        $id = $user_data->id;

        if ($password === $confirm_password) {

           $user = new User();

           $final_password = $user->generatePassword($password);

           $user->password = $final_password;
           $user->id = $id;

           $user_dao->changePassword($user);

        } else {
            $message->setMessage("As senhas não conferem", "error", "back");
        }

    } else {
        $message->setMessage("Ação inválida", "error", "index.php");
    }