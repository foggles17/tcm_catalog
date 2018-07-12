<?php
/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 10/31/2015
 * Time: 2:30 AM
 */
/*
include_once("../../../wp-config.php");

echo "
    <html>
        <head>
            <title>Database</title>
        </head>
        <body>
You being on this page means you tried to do something with the database.";*/
if(isset($_POST['insert_name']))
{
    insert();
}
elseif(isset($_POST['delete_id']))
{
    delete();
}
elseif(isset($_POST['edit_id']))
{
    edit();
}
elseif(isset($_POST['insert_catalog_name']))
{
    insertCatalog();
}
elseif(isset($_POST['add_item_id']))
{
    addToCatalog();
}
function insert() {
    if ( isset( $_POST['insert_name'] ) && isset( $_POST['insert_description'] ) && isset( $_POST['insert_price'] )) {
        $table_name       = 'tcm_catalog_items';
        $item_name        = $_POST['insert_name'];
        $item_description = $_POST['insert_description'];
        $item_price       = $_POST['insert_price'];
        $data             = array(
            'name'        => $item_name,
            'description' => $item_description,
            'price'       => $item_price
        );
        $requirements     = array(
            '%s',
            '%s',
            '%d'
        );
        insertItem( $table_name, $data, $requirements );
    }
}
function insertCatalog() {
    if ( isset( $_POST['insert_catalog_name'] )) {
        $table_name       = 'tcm_catalog_catalogs';
        $catalog_name        = $_POST['insert_catalog_name'];
        $data             = array(
            'name'        => $catalog_name,
        );
        $requirements     = array(
            '%s'
        );
        insertItem( $table_name, $data, $requirements );
    }
}
function addToCatalog() {
    if ( isset( $_POST['add_item_id'] ) && isset( $_POST['add_catalog_id'] )) {
        $table_name       = 'tcm_catalog_catalogItems';
        $catalog_id       = $_POST['add_catalog_id'];
        $item_id          = $_POST['add_item_id'];
        $data             = array(
            'catalogId'   => $catalog_id,
            'itemId'      => $item_id
        );
        $requirements     = array(
            '%s'
        );
        insertItem( $table_name, $data, $requirements );
    }
}
function edit() {
    if ( isset( $_POST['edit_id'] ) && isset( $_POST['edit_name'] ) && isset( $_POST['edit_description'] ) && isset( $_POST['edit_price'] )) {
        $table_name         = 'tcm_catalog_items';
        $item_id            = $_POST['edit_id'];
        $item_name          = $_POST['edit_name'];
        $item_description   = $_POST['edit_description'];
        $item_price         = $_POST['edit_price'];
        $data               = array(
            'name'        => $item_name,
            'description' => $item_description,
            'price'       => $item_price
        );
        $where              = array( 'id' => $item_id );
        $requirements       = array(
            '%s',
            '%s',
            '%d'
        );
        $where_requirements = array( '%d' );

        editItem( $table_name, $data, $where, $requirements, $where_requirements );
    }
}
function delete() {
    if ( isset( $_POST['delete_id'] ) ) {
        $table_name         = 'tcm_catalog_items';
        $item_id            = $_POST['delete_id'];
        $where              = array( 'id' => $item_id );
        $where_requirements = array( '%d' );

        deleteItem( $table_name, $where, $where_requirements );
    }
}


function insertItem($table_name, $data, $requirements) {
    global $wpdb;
    $wpdb->insert(
        $table_name,
        $data,
        $requirements );
}
function editItem($table_name, $data, $where, $requirements, $where_requirements) {
    global $wpdb;
    $wpdb->update(
        $table_name,
        $data,
        $where,
        $requirements,
        $where_requirements );
}
function deleteItem($table_name, $where, $where_requirements) {
    global $wpdb;
    $wpdb->delete(
        $table_name,
        $where,
        $where_requirements );
}