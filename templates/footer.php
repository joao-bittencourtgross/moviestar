<?php

require_once("dao/UserDAO.php");

$user_dao = new UserDAO($conn, $BASE_URL);

$user_data = $user_dao->verifyToken(false);

?>

<footer id="footer">
    <div id="social-container">
        <ul>
            <li>
                <a href="#"><i class="fab fa-facebook-square"></i></a>
            </li>
            <li>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </li>
            <li>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </li>
        </ul>
    </div>
    <div id="footer-links-container">
        <ul>
            <?php if ($user_data): ?>
                <li>
                    <a href="<?= $BASE_URL ?>newmovie.php">Adicionar filme</a>
                </li>
                <li>
                    <a href="<?= $BASE_URL ?>dashboard.php">Meus filmes</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?= $BASE_URL ?>auth.php">Entrar / Registrar</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <p>&copy; <?php echo date('Y') ?> Solutech Tecnologia</p>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.js" integrity="sha512-KCgUnRzizZDFYoNEYmnqlo0PRE6rQkek9dE/oyIiCExStQ72O7GwIFfmPdkzk4OvZ/sbHKSLVeR4Gl3s7s679g==" crossorigin="anonymous"></script>
</body>

</html>