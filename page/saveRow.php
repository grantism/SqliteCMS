<?php
require_once 'class/database.php';
$db = new Database();
$tableUrl = "index.php?table=$tableNameParam&result=saved";
?>

<?php
$foreignKeys = $db->getForeignKeys($tableNameParam);
$columns = $db->getColumns($tableNameParam);
$primaryKey = $db->getPrimaryKey($tableNameParam);

if (!$idParam) {
    $db->insert($tableNameParam, $_POST);
} else {
    $db->update($tableNameParam, $primaryKey, $idParam, $_POST);
}
?>

<script>
    window.location = '<?php echo $tableUrl; ?>';
</script>

<?php
exit;
?>
