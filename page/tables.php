<?php
require_once 'class/database.php';
$db = new Database();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p>Welcome to BDI ² (Black Dog Institutes, Basic Data Interactor).</p>
            <p>This tool is designed to make it easier to create and manage the content used in the numerous BDI mobile
                applications.</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Tables</h1>
            Below is a list of all the tables currently in the database.
        </div>
    </div>
</div>

<?php
$dbTables = $db->getTables();
?>
<div class="container">
    <table class="table table-striped">
        <thead>
            <th>Name</th>
        </thead>
        <tbody>
        <?php
        if ($dbTables) :
            foreach ($dbTables as $table):
                $tableName = $table['name'];
                ?>
                <tr onclick="window.location='index.php?table=<?php echo $tableName; ?>'">
                    <td><?php echo $tableName; ?></td>
                </tr>
            <?php endforeach;
        endif;
        ?>
        </tbody>
    </table>
</div>
