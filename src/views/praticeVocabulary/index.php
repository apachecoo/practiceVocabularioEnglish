<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <h1 class="text-center m-3">PRACTICE VOCABULARY</h1>
        <form action="controller=PracticeVocabularyController&action=index">
            <div class="row">
                <div class="col-3 mb-3">
                    <select name="idCategory" class="form-select " aria-label="Default select example">
                        <?php

                        foreach ($categories as $key => $categorie) {
                            ?>
                            <option value="<?= $categorie->id ?>"><?= $categorie->name ?></option>
                            <?php
                        }
                        ?>

                    </select>
                </div>
                <div class="col-3 mb-3">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
        <?php
        print_r($word);
        if ($word) {
            ?>
            <form action="controller=PracticeVocabularyController&action=index" method="post">
                <div class="row">
                    <div class="col-6 text-center">
                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <h5 class="card-title">Traduce la siguiente palabra:
                                    <h2><?= strtoupper($word['name']) ?></h2>
                                </h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="translation" name="translation"
                                        placeholder="Traduce aqui">
                                    <input type="hidden" name="idVocabulary" value="<?= $word['id'] ?>">
                                    <input type="hidden" name="idCategory" value="<?= $word['idCategory'] ?>">
                                </div>
                                <button class="btn btn-success">Traducir</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ">
                        <div class="row">
                            <div class="col text-success">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">Aciertos</h5>
                                        <div class="mb-3">
                                            <h1>30</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col text-danger">
                                <div class="card" style="width: 100%;">
                                    <div class="card-body">
                                        <h5 class="card-title">Fallidos</h5>
                                        <div class="mb-3">
                                            <h1>25</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <pre>
                              <?php
                              //   $array_cookie = json_decode($_COOKIE[VocabularyController::NAME_COOKIE_SUCCESS], true);
                              //   print_r($array_cookie)
                              ?>  
                            </pre>
            </form>



        <?php } ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>