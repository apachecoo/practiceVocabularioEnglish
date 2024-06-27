<?php

class VocabularyController
{

    private VocabularyView $view;
    private array $categories;

    public mixed $cookieDuration;

    public const NAME_COOKIE_SUCCESS = 'success';
    public const NAME_COOKIE_FAILED = 'failed';

    public function __construct()
    {
        $this->categories = Category::all();
        $this->view = new VocabularyView();
        $this->setCookieDuration();

    }
    public function index()
    {
        $selectedWord = ['word' => [], 'numberRandum' => null];
        $vocabulary = [];
        $idCategory = $_REQUEST['idCategory'] ?? null;
        $translation = $_REQUEST['translation'] ?? null;
        $idVocabulary = $_REQUEST['idVocabulary'] ?? null;

        if ($idCategory) {
            $vocabulary = $this->getVocabularyModel()->getVocabularyByIdCategory($idCategory);
            $selectedWord = $vocabulary ? $this->getWordRandom($vocabulary) : [];
        }

        if ($translation) {
            if ($this->validateTranslation($translation, $idVocabulary)) {
                $this->addSuccessesFailed($selectedWord['word'], self::NAME_COOKIE_SUCCESS);
            } else {
                $this->addSuccessesFailed($selectedWord['word'], self::NAME_COOKIE_FAILED);
            }
            $this->view->index($this->categories, $selectedWord['word']);
        }
        $this->view->index($this->categories, $selectedWord['word']);
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

    private function setCookieDuration()
    {
        $this->cookieDuration = (time() + 86400);
    }
    public function addSuccessesFailed(array $word, string $nameCookie)
    {
        if (isset($_COOKIE[$nameCookie])) {
            $arrayCookie = json_decode($_COOKIE[$nameCookie], true);
        }else{
            $arrayCookie = [];
        }
        $arrayCookie[] = $word;
        $arrayCookie = json_encode($arrayCookie);
        setcookie($nameCookie, $arrayCookie, $this->cookieDuration,'/');
    }

    public function restart()
    {
        $this->deleteCookie(self::NAME_COOKIE_SUCCESS);
        $this->deleteCookie(self::NAME_COOKIE_FAILED);
        header('Location: http://127.0.0.16/');
    }
    public function deleteCookie(string $nameCookie)
    {
        setcookie($nameCookie, '', time() - 60);
    }
    public function getVocabularyModel()
    {
        return new Vocabulary();
    }
}