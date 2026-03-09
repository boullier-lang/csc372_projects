<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP header partial.-->



<!--Accepts:-->
<!--$pageTitle: the title of the page-->
<!--$pageStyles: list of .css files, excluding 'main.css' -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Golden Mane Salon' ?></title>
    <link rel="stylesheet" href="css/main.css">
    <?php foreach ($pageStyles ?? [] as $style): ?>
        <link rel="stylesheet" href="css/<?= $style ?>">
    <?php endforeach; ?>
</head>
<body>