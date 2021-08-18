<?php
require_once 'class/log.php';
$logDao = new LogChanges($db);
?>

<style>
    tbody tr:hover {
        background-color: initial;
        cursor: initial;
    }
    tbody {
        font-family: monospace;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Export </h1>
            Below is a list of export types.
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary" type="button"
                    onclick="window.location='index.php?export=<?php echo Export::AllChanges; ?>'">Export All Changes
            </button>

            <button class="btn btn-primary" type="button"
                    onclick="window.location='index.php?export=<?php echo Export::AllData; ?>'">Export All Data
            </button>
        </div>
    </div>
</div>

<?php
if ($exportParam == Export::AllChanges):
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

<?php
if ($exportParam == Export::AllData):
    if ($changes = $db->getAllInserts()):
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
                            <?php echo $change; ?>;<br>
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
