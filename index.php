<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'class/database.php';
require_once 'class/util.php';
require_once 'class/ui/textInput.php';
require_once 'class/ui/textArea.php';
require_once 'class/ui/dropdown.php';

//$pageParam = Util::ifx($_GET, 'page', 'tables');
$tableNameParam = Util::ifx($_GET, 'table');
$actionParam = Util::ifx($_GET, 'action');
$resultParam = Util::ifx($_GET, 'result');
$idParam = Util::ifx($_GET, 'id');

?>
    <!doctype html>
    <html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Grant McNally">
        <title>BDI ² CMS</title>

        <link rel="canonical" href="">

        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
              crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
                crossorigin="anonymous"></script>

        <style>
            tbody tr:hover {
                background-color: lightgray;
                cursor: pointer;
            }

            input, select {
                width: 400px;
                height: 40px;
            }
            textarea {
                width: 400px;
                height: 80px;
            }

            .container {
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .row.form {
                margin: 10px;
            }

            .alert-success, .alert-warning {
                padding: 20px;
                margin-top: 12px;
                margin-bottom: 12px;
            }
        </style>

    </head>
    <body class="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BDI ² CMS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            </div>
        </div>
    </nav>

    <?php
    if ($resultParam):
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 alert alert-success text-center" role="alert">
                    Successfully <?php echo $resultParam; ?>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>

    <?php
    if ($tableNameParam && in_array($actionParam, array(Action::Add, Action::Edit))) {
        require_once 'page/addRow.php';
    } else if ($tableNameParam && $actionParam == Action::Delete) {
        require_once 'page/deleteRow.php';
    } else if ($tableNameParam) {
        require_once 'page/rows.php';
    } else {
        require_once 'page/tables.php';
    }
    ?>
    </body>
    </html>

<?php

abstract class Action
{
    const Add = 'add';
    const Edit = 'edit';
    const Delete = 'delete';
    const Saved = 'saved';
}

?>