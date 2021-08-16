<?php
require_once 'class/log.php';
$logDao = new LogChanges($db);
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Export </h1>
                Below is a list of export types.
            </div>
        </div>
    </div>

<?php

?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary" type="button"
                        onclick="window.location='index.php?export=<?php echo Export::All; ?>'">Export All Data
                </button>
            </div>
        </div>
    </div>

<?php
if ($exportParam == Export::All):
    if ($changes = $logDao->getAllUpdates()):
        ?>
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <th>Query</th>
                </thead>
                <tbody>
                <?php
                foreach ($changes as $change):
                    ?>
                    <tr>
                        <td>
                            <?php echo $change['query']; ?>;<br>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
    <?php
    endif;
endif;
?>