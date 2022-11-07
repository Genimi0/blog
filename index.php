<?php
require_once 'articles.php';

if (isset($_GET['category'])) {
    $_GET['category'] = filter_var($_GET['category'], FILTER_SANITIZE_NUMBER_INT);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('includes/head.php'); ?>
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Projet Blog</title>
</head>

<body class='d-flex flex-column'>
    <?php require_once('includes/header.php'); ?>
    <main class='content'>
        <div class="newsfeed-container d-flex flex-row">
            <div class="category-container">
                <ul>
                    <li><a href='/'>Tous les articles(<?= count(getAllArticles()) ?>)</a></li>
                    <?php
                    $categories = getAllCategories();
                    foreach ($categories as $categorie) : ?>
                        <li><a href='?category=<?= $categorie['idCategory'] ?>'><?= $categorie['name'] ?>(<?= count(getAllArticlesByCategoryId($categorie['idCategory'])) ?>)</a></li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>

            <div class="newsfeed-container">
                <?php
                if (isset($_GET['category'])) {
                    $category = getCategoryNameById($_GET['category']);

                ?>
                    <h2><?= $category['name'] ?></h2>
                    <div class="articles-container d-flex align-start">
                        <?php
                        $articles = getAllArticlesByCategoryId($_GET['category']);
                        foreach ($articles as $article) : ?>

                            <div class="article block">
                                <a href="/show-article.php?article=<?= $article["idArticle"] ?>">
                                    <div class="overflow">
                                        <div class="image-container" style="background-image:url(<?= $article['image_url'] ?>)"></div>
                                    </div>
                                    <h3><?= $article['title'] ?></h3>
                                </a>
                            </div>

                        <?php
                        endforeach; ?>
                    </div>
                    <?php
                } else {
                    foreach ($categories as $category) : ?>
                        <h2><?= $category['name'] ?></h2>
                        <div class="articles-container d-flex align-start">
                            <?php
                            $articles = getAllArticlesByCategoryId($category['idCategory']);

                            foreach ($articles as $article) : ?>
                                <div class="article block">
                                    <a href="/show-article.php?article=<?= $article["idArticle"] ?>">
                                        <div class="overflow">
                                            <div class="image-container" style="background-image:url(<?= $article['image_url'] ?>)"></div>
                                        </div>
                                        <h3><?= $article['title'] ?></h3>
                                    </a>
                                </div>
                            <?php
                            endforeach;

                            ?>

                        </div>
                <?php
                    endforeach;
                }
                ?>
            </div>
        </div>

    </main>
    <?php require_once('includes/footer.php'); ?>
</body>

</html>