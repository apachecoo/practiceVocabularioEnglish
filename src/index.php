<?php

require_once 'helpers/helpers.php';
require_once 'models/Category.php';
require_once 'models/Vocabulary.php';
require_once 'controllers/VocabularyController.php';
require_once 'views/praticeVocabulary/VocabularyView.php';


if (isset($_REQUEST['controller']) && isset($_REQUEST['action'])) {
    $controller = $_REQUEST['controller'];
    $action = $_REQUEST['action'];
} else {
    $controller = 'VocabularyController';
    $action = 'index';
}
require_once 'controllers/' . $controller . '.php';
$controller = new $controller();
$controller->{$action}();

