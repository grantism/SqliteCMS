<?php

/**
 * Class Database
 */
class Database
{
    /**
     * @var SQLite3
     */
    public SQLite3 $db;

    /**
     * SqlLite constructor.
     */
    public function __construct()
    {
        $this->db = new SQLite3('/Applications/MAMP/htdocs/bdiCms/db/app_database.sqlite');
    }

    /**
     * @return array
     */
    public function getTables(): array
    {
        $result = $this->db->query(
            "SELECT * 
                FROM sqlite_master
                WHERE type = 'table'
                    AND name NOT LIKE '%sqlite%'
                    AND name NOT LIKE '%".LogChanges::$updateTableName."%'
                ORDER BY name;"
        );

        return $this->fetchAllRows($result);
    }

    /**
     * @param string $name
     * @return array
     */
    public function getTable(string $name): ?array
    {
        $result = $this->db->query(
            "SELECT * 
                FROM sqlite_master
                WHERE type = 'table'
                AND name = '$name';"
        );

        return $this->fetchAllRows($result);
    }

    /**
     * @param string $tableName
     * @return array|null
     */
    public function getForeignKeys(string $tableName): ?array
    {
        $result = $this->db->query("PRAGMA foreign_key_list($tableName);");
        return $this->fetchAllRows($result);
    }

    /**
     * @param $tableName
     * @return array
     */
    public function getColumns($tableName): ?array
    {
        $result = $this->db->query("PRAGMA table_info($tableName);");
        return $this->fetchAllRows($result);
    }

    /**
     * @param string $tableName
     * @return ?string
     */
    public function getPrimaryKey(string $tableName): ?string
    {
        $result = $this->db->query("PRAGMA table_info($tableName);");
        $columns = $this->fetchAllRows($result);
        $key = array_search(1, array_column($columns, 'pk'));
        if (is_int($key)) {
            return $columns[$key]['name'];
        }

        return null;
    }

    /**
     * @param string $tableName
     * @param int $mode
     * @return array|null
     */
    public function getAllRows(string $tableName, int $mode = SQLITE3_ASSOC): ?array
    {
        $result = $this->db->query(
            "SELECT * 
            FROM $tableName;"
        );
        return $this->fetchAllRows($result, $mode);
    }

    public function getRow($tableName, $primaryKey, $primaryKeyValue, $mode = SQLITE3_ASSOC)
    {
        $result = $this->db->query(
            "SELECT * 
            FROM $tableName
            WHERE $primaryKey = '$primaryKeyValue';"

        );
        return $this->fetchOneRow($result, $mode);
    }

    /**
     * @param SQLite3Result $result
     * @param int $mode
     * @return array|null
     */
    public function fetchAllRows(SQLite3Result $result, int $mode = SQLITE3_ASSOC): ?array
    {
        $rows = array();
        while ($row = $result->fetchArray($mode)) {
            $rows[] = $row;
        }

        return (count($rows) > 0) ? $rows : null;
    }


    /**
     * @param SQLite3Result $result
     * @param int $mode
     * @return array|false
     */
    private function fetchOneRow(SQLite3Result $result, int $mode = SQLITE3_ASSOC)
    {
        return $result->fetchArray($mode);
    }


    public function insert($tableName, $data)
    {
        $keys = array_keys($data);
        $values = $this->prepareInsertValues(array_values($data));

        $sql = 'INSERT INTO ' . $tableName . '(';
        $sql .= implode(',', $keys);
        $sql .= ')';
        $sql .= ' VALUES(';
        $sql .= implode(',', $values);
        $sql .= ')';

        if ($this->db->exec($sql)) {
            $this->logChange($sql);
        }
    }

    public function update($tableName, $primaryKey, $primaryKeyValue, $data)
    {
        $keys = array_keys($data);
        $values = $this->prepareInsertValues(array_values($data));

        $data = array_combine($keys, $values);
        $updateData = array();
        foreach ($data as $key => $value) {
            $updateData[] = $key . '=' . $value;
        }

        $sql = 'UPDATE ' . $tableName . ' SET ' . implode(', ', $updateData) . ' WHERE ' . $primaryKey . '=' . $primaryKeyValue;

        if ($this->db->exec($sql)) {
            $this->logChange($sql);
        }
    }

    public function delete($tableName, $primaryKey, $primaryKeyValue)
    {
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $primaryKey . '=' . $primaryKeyValue;

        if ($this->db->exec($sql)) {
            $this->logChange($sql);
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareInsertValues(array $data): array
    {
        foreach ($data as $k => $v) {
            if (is_numeric($v) || is_bool($v)) {
                $data[$k] = $v;
            } else {
                $data[$k] = "'" . SQLite3::escapeString($v) . "'";
            }
        }

        return $data;
    }


    private function logChange(string $query)
    {
        $this->db->query(
            "INSERT INTO " . LogChanges::$updateTableName . "
                (query)
            VALUES
                ('" . SQLite3::escapeString($query) . "')"
        );
    }
}
