<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice Vocabulary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text-center m-3">PRACTICE VOCABULARY</h1>
        <form action="?controller=VocabularyController&action=index" method="post">
            <div class="row">
                <div class="col-3 mb-3">
                    <select name="idCategory" class="form-select" aria-label="Default select example">
                        <?php foreach ($categories as $key => $categorie) { ?>
                            <option value="<?= $categorie->id ?>"><?= $categorie->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-3 mb-3">
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </div>
            </div>
        </form>


        <form action="?controller=VocabularyController&action=index" method="post">
            <div class="row <?= isset($_REQUEST['idCategory']) ? 'show' : 'd-none' ?>">
                <div class="col-6 text-center">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">

                            <?php if ($word) { ?>
                                <h5 class="card-title">Traduce la siguiente palabra:
                                    <h2><?= strtoupper($word['name']) ?></h2>
                                </h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="translation" name="translation"
                                        placeholder="Traduce aqui" autocomplete="off">
                                    <input type="hidden" name="idVocabulary" value="<?= $word['id'] ?>">
                                    <input type="hidden" name="idCategory" value="<?= $word['idCategory'] ?>">
                                </div>
                                <button class="btn btn-success">Traducir</button>
                                <a class="btn btn-primary"
                                    href="?controller=VocabularyController&action=restart">Reiniciar</a>
                            <?php } ?>

                            <?php if ($end) { ?>
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Haz terminado la práctica! </h4>
                                    <p>¡Bien hecho! Practicar es la clave para mejorar tu vocabulario en inglés. No importa
                                        cuántos aciertos hayas tenido esta vez, cada intento es una oportunidad para
                                        aprender más. ¿Listo para seguir practicando?</p>
                                    <hr>
                                    <p class="mb-0">Para volver a intentarlo oprime el botón reiniciar.</p>
                                </div>
                                <a class="btn btn-primary"
                                    href="?controller=VocabularyController&action=restart">Reiniciar</a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col text-success">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <h5 class="card-title">Aciertos</h5>
                                    <div class="mb-3">
                                        <h1>
                                            <?php
                                            $success = getCookie('success');
                                            echo $success ? count($success) : 0;
                                            ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col text-danger">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <h5 class="card-title">Fallidos</h5>
                                    <div class="mb-3">
                                        <h1>
                                            <?php
                                            $failed = getCookie('failed');
                                            echo $failed ? count($failed) : 0;
                                            ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>

</html>