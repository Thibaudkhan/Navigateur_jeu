<?php

//====================================================
// INCLUDES
//====================================================
require_once("./constants/db.inc.php");


//====================================================
// FUNCTIONS
//====================================================
// Create database
function initBase($pdo, $bdName)
{
    $req = "DROP DATABASE IF EXISTS `".$bdName."`";
    if( $pdo->exec($req) === FALSE )
    {
        echo "[ERROR] drop base '$bdName'.<br>"; 
        print_r($pdo->errorInfo());
        exit();
    }
    else
    {
        echo "[OK] drop base '$bdName'.<br>";
    }
    
    $req = "CREATE DATABASE `".$bdName."`";
    if( $pdo->exec($req) === FALSE )
    {
        echo "[ERROR] create base '$bdName'.<br>";
        print_r($pdo->errorInfo());
        exit();
    }
    else
    {
        echo "[OK] create base '$bdName'.<br>";
    }
}
// Create table
function createTable($pdo, $dbName, $tableName, $fields, $primary, $unique, $foreign, $engine)
{
    // Prepare request
    $req = "CREATE TABLE `$dbName`.`$tableName` (";
    // Fields
    $first = TRUE;
    foreach($fields as $k=>$v)
    {
        if(!$first)
        {
            $req .= ",";    
        }
        $first = FALSE;
        $req .= "`$k` $v";
    }
    // Primary key
    $req .= ", PRIMARY KEY (`$primary`)";
    // Unique 
    foreach($unique as $k=>$v)
    {
        $fk = $tableName."_".str_replace(" ","",str_replace(",","",$v));
        $req .= ",UNIQUE `$fk` ($v)";    
    }
    // Foreign keys
    foreach($foreign as $localField=>$foreignData)
    {
        $foreignTable    = $foreignData[0];
        $foreignField    = $foreignData[1];
        $foreignTableLow = strtolower($foreignTable);
        $foreignFieldLow = strtolower($foreignField);
        $localTableLow   = strtolower($tableName);
        $localFieldLow   = strtolower($localField);
        $req .= ", CONSTRAINT fk_". $localTableLow ."_". $foreignTableLow ."_". $foreignFieldLow ." FOREIGN KEY (". $localField .") REFERENCES ". $foreignTable ."(". $foreignField .")";
    }
    // Engine
    $req .= ") ENGINE = $engine;";
    // Execute request
    if( $pdo->exec($req) === FALSE )
    {
        echo "[ERROR] create table '$tableName' [ <font size=1 color=red>$req</font> ].<br>";
        print_r($pdo->errorInfo());
        exit();
    }
    else
    {
        echo "[OK] create table '$tableName' [ <font size=1 color=blue>$req</font> ].<br>";
    }
}
// Insert an entry into a table
function insertEntry($pdo, $dbName, $tableName, $fields)
{
    // Prepare Fields
    $F = "";
    $V = "";
    $first = TRUE;
    foreach( $fields as $k=>$v )
    {
        if(!$first)
        {
            $F .= ",";
            $V .= ",";    
        }
        $first = FALSE;
        $F .= $k ;
        $V .= "'". $v ."'";
    }
    // Prepare request
    $req = "INSERT INTO `". $tableName ."` (". $F .") VALUES (". $V .");" ;
    // Execute request
    if( $pdo->exec($req) === FALSE )
    {
        echo "[ERROR] insert into '$tableName' [ <font size=1 color=red>$req</font> ].<br>";    
        print_r($pdo->errorInfo());
        exit();
    }
    else
    {
        echo "[OK] insert into '$tableName' [ <font size=1 color=blue>$req</font> ].<br>";    
    }
}



//===============================================================================================================================
// CREATE BASE AND TABLES
//===============================================================================================================================
// Connect to Server
$db = new PDO("mysql:host=".DB_SERVER,DB_LOGIN,DB_PASSWORD); 
// (re)create base
initBase($db, DB_BASE);
// Connect to DB
$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_BASE,DB_LOGIN,DB_PASSWORD); 


//------------------------------
$table = T_USERS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]              = "INT NOT NULL AUTO_INCREMENT";
$fields["login"]           = "VARCHAR(64) NOT NULL";
$fields["password"]        = "VARCHAR(64) NOT NULL";
$fields["email"]           = "VARCHAR(128) NOT NULL";
$fields["creationDate"]    = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$fields["lastConnectDate"] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$fields["nbConnect"]       = "INT NOT NULL DEFAULT 0";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "login";
$unique[] = "email";
// Prepare foreign keys
$foreign = array();
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_BANNERS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]              = "INT NOT NULL AUTO_INCREMENT";
$fields["url"]             = "VARCHAR(64) NOT NULL";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "url";
// Prepare foreign keys
$foreign = array();
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_ETHNICS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]       = "INT NOT NULL AUTO_INCREMENT";
$fields["bannerId"] = "INT NOT NULL";
$fields["name"]     = "VARCHAR(64) NOT NULL";
$fields["color"]    = "VARCHAR(6) NOT NULL DEFAULT 000000";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["bannerId"] = array(T_BANNERS, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_CLANS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]           = "INT NOT NULL AUTO_INCREMENT";
$fields["leaderId"]     = "INT NOT NULL";
$fields["bannerId"]     = "INT NOT NULL";
$fields["ethnicId"]     = "INT NOT NULL";
$fields["name"]         = "VARCHAR(64) NOT NULL";
$fields["color"]        = "VARCHAR(6) NOT NULL DEFAULT 000000";
$fields["creationDate"] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["ethnicId"] = array(T_ETHNICS, "id");
$foreign["leaderId"] = array(T_USERS  , "id");
$foreign["bannerId"] = array(T_BANNERS, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_FACTIONS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]           = "INT NOT NULL AUTO_INCREMENT";
$fields["creatorId"]    = "INT NOT NULL";
$fields["bannerId"]     = "INT NOT NULL";
$fields["name"]         = "VARCHAR(64) NOT NULL";
$fields["color"]        = "VARCHAR(6) NOT NULL DEFAULT 000000";
$fields["creationDate"] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["creatorId"] = array(T_CLANS  , "id");
$foreign["bannerId"]  = array(T_BANNERS, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_CLAN2FACTION;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]        = "INT NOT NULL AUTO_INCREMENT";
$fields["clanId"]    = "INT NOT NULL";
$fields["factionId"] = "INT NOT NULL";
$fields["linkDate"]  = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "clanId";
// Prepare foreign keys
$foreign = array();
$foreign["clanId"]    = array(T_CLANS   , "id");
$foreign["factionId"] = array(T_FACTIONS, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_STATS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]        = "INT NOT NULL AUTO_INCREMENT";
$fields["level"]     = "INT NOT NULL DEFAULT 0";
$fields["xp"]        = "INT NOT NULL DEFAULT 0";
$fields["damage"]    = "INT NOT NULL DEFAULT 10";
$fields["shield"]    = "INT NOT NULL DEFAULT 10";
$fields["dexterity"] = "INT NOT NULL DEFAULT 10";
$fields["life"]      = "INT NOT NULL DEFAULT 100";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
// Prepare foreign keys
$foreign = array();
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_RESOURCES;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]    = "INT NOT NULL AUTO_INCREMENT";
$fields["wood"]  = "INT NOT NULL DEFAULT 0";
$fields["rock"]  = "INT NOT NULL DEFAULT 0";
$fields["water"] = "INT NOT NULL DEFAULT 0";
$fields["metal"] = "INT NOT NULL DEFAULT 0";
$fields["gold"]  = "INT NOT NULL DEFAULT 0";
$fields["gem"]   = "INT NOT NULL DEFAULT 0";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
// Prepare foreign keys
$foreign = array();
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_TOWNS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]           = "INT NOT NULL AUTO_INCREMENT";
$fields["clanId"]       = "INT NOT NULL";
$fields["statId"]       = "INT NOT NULL";
$fields["name"]         = "VARCHAR(64) NOT NULL";
$fields["posX"]         = "INT NOT NULL";
$fields["posY"]         = "INT NOT NULL";
$fields["size"]         = "INT NOT NULL DEFAULT 1";
$fields["creationDate"] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["clanId"] = array(T_CLANS, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_UNIT_TYPES;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]         = "INT NOT NULL AUTO_INCREMENT";
$fields["resourceId"] = "INT NOT NULL";
$fields["name"]       = "VARCHAR(64) NOT NULL";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["resourceId"] = array(T_RESOURCES, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_UNITS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]           = "INT NOT NULL AUTO_INCREMENT";
$fields["clanId"]       = "INT NOT NULL";
$fields["typeId"]       = "INT NOT NULL";
$fields["statId"]       = "INT NOT NULL";
$fields["townId"]       = "INT NOT NULL";
$fields["name"]         = "VARCHAR(64) NOT NULL";
$fields["creationDate"] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
// Prepare foreign keys
$foreign = array();
$foreign["clanId"] = array(T_CLANS     , "id");
$foreign["typeId"] = array(T_UNIT_TYPES, "id");
$foreign["statId"] = array(T_STATS     , "id");
$foreign["townId"] = array(T_TOWNS     , "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_BUILDING_TYPES;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]         = "INT NOT NULL AUTO_INCREMENT";
$fields["resourceId"] = "INT NOT NULL";
$fields["name"]       = "VARCHAR(64) NOT NULL";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["resourceId"] = array(T_RESOURCES, "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);


//------------------------------
$table = T_BUILDINGS;
//------------------------------
// Prepare table fields
$fields = array();
$fields["id"]           = "INT NOT NULL AUTO_INCREMENT";
$fields["statId"]       = "INT NOT NULL";
$fields["typeId"]       = "INT NOT NULL";
$fields["townId"]       = "INT NOT NULL";
$fields["name"]         = "VARCHAR(64) NOT NULL";
$fields["creationDate"] = "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
// Prepare table primary
$primary = "id";
// Prepare table uniques
$unique   = array();
$unique[] = "name";
// Prepare foreign keys
$foreign = array();
$foreign["typeId"] = array(T_BUILDING_TYPES, "id");
$foreign["statId"] = array(T_STATS         , "id");
$foreign["townId"] = array(T_TOWNS         , "id");
// Launch the table creation request
createTable($db, DB_BASE, $table, $fields, $primary, $unique, $foreign, DB_ENGINE);





















/*

//===============================================================================================================================
// FILL TABLES
//===============================================================================================================================


//---------------------
//----- Add USERS -----
//---------------------
// Admin romuald
$fields                              = array();
$fields[DB_FIELD_USERS_NAME]     = "GRIGNON";
$fields[DB_FIELD_USERS_FNAME]    = "Romuald";
$fields[DB_FIELD_USERS_LOGIN]    = "romu";
$fields[DB_FIELD_USERS_PASSWORD] = hash("sha256", "romu");
$fields[DB_FIELD_USERS_ROLE]     = DB_VALUE_USERS_ROLE_ADMIN;
insertEntry($db, DB_BASE, DB_TABLE_USERS, $fields);
// Super users
for($i=1;$i<=10;$i++)
{
    // Super user
    $fields                              = array();
    $fields[DB_FIELD_USERS_NAME]     = "NAME_SUPER_$i";
    $fields[DB_FIELD_USERS_FNAME]    = "Firstname_Super_$i";
    $fields[DB_FIELD_USERS_LOGIN]    = "superuser$i";
    $fields[DB_FIELD_USERS_PASSWORD] = hash("sha256", "superuser$i");
    $fields[DB_FIELD_USERS_ROLE]     = DB_VALUE_USERS_ROLE_SUPER;
    insertEntry($db, DB_BASE, DB_TABLE_USERS, $fields);
}
// Users
for($i=1;$i<=10;$i++)
{
    // Normal users
    $fields                              = array();
    $fields[DB_FIELD_USERS_NAME]     = "NAME_$i";
    $fields[DB_FIELD_USERS_FNAME]    = "Firstname_$i";
    $fields[DB_FIELD_USERS_LOGIN]    = "user$i";
    $fields[DB_FIELD_USERS_PASSWORD] = hash("sha256", "user$i");
    $fields[DB_FIELD_USERS_ROLE]     = DB_VALUE_USERS_ROLE_NORMAL;
    insertEntry($db, DB_BASE, DB_TABLE_USERS, $fields);
}
// Bank account
for($i=1;$i<=21;$i++)
{
    $fields                              = array();
    $fields[DB_FIELD_BANK_OWNERID]   = $i;
    $fields[DB_FIELD_BANK_DATE]      = date("Y-m-d H:i:s",time()-rand(0,10*365*24*3600));
    $fields[DB_FIELD_BANK_BALANCE]   = 0;
    $fields[DB_FIELD_BANK_OVERDRAFT] = 0;
    $fields[DB_FIELD_BANK_FROZEN]    = DB_VALUE_BANK_FROZEN_FALSE;
    insertEntry($db, DB_BASE, DB_TABLE_BANK, $fields);
}

//*/


?>

