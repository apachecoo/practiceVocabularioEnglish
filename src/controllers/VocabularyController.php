<?php

class VocabularyController
{

    private VocabularyView $view;
    private array $categories;

    public function __construct()
    {
        $this->categories = Category::all();
        $this->view = new VocabularyView();

    }
    public function index()
    {
        $selectedWord = [];
        $vocabulary = [];
        $success = [];
        $failures = [];
        $idCategory = $_REQUEST['idCategory'] ?? null;
        $translation = $_REQUEST['translation'] ?? null;
        $idVocabulary = $_REQUEST['idVocabulary'] ?? null;
        if ($idCategory) {
            $vocabulary = $this->getVocabularyModel()->getVocabularyByIdCategory($idCategory);
            $selectedWord = $vocabulary ? $this->getWordRandom($vocabulary) : [];
        }

        if ($translation) {
            if ($this->validateTranslation($translation, $idVocabulary)) {
                array_push($success, $selectedWord['word']);
                unset($vocabulary[$selectedWord['numberRandum']]);
                $this->view->index($this->categories, $selectedWord['word'], $success);
                exit();
            } else {
                array_push($failures, $selectedWord['word']);
                unset($vocabulary[$selectedWord['numberRandum']]);
                echo "traduccion incorrecta";
            }
        }

        $this->view->index($this->categories, $selectedWord, $success, $failures);
    }

    public function getWordRandom(array $vocabulary = [])
    {
        $wordRandom = '';
        if ($vocabulary) {
            $totalWords = count($vocabulary);
            $numberRandum = rand(0, $totalWords - 1);
            $wordRandom = $vocabulary[$numberRandum];
        }

        return ['word' => $wordRandom, 'numberRandum' => $numberRandum];
    }

    public function validateTranslation(string $translation, int $idVocabulary)
    {
        $userTranslation = trim($translation);
        $translation = Vocabulary::find($idVocabulary);
        return strtolower(trim($translation->translation)) === strtolower($userTranslation);
    }

    public function getVocabularyModel()
    {
        return new Vocabulary();
    }
}