<?php 

    class Movie {

        public $id;
        public $title;
        public $description;
        public $image;
        public $trailer;
        public $category;
        public $length;
        public $users_id;
        public $rating;

        public function imageGenerateName() {

            $bytes = openssl_random_pseudo_bytes(80);
            return bin2hex($bytes) . ".jpg";

        }

    }

    interface MovieDAOInterface {

        public function buildMovie($data);
        public function findAll();
        public function getLatestMovies();
        public function getMoviesCategory($category);
        public function getMoviesByUserId($id);
        public function findById($id);
        public function findByTitle($title);
        public function create(Movie $movie);
        public function update(Movie $movie);
        public function destroy($id);

    }