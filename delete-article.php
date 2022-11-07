<?php
require_once "articles.php";

if (isset($_GET['article'])) {
    $_GET['article'] = filter_var($_GET['article'], FILTER_SANITIZE_NUMBER_INT);
    deleteArticleById($_GET['article']);
}

header('location:/');
