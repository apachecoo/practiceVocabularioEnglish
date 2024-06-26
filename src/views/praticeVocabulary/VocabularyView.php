<?php


class VocabularyView
{

    public function index(array $categories=[],array $word=[]): void
    {

        require_once './views/praticeVocabulary/index.php';
    }

    public function show(?EmployeeModel $employee = null): void
    {
        require_once './views/employee/show.php';
    }

}