<?php
require_once 'class/database.php';
$db = new Database();
$tableUrl = "index.php?table=$tableNameParam&result=deleted";
?>

<?php
$primaryKey = $db->getPrimaryKey($tableNameParam);

if ($idParam) {
    $db->delete($tableNameParam, $primaryKey, $idParam);
}
?>

<script>
    window.location = '<?php echo $tableUrl; ?>';
</script>

<?php
exit;
?>
