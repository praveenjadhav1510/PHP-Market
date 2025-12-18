<?php
// Legacy endpoint: redirect to project detail where apply logic lives.

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    header("Location: /php-dev-marketplace/projects/detail.php?id=" . $id);
    exit;
}

header("Location: /php-dev-marketplace/developers/list");
exit;




