<?php
    session_start();

    if (isset($_SESSION['email'])) {
        // Rediriger vers la page de profil si l'utilisateur est déjà connecté
        header("Location: profil.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $file = 'users.json';
        if (!file_exists($file)) {
            // Le fichier des utilisateurs n'existe pas, afficher un message d'erreur
            $error_msg = "<div class='alert alert-danger alert-white rounded'>
                            <div class='icon'><i class='fa fa-times-circle'></i></div>
                            <strong>Erreur</strong> L'email ou le mot de passe est incorrect.
                        </div>";
        } else {
            $data = file_get_contents($file);
            $users = json_decode($data, true);
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            if (array_key_exists($email, $users)) {
                // L'email existe dans la liste des utilisateurs
                $userData = json_decode(file_get_contents($users[$email]), true);
                $passwordHash = $userData['password'];
                
                if (password_verify($password, $passwordHash)) {
                    // Le mot de passe est correct, connecter l'utilisateur
                    $_SESSION['email'] = $email;
                    header("Location: profil.php");
                } else {
                    // Le mot de passe est incorrect, afficher un message d'erreur
                    $error_msg = "<div class='alert alert-danger alert-white rounded'>
                                    <div class='icon'><i class='fa fa-times-circle'></i></div>
                                    <strong>Erreur</strong> L'email ou le mot de passe est incorrect.
                                </div>";
                }
            } else {
                // L'email n'existe pas dans la liste des utilisateurs, afficher un message d'erreur
                $error_msg = "<div class='alert alert-danger alert-white rounded'>
                                <div class='icon'><i class='fa fa-times-circle'></i></div>
                                <strong>Erreur</strong> L'email ou le mot de passe est incorrect.
                            </div>";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jeunes 6.4 - Connexion</title>
        <link rel="icon" href="assets/logo4.ico">
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/9b3084e9e8.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <div class="large-container">
                <div class="header-body">
                    <div class="header-logo">
                        <a href="home.php"><img src="assets/logo1.png" alt="Logo Jeunes 6.4"></a>
                    </div>

                    <div class="header-text">
                            <h1 class="xl-title young">Jeune</h1>
                            <h2 class="slogan">Je donne de la valeur à mon engagement</h2>
                    </div>
                </div>

                <nav class="header-nav">
                    <ul class="nav-list">
                        <li class="nav-item young active"><a class="nav-link" href="login.php">Jeune</a></li>
                        <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                        <li class="nav-item consultant"><a class="nav-link" href="search_user.php">Consultant</a></li>
                        <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="form login young">
            <div class="small-container">
                <h1 class="main-title">Se connecter</h1>
                <?php if (isset($error_msg)) { echo "<p class='text'>$error_msg</p>"; } ?>
                <form id="login-form" action="login.php" method="post">
                        <div class="input-group">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="email" required>
                        </div>

                        <div class="input-group">
                            <label for="login-password">Mot de passe</label>
                            <input type="password" id="login-password" name="password" required>
                        </div>

                        <div class="center">
                            <button type="submit" class="btn">Se connecter</button>
                        </div>
                    </form>

                <p class="text">Pas encore inscrit ? <a href="register.php" class="link">S'inscrire</a></p>
            </div>
        </section>
    </body>
</html>