<?php
require_once 'articles.php';

if (isset($_GET['article'])) {
    $_GET['article'] = filter_var($_GET['article'], FILTER_SANITIZE_NUMBER_INT);
    $article = getArticleById($_GET['article']);
    if (!$article) {
        header('location:/');
    }
} else {
    header('location:/');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('includes/head.php'); ?>
    <link rel="stylesheet" href="assets/css/show-article.css">
    <title>Article </title>
</head>

<body class='d-flex flex-column'>
    <?php require_once('includes/header.php'); ?>
    <main class='content'>
        <a href='/' class='article-back'>Retour à la liste des articles</a>
        <div class="article-container">
            <div class="article-cover-img" style='background-image:url(<?= $article['image_url'] ?>)'></div>
            <h1 class='article-title'><?= $article['title'] ?></h1>
            <div class="separator"></div>
            <div class='article-content'><?= $article['content'] ?></div>
            <div class="action d-flex justify-end">
                <a class='btn btn-danger' href="/delete-article.php?article=<?= $article['idArticle'] ?>">Supprimer</a>
                <a class='btn btn-primary' href="/form-article.php?article=<?= $article['idArticle'] ?>">Editer l'article</a>
            </div>
        </div>

    </main>
    <?php require_once('includes/footer.php'); ?>
</body>

</html>