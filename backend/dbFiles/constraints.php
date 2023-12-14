<?php

class Constraints{
    public static function addForignKey($tableName, $columnName, $referenceTableName, $referenceColumnName){
        $conn =Connect::makeConnection();

        $sql = "ALTER TABLE $tableName ADD FOREIGN KEY ($columnName) REFERENCES $referenceTableName($referenceColumnName)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

?>