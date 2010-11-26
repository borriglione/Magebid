<?php
// $Id: EbatNs_DatabaseProvider.php,v 1.2 2008-05-02 15:04:05 carsten Exp $
// $Log: EbatNs_DatabaseProvider.php,v $
// Revision 1.2  2008-05-02 15:04:05  carsten
// Initial, PHP5
//
//
class EbatNs_DatabaseConfig
{
    protected $host;

    protected $database;

    protected $user;

    protected $password;

    function setConfig ($host, $db, $user, $password)
    {
        $this->host = $host;
        $this->database = $db;
        $this->user = $user;
        $this->password = $password;
    }
}

class EbatNs_DatabaseProvider extends EbatNs_DatabaseConfig
{
    protected $dbHandle;

    function __construct()
    {
    }

    function getConnection ()
    {
        if ($this->dbHandle === null)
        {
            $this->dbHandle = mysql_pconnect($this->host, $this->user, $this->password, 0);
            mysql_select_db($this->database, $this->dbHandle);
        }
        return $this->dbHandle;
    }

    function getGeneratedId ()
    {
        return mysql_insert_id($this->getConnection());
    }

    function executeInsert ($table, $rowData)
    {
        $sql = 'insert into ' . $table . ' ';
        $sql .= '(' . join(',', array_keys($rowData)) . ') ';
        $sql .= 'values (';
        
        foreach ($rowData as $k => $v)
        {
            $rowData[$k] = "'" . addslashes($v) . "'";
        }
        
        $sql .= join(',', $rowData) . ')';
        $this->executeSql($sql);
        return $this->getGeneratedId();
    }

    function executeUpdate ($table, $rowData, $priKeyName, $priKeyValue, $extraCondition = null)
    {
        $sql = 'update ' . $table . ' set ';
        
        if (array_key_exists($priKeyName, $rowData))
            unset($rowData[$priKeyName]);
        
        $updateData = array();
        foreach ($rowData as $k => $v)
        {
            $updateData[] = $k . "= '" . addslashes($v) . "'";
        }
        
        $sql .= join(',', $updateData);
        $sql .= " where $priKeyName ='$priKeyValue'";
        if ($extraCondition)
            $sql .= ' and ' . $extraCondition;
        return $this->executeSqlNoQuery($sql, null);
    }

    function executeDelete ($table, $priKeyName, $priKeyValue)
    {
        $sql = 'delete from ' . $table;
        $sql .= ' where ' . $priKeyName . "='" . $priKeyValue . "'";
        return $this->executeSqlNoQuery($sql);
    }

    function executeSqlNoQuery ($sql, $dbHandle = null)
    {
        $rs = $this->executeSql($sql, $dbHandle);
        if ($rs)
        {
            if ($dbHandle === null)
            {
                return mysql_affected_rows($this->dbHandle); 
            } else {
                return mysql_affected_rows($dbHandle);
            }
        } else {
            return 0;
        }
    }

    // executes a sql-statement against the db. Any errors will be printed on screen !
    function executeSql ($sql, $dbHandle = null)
    {
        if ($dbHandle == null)
            $dbHandle = $this->getConnection();
        
        $rs = mysql_query($sql, $dbHandle);
        
        return $rs;
    }

    // Execute the statement and then fetches ALL rows
    function querySqlSet ($sql, $dbHandle = null)
    {
        if ($dbHandle === null)
        {
            $dbHandle = $this->getConnection();
        }
        
        $rs = $this->executeSql($sql, $dbHandle);
        $rows = array();
        while ($row = @mysql_fetch_assoc($rs))
        {
            if ($row)
                $rows[] = $row;
        }
        
        @mysql_free_result($rs);
        
        return $rows;
    }

    function querySql ($sql, $dbHandle = null)
    {
        if ($dbHandle === null)
        {
            $dbHandle = $this->getConnection();
        }
        
        $rs = $this->executeSql($sql, $dbHandle);
        
        $row = @mysql_fetch_assoc($rs);
        @mysql_free_result($rs);
        
        return $row;
    }
}
?>