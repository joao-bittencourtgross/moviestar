<?php 

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $user_dao = new UserDAO($conn, $BASE_URL);

    $type = filter_input(INPUT_POST, "type");

    if($type === "register") {

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        if($name && $lastname && $email && $password) {

            if($password === $confirmpassword) {

                if ($user_dao->findByEmail($email) === false) {

                    $user = new User();

                    $user_token = $user->generateToken();
                    $final_password = $user->generatePassword($password);

                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $final_password;
                    $user->token = $user_token;

                    $auth = true;

                    $user_dao->create($user, $auth);

                } else {
                        
                    $message->setMessage("Usuário já cadastrado, tente outro e-mail", "error", "back");

                }

            } else {

                $message->setMessage("As senhas não conferem.", "error", "back");
                
            }

        } else {

            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");
           
        }

    } else if($type === "login") {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        if($user_dao->authenticateUser($email, $password)) {

           $message->setMessage("Seja bem vindo!", "success", "editprofile.php");

        } else {

            $message->setMessage("Usuário e/ou senha inválidos.", "error", "back");

        } 

    } else {
            
        $message->setMessage("Ação inválida", "error", "index.php");

    }
