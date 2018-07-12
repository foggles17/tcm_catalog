<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/30/2015
 * Time: 11:40 PM
 */
function dropTables()
{
    dropTable("tcm_catalog_items");
    dropTable("tcm_catalog_catalogs");
    dropTable("tcm_catalog_catalog_items");
}
function createTables()
{
    $itemsSchema = "id mediumint(9) NOT NULL AUTO_INCREMENT,
					name tinytext NOT NULL,
					description text,
					price REAL PRECISION(9,2),
					PRIMARY KEY (id)";

    $catalogsSchema  = "id mediumint(9) NOT NULL AUTO_INCREMENT,
					name tinytext NOT NULL,
					PRIMARY KEY (id)";

    $catalogItemsSchema  = "catalogId mediumint(9) NOT NULL,
					itemId mediumint(9) NOT NULL";

    createTable("tcm_catalog_items", $itemsSchema);
    createTable("tcm_catalog_catalogs", $catalogsSchema);
    createTable("tcm_catalog_catalog_items", $catalogItemsSchema);
}
function createTable ($table_name, $schema)
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (" . $schema . ")$charset_collate";
    $wpdb ->query($sql);
}
function dropTable($table_name)
{
    global $wpdb;
    $wpdb->query(
        "
          DROP TABLE IF EXISTS $table_name;
        "
    );
}
function tcm_databasePage()
{
    require('tcm_catalog_database_functions.php');
}
function tcm_catalogPage()
{
    global $wpdb;
    $php_database_file = TCM_CATALOG__PLUGIN_URL . 'tcm_catalog.php';
    $table = $wpdb->get_results("SELECT * FROM tcm_catalog_items");
    $catalogTable = $wpdb->get_results("SELECT * FROM tcm_catalog_catalogs");

    echo "
        <!-- Insert -->
        <h1>Insert</h1>
        <form action='$php_database_file' method='post' id='tcm_insert_form'>
            Item Name: <input type='text' name='insert_name' value='New Item'><br>
            Item Description: <input type='text' name='insert_description'><br>
            Item Price: <input type='number' name='insert_price' min='0' step='.01' value='19.95'><br>
        </form>
        <button type='submit' form='tcm_insert_form' value='Submit'>Insert</button>";

    if(count($table) > 0) {
        echo "
        <br/>


        <!-- Delete -->
        <h1>Delete</h1>
        <form action='$php_database_file' method='post' id='tcm_delete_form'>";
        for ($i = 0; $i < count($table); $i++) {
            $id = $table[$i]->id;
            $name = $table[$i]->name;
            echo "
            <input type='radio' name='delete_id' value='$id'>$id) $name
            <br/>
            ";
        }
        echo "
            <br/>
        </form>
        <button type='submit' form='tcm_delete_form' value='Submit'>Delete</button>
        <br/>


        <!-- Edit -->
        <h1>Edit</h1>
        <form action='$php_database_file' method='post' id='tcm_edit_form'>";
        for ($i = 0; $i < count($table); $i++) {
            $id = $table[$i]->id;
            $name = $table[$i]->name;
            echo "
            <input type='radio' name='edit_id' value='$id'>$id) $name
            <br/>
            ";
        }
        echo "
            <br/>
            Item Name: <input type='text' name='edit_name' value='" . $table[0]->name . "'><br>
            Item Description: <input type='text' name='edit_description' value='" . $table[0]->description . "'>
            Item Price: <input type='number' name='edit_price' min='0' step='.01' value='". $table[0]->price ."'><br>
            <br/>
        </form>
        <button type='submit' form='tcm_edit_form' value='Submit'>Edit</button>
        <br/>

        <table>
            <tr>
                <th style='border:1px solid #BBBBBB'>ID</th>
                <th style='border:1px solid #BBBBBB'>Name</th>
                <th style='border:1px solid #BBBBBB'>Description</th>
                <th style='border:1px solid #BBBBBB'>Price</th>
            </tr>
            ";
        for ($i = 0; $i < count($table); $i++) {
            $id = $table[$i]->id;
            $name = $table[$i]->name;
            $description = $table[$i]->description;
            $price = $table[$i]->price;
            echo "
            <tr>
                <td style='border:1px solid #BBBBBB'>$id</td>
                <td style='border:1px solid #BBBBBB'>$name</td>
                <td style='border:1px solid #BBBBBB'>$description</td>
                <td style='border:1px solid #BBBBBB'>$price</td>
            </tr>
            ";
        }
        echo "
        </table>
        ";
    }
    else
    {
        echo "
        <br/>
        The table is empty.";
    }
    echo "
    <!-- Add Item to Catalog -->
        <h1>Add Item to Catalog</h1>
        <form action='$php_database_file' method='post' id='tcm_add_to_catalog_form'>";
        for ($i = 0; $i < count($table); $i++) {
            $id = $table[$i]->id;
            $name = $table[$i]->name;
            echo "
            <input type='radio' name='add_item_id' value='$id'>$id) $name
            <br/>
            ";
        }
        for ($i = 0; $i < count($catalogTable); $i++) {
            $id = $catalogTable[$i]->id;
            $name = $catalogTable[$i]->name;
            echo "
            <input type='radio' name='add_catalog_id' value='$id'>$id) $name
            <br/>
                ";
        }
    echo "
        </form>
    <!-- Insert Catalog -->
        <h1>Insert Catalog</h1>
        <form action='$php_database_file' method='post' id='tcm_insert_catalog_form'>
            Catalog Name: <input type='text' name='insert_catalog_name' value='New Item'><br>
        </form>
        <button type='submit' form='tcm_insert_catalog_form' value='Submit'>Insert</button>";
}