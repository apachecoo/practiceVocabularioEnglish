<?php

class VocabularyController
{

    private VocabularyView $view;
    private array $categories;

    public mixed $cookieDuration; 

    public const NAME_COOKIE_SUCCESS = 'success';

    public function __construct()
    {
        $this->categories = Category::all();
        $this->view = new VocabularyView();
        $this->setCookieDuration();

    }
    public function index()
    {
        $selectedWord = ['word' => [],'numberRandum'=> null];
        $vocabulary = [];
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
                $this->addSuccesses($selectedWord['word']);
                $this->view->index($this->categories, $selectedWord['word']);
                exit();
            } else {
                array_push($failures, $selectedWord['word']);
                unset($vocabulary[$selectedWord['numberRandum']]);

                $this->view->index($this->categories, $selectedWord['word']);
                exit();
            }
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

    private function setCookieDuration(){
        $this->cookieDuration = (time() + 86400);
    }
    public function addSuccesses(array $word)
    {
        
        if(isset($_COOKIE[self::NAME_COOKIE_SUCCESS])){
            $arrayCookie = json_decode($_COOKIE[self::NAME_COOKIE_SUCCESS],true);
        }else {
            $arrayCookie = [];
        }

        $arrayCookie[] = $word;
        $arrayCookie = json_encode($arrayCookie);
        setcookie(self::NAME_COOKIE_SUCCESS,$arrayCookie,$this->cookieDuration);
        dump($_COOKIE[self::NAME_COOKIE_SUCCESS]);
    }

    public function getVocabularyModel()
    {
        return new Vocabulary();
    }
}