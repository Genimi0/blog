<?php
require_once 'articles.php';

const ERROR_REQUIRED = "Veuillez renseigner ce champ";
const ERROR_TITLE_TOO_SHORT = "Le titre est trop court";
const ERROR_CONTENT_TOO_SHORT = "L'article est trop court";
const ERROR_IMAGE_URL = "L'image doit être une URL valide";

$errors = [
    'title' => '',
    'image' => '',
    'idCategory' => '',
    'content' => ''
];

if (isset($_GET['article'])) {
    $_GET['article'] = filter_var($_GET['article'], FILTER_SANITIZE_NUMBER_INT) ?? '';
    $article = getArticleById($_GET['article']);
    if (!empty($article)) {
        $title = $article['title'];
        $image = $article['image_url'];
        $content = $article['content'];
        $idCategory = $article['idCategory'];
        $categoryName = getCategoryNameById($idCategory);
    } else {
        header('location:/form-article.php');
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titleSize = mb_strlen($_POST['title']);
    $contentSize = mb_strlen($_POST['content']);

    $_POST = filter_input_array(INPUT_POST, [
        'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'image' => FILTER_SANITIZE_URL,
        'idCategory' => FILTER_SANITIZE_NUMBER_INT,
        'content' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
        ]
    ]);
    $title = $_POST['title'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['idCategory'] ?? '';
    $content = $_POST['content'] ?? '';

    if (!$title) {
        $errors['title'] = ERROR_REQUIRED;
    } elseif ($titleSize <= 5) {
        $errors['title'] = ERROR_TITLE_TOO_SHORT;
    }

    if (!$image) {
        $errors['image'] = ERROR_REQUIRED;
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = ERROR_IMAGE_URL;
    }

    if (!$category) {
        $errors['idCategory'] = ERROR_REQUIRED;
    }

    if (!$content) {
        $errors['content'] = ERROR_REQUIRED;
    } elseif ($contentSize <= 50) {
        $errors['content'] = ERROR_CONTENT_TOO_SHORT;
    }
    if (isset($_GET['article'])) {
        $_GET['article'] = filter_var($_GET['article'], FILTER_SANITIZE_NUMBER_INT) ?? '';
        $idarticle = $_GET['article'];
    }
    if (empty(array_filter($errors, fn ($value) => $value !== ''))) {
        if (isset($_GET['article'])) {
            updateArticleById($idarticle, $title, $image, $category, $content);
            header('location:/');
        } else {
            createArticle($_POST);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('includes/head.php'); ?>
    <link rel="stylesheet" href="assets/css/form-article.css">
    <title><?= isset($idCategory) ? "Modifier un article" : "Créer un article"; ?></title>
</head>

<body class='d-flex flex-column'>
    <?php require_once('includes/header.php'); ?>
    <main class="d-flex flex-column">
        <div class="block p-20 d-flex flex-column form-container">
            <h1><?= isset($idCategory) ? "Modifier un article" : "Créer un article"; ?></h1>
            <form action="form-article.php<?php if (isset($_GET['article'])) {
                                                echo '?article=' . $_GET['article'];
                                            } ?>" method='POST'>
                <div class="form-control d-flex flex-column">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" value="<?= $title ?? '' ?>">
                    <?php if ($errors['title']) : ?>
                        <p class='text-error'><?= $errors['title'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control d-flex flex-column">
                    <label for="image">Image</label>
                    <input type="text" name="image" id="image" value="<?= $image ?? '' ?>">
                    <?php if ($errors['image']) : ?>
                        <p class='text-error'><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control d-flex flex-column">
                    <label for="category">Catégorie</label>
                    <select name="idCategory" id="idCategory">
                        <?php
                        $categories = getAllCategories();
                        foreach ($categories as $thecategory) : ?>
                            <option <?php
                                    if (isset($categoryName['name'])) {
                                        if (
                                            $categoryName['name'] === $thecategory['name']
                                        ) {
                                            echo "selected";
                                        }
                                    }
                                    ?> value="<?= $thecategory['idCategory'] ?>"><?= $thecategory['name'] ?></option>
                        <?php endforeach;
                        ?>
                    </select>
                    <?php if ($errors['idCategory']) : ?>
                        <p class='text-error'><?= $errors['idCategory'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-control d-flex flex-column">
                    <label for="content">Contenu</label>
                    <textarea name="content" id="content"><?= $content ?? '' ?></textarea>
                    <?php if ($errors['content']) : ?>
                        <p class='text-error'><?= $errors['content'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-action d-flex justify-end">
                    <a href='/' class='btn btn-secondary'>Annuler</a>
                    <button type='submit' class='btn btn-primary'><?= isset($_GET['article']) ? "Modifier" : "Sauvegarder" ?></button>
                </div>
            </form>
        </div>
    </main>
    <?php require_once('includes/footer.php'); ?>
</body>

</html>