<?php 

    require_once("models/Review.php");
    require_once("models/Message.php");

    require_once("dao/UserDAO.php");

    class ReviewDAO implements ReviewDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct($conn, $url) {

            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);

        }

        public function buildReview($data) {

            $review = new Review();

            $review->id = $data["id"];
            $review->rating = $data["rating"];
            $review->review = $data["review"];
            $review->users_id = $data["users_id"];
            $review->movies_id = $data["movies_id"];

            return $review;

        }

        public function create(Review $review) {

            $stmt = $this->conn->prepare("INSERT INTO reviews (rating, review, users_id, movies_id) VALUES (:rating, :review, :users_id, :movies_id)");

            $stmt->bindParam(":rating", $review->rating);
            $stmt->bindParam(":review", $review->review);
            $stmt->bindParam(":users_id", $review->users_id);
            $stmt->bindParam(":movies_id", $review->movies_id);

            $stmt->execute();

            $this->message->setMessage("Avaliação cadastrada com sucesso", "success", "movie.php?id=" . $review->movies_id);

        }

        public function getMoviesReview($id) {

            $reviews = [];

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetchAll();

                $user_dao = new UserDAO($this->conn, $this->url);

                foreach($data as $review) {

                    $review = $this->buildReview($review);
                    $user = $user_dao->findById($review->users_id);

                    $review->user = $user;

                    $reviews[] = $review;

                }

            }

            return $reviews;

        }

        public function hasAlreadyReviewed($id, $user_id) {

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE users_id = :users_id AND movies_id = :movies_id");

            $stmt->bindParam(":users_id", $user_id);
            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                return true;

            } else {
                    
                return false;

            }

        }

        public function getRatings($id) {

            $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

            $stmt->bindParam(":movies_id", $id);

            $stmt->execute();

           if ($stmt->rowCount() > 0) {

                $rating = 0;

                $reviews = $stmt->fetchAll();

                foreach($reviews as $review) {

                    $rating += $review["rating"];

                }

                $rating = $rating / count($reviews);

            } else {

                $rating = "Não avaliado";

            }

            return $rating;

        }

    }