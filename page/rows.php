<?php
require_once 'class/database.php';
$db = new Database();
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><a href="index.php">Tables</a> &rarr; <?php echo $tableNameParam; ?></h1>
            Below is a list of all the items currently in the <?php echo $tableNameParam; ?> table.
        </div>
    </div>
</div>

<?php
$tableDetails = $db->getForeignKeys($tableNameParam);
$columns = $db->getColumns($tableNameParam);
$rows = $db->getAllRows($tableNameParam);
$primaryKey = $db->getPrimaryKey($tableNameParam);

$foreignKeys = $db->getForeignKeys($tableNameParam);

?>

<div class="container">
    <div class="row">
        <div class="col-1">
            <button type="button" class="btn btn-primary" onclick="addRow()"><i class="bi bi-plus"></i></button>
        </div>
    </div>
</div>

<div class="container">
    <table class="table table-striped">
        <thead>
        <?php
        if ($columns) :
            foreach ($columns as $column):
                $columnName = $column['name'];
                ?>
                <th><?php echo $columnName; ?></th>
            <?php
            endforeach;
            ?>
            <th>Edit</th>
            <th>Delete</th>
        <?php
        endif;
        ?>
        </thead>

        <tbody>
        <?php
        if ($rows) :
            foreach ($rows as $row):
                $primaryKeyValue = $row[$primaryKey];
                ?>
                <tr onclick="editRow(<?php echo $primaryKeyValue; ?>)">
                    <?php
                    foreach ($row as $columnName => $columnValue) {
                        echo '<td>';
                        $isForeignKey = false;
                        $foreignKeyData = array();
                        if ($foreignKeys) {
                            $foreignKeyKey = array_search($columnName, array_column($foreignKeys, 'from'));
                            $isForeignKey = is_int($foreignKeyKey);
                            $foreignKeyDetails = $isForeignKey ? Util::ifx($foreignKeys, $foreignKeyKey) : array();
                            $foreignKeyTable = Util::ifx($foreignKeyDetails, 'table');
                        }
                        if ($isForeignKey) {
                            if ($foreignKeyData = $db->getRow($foreignKeyTable, 'id', $columnValue, SQLITE3_NUM)) {
                                //TODO: find a better way to get the actual FK value...
                                echo $foreignKeyData['1'];
                            } else {
                                echo $columnValue;
                            }
                        } else {
                            echo $columnValue;
                        }
                        echo '</td>';
                    }
                    ?>
                    <td>
                        <button type="button" class="btn btn-secondary"
                                onclick="editRow(<?php echo $primaryKeyValue; ?>)">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger"
                                onclick="deleteRow(<?php echo $primaryKeyValue; ?>)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>
    <?php
    if (!$rows):
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 alert alert-warning text-center" role="alert">
                    No data yet
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function addRow() {
        let url = "index.php?table=<?php echo $tableNameParam; ?>&action=add";
        window.location = url;
    }

    function editRow(id) {
        let url = "index.php?table=<?php echo $tableNameParam; ?>&id=" + id + "&action=edit";
        window.location = url;
    }

    function deleteRow(id) {
        event.stopPropagation();

        let url = "index.php?table=<?php echo $tableNameParam; ?>&id=" + id + "&action=delete";
        if (confirm('Are you sure you want to delete this item?')) {
            window.location = url;
        }
    }
</script>
