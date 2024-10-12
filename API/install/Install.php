<?php

require '../Database/Database.php';

class Install extends Database
{
    /**
     * @throws Exception
     */

    public function createTables($tables): string
    {
        $msg = "";
        $sql = "";
        foreach ($tables as $tbl) {
            ['name' => $name, 'fields' => $fields] = $tbl;
            $msg .= "Creating table $name.\n<br />";
            $sql .= "CREATE TABLE IF NOT EXISTS `$name`(";
            foreach ($fields as $field) {
                $sql .= "$field,";
            }
            // remove last comma, add ); => so the table sql command will be completed
            $sql = substr($sql, 0, -1) . ");";
        }
        $this->pdo->exec($sql);
        return $msg;
    }

    public function __construct($tables, $categories, $products)
    {
        $msg = $this->createTables($tables);


        $this->insertCategories($categories);
        $this->insertProducts($products);
    }
}