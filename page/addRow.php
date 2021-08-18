<?php
require_once 'class/database.php';
$db = new Database();
$tableUrl = "index.php?table=$tableNameParam";
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><a href="index.php">Tables</a>  &rarr;  <a href="<?php echo $tableUrl; ?>"><?php echo $tableNameParam; ?></a> &rarr; Add row</h1>
        </div>
    </div>
</div>

<?php

if ($_POST) {
    require_once 'saveRow.php';
}

$foreignKeys = $db->getForeignKeys($tableNameParam);
$columns = $db->getColumns($tableNameParam);
$primaryKey = $db->getPrimaryKey($tableNameParam);

$rowData = $idParam ? $db->getRow($tableNameParam, $primaryKey, $idParam) : array();

class ColumnType
{
    const TEXT = 'TEXT';
    const VARCHAR = 'VARCHAR';
    const INTEGER = 'INTEGER';
    const BOOLEAN = 'INTEGER';
    const BLOB = 'BLOB';
}

?>

<form method="post">
    <div class="container">
        <?php
        foreach ($columns as $column):
            if ($column['name'] == $primaryKey)
                continue;
            $columnName = $column['name'];
            $columnType = $column['type'];
            $columnDefaultValue = $column['dflt_value'];
            $columnValue = Util::ifx($rowData, $columnName, $columnDefaultValue);

            //TODO: make FK code simpler and reusable.
            $isForeignKey = false;
            $foreignKeyRows = array();
            if ($foreignKeys) {
                $foreignKeyKey = array_search($columnName, array_column($foreignKeys, 'from'));
                $isForeignKey = is_int($foreignKeyKey);
                $foreignKeyDetails = $isForeignKey ? Util::ifx($foreignKeys, $foreignKeyKey) : array();
                $foreignKeyTable = Util::ifx($foreignKeyDetails, 'table');
                $foreignKeyRows = $isForeignKey ? $db->getAllRows($foreignKeyTable, SQLITE3_NUM) : array();
                usort($foreignKeyRows, function ($a, $b) {
                    return strcmp($a[1], $b[1]);
                });
            }
            ?>
            <div class="row form">
                <div class="col-lg-3 col-sm-12">
                    <b><?php echo $columnName; ?></b>
                </div>
                <div class="col-lg-5 col-sm-12">
                    <?php
                    if ($isForeignKey) {
                        echo new Dropdown($columnName, $foreignKeyRows, $columnValue);
                    } else if ($columnType == ColumnType::VARCHAR) {
                        echo new TextArea($columnName, $columnValue);
                    } else if ($columnType == ColumnType::INTEGER) {
                        echo new TextInput($columnName, $columnValue, 'number');
                    } else if ($columnType == ColumnType::TEXT) {
                        echo new TextArea($columnName, $columnValue);
                    } else {
                        echo $columnType;
                    }
                    ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <div class="container">
        <div class="row form">
            <div class="col-1">
                <button type="button" class="btn btn-danger" onclick="cancel()">Cancel</button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-primary" onclick="form.submit()">Save</button>
            </div>
        </div>
    </div>
</form>

<script>
    function cancel() {
        let url = "index.php?table=<?php echo $tableNameParam; ?>";
        window.location = url;
    }
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    //loop through each text area and turn into markup input.
    [...document.getElementsByTagName('textArea')].forEach((element) => {
        const simplemde = new SimpleMDE({
            element: element,
        });
    });
</script>
