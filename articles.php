<?php
require_once 'db_connexion.php';
$createArticleRequest = $pdo->prepare("INSERT INTO articles VALUES(DEFAULT, :title, :image, :content, :idCategory)");
$getAllArticlesRequest = $pdo->prepare('SELECT * FROM articles ORDER BY idArticle DESC');

function createArticle($article)
{
    global $createArticleRequest;
    $createArticleRequest->execute($article);
    header('location: /');
}

function getAllArticles()
{
    global $getAllArticlesRequest;
    $getAllArticlesRequest->execute();
    $articles = $getAllArticlesRequest->fetchAll();
    return $articles;
}

function getAllArticlesByCategoryId($id)
{
    global $getAllArticlesByCategoryIdRequest;
    $getAllArticlesByCategoryIdRequest->bindValue(':idCategory', $id);
    $getAllArticlesByCategoryIdRequest->execute();
    $articles = $getAllArticlesByCategoryIdRequest->fetchAll();
    return $articles;
}
function getAllCategories()
{
    global $getAllCategories;
    $getAllCategories->execute();
    $categories = $getAllCategories->fetchAll();
    return $categories;
}
function getCategoryNameById($id)
{
    global $getCategoryNameByIdRequest;
    $getCategoryNameByIdRequest->bindValue(':idCategory', $id);
    $getCategoryNameByIdRequest->execute();
    $category = $getCategoryNameByIdRequest->fetch();
    return $category;
}

function getArticleById($id)
{
    global $getArticleByIdRequest;
    $getArticleByIdRequest->bindValue(':idArticle', $id);
    $getArticleByIdRequest->execute();
    $article = $getArticleByIdRequest->fetch();
    return $article;
}
function updateArticleById($id, $title, $image, $idCategory, $content)
{
    global $updateArticleByIdRequest;
    $updateArticleByIdRequest->bindValue(':idArticle', $id);
    $updateArticleByIdRequest->bindValue(':title', $title);
    $updateArticleByIdRequest->bindValue(':image_url', $image);
    $updateArticleByIdRequest->bindValue(':content', $content);
    $updateArticleByIdRequest->bindValue(':idCategory', $idCategory);
    $updateArticleByIdRequest->execute();
}
function deleteArticleById($id)
{
    global $deleteArticleById;
    $deleteArticleById->bindValue(':idArticle', $id);
    $deleteArticleById->execute();
}
