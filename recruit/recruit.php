<?php
class ProductCore extends ObjectModel {
    public static $definition = array(
        'table' => 'studentsrating',
        'multilang' => true,
        'fields' => array(
            'id_studenta' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUusignedId'
            ),
            'name' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isCatalogName',
                'required' => true,
                'size' => 128
            ),
            'data' => array(
                'type' => self::TYPE_DATE,
                'validate' => 'isDate'
            ),
            'status_studenta' => array(
                'type' => self::TYPE_BOOL
            ),
            'ball' => array(
                'type' => self::TYPE_INT
            )
        ),
    );
};

$sql = 'SELECT `id_studenta`, `name`, `data`, `status_studenta`, `ball`
        FROM studentsrating
        WHERE `name` OR `ball`, OR `ball`';