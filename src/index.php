<?php

require_once 'models/Category.php';
require_once 'models/Vocabulary.php';
require_once 'controllers/VocabularyController.php';
require_once 'views/praticeVocabulary/VocabularyView.php';


if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
} else {
    $controller = 'VocabularyController';
    $action = 'index';
}
require_once 'controllers/' . $controller . '.php';
$controller = new $controller();
$controller->{$action}();

