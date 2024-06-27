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
        $end = false;
        $selectedWord = ['word' => [], 'numberRandum' => null];
        $vocabulary = [];
        $idCategory = $_REQUEST['idCategory'] ?? null;
        $translation = $_REQUEST['translation'] ?? null;
        $idVocabulary = $_REQUEST['idVocabulary'] ?? null;

        $successIds = array_column(getCookie(self::NAME_COOKIE_SUCCESS) ?? [], 'id');
        $failedIds = array_column(getCookie(self::NAME_COOKIE_FAILED) ?? [], 'id');
        $excludeIds = array_merge($successIds, $failedIds);

        if ($idCategory) {
            $vocabulary = $this->getVocabularyModel()->getVocabularyByIdCategory($idCategory, $excludeIds);
            if (!is_array($vocabulary)) {
                $end = true;
            }
            $selectedWord = $vocabulary ? $this->getWordRandom($vocabulary) : $selectedWord;

        }

        if ($translation && $idVocabulary) {
            $word = Vocabulary::find($idVocabulary);
            if ($word) {
                $wordArray = [
                    'id' => $word->id,
                    'idCategory' => $word->idCategory,
                    'name' => $word->name,
                    'translation' => $word->translation,
                ];
                if ($this->validateTranslation($translation, $word->translation)) {
                    $this->addSuccessesFailed($wordArray, self::NAME_COOKIE_SUCCESS);
                } else {
                    $this->addSuccessesFailed($wordArray, self::NAME_COOKIE_FAILED);
                }
                header('Location: http://127.0.0.16/?controller=VocabularyController&action=index&idCategory=' . $idCategory);
                exit();
            }
        }


        $this->view->index($this->categories, $selectedWord['word'], $end);
    }

    public function getWordRandom(array $vocabulary = []): array
    {
        $wordRandom = '';
        $numberRandum = null;
        if ($vocabulary) {
            $totalWords = count($vocabulary);
            $numberRandum = rand(0, $totalWords - 1);
            $wordRandom = $vocabulary[$numberRandum];
        }
        return ['word' => $wordRandom, 'numberRandum' => $numberRandum];
    }

    public function validateTranslation(string $userTranslation, string $correctTranslation): bool
    {
        return strtolower(trim($correctTranslation)) === strtolower(trim($userTranslation));
    }

    private function setCookieDuration(): void
    {
        $this->cookieDuration = time() + 86400; // 1 día
    }

    public function addSuccessesFailed(array $word, string $nameCookie): void
    {
        $arrayCookie = isset($_COOKIE[$nameCookie]) ? json_decode($_COOKIE[$nameCookie], true) : [];
        $arrayCookie[] = $word;
        $arrayCookie = json_encode($arrayCookie);
        setcookie($nameCookie, $arrayCookie, $this->cookieDuration, "/");
    }

    public function restart(): void
    {
        $this->deleteCookie(self::NAME_COOKIE_SUCCESS);
        $this->deleteCookie(self::NAME_COOKIE_FAILED);
        header('Location: http://127.0.0.16/');
    }

    public function deleteCookie(string $nameCookie): void
    {
        setcookie($nameCookie, '', time() - 3600, '/');
    }

    public function getVocabularyModel(): Vocabulary
    {
        return new Vocabulary();
    }
}
