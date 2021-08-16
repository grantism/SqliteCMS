<?php
require_once 'database.php';

class LogChanges
{
    private Database $dao;

    public static string $updateTableName = 'bdi_cms_update';

    public function __construct($dao)
    {
        $this->dao = $dao;

        $this->createUpdateTables();
    }

    // if it doesn't exist, create the tables to track updates.
    private function createUpdateTables()
    {
        $updateTable = $this->dao->getTable(self::$updateTableName);
        if (!$updateTable) {
            $this->dao->db->query(
                "create table '" . self::$updateTableName . "' (
                    id integer not null
                       constraint bdi_cms_update_pk
                       primary key autoincrement,
	                query text not null
	            )"
            );
        }
    }

    public function getAllUpdates(): ?array
    {
        $result = $this->dao->db->query(
            "SELECT * FROM " . self::$updateTableName
        );

        return $this->dao->fetchAllRows($result);
    }
}

