<?php
class ProductCore extends ObjectModel {
    public static $definition = array(
        'table' => 'studentsrating',
        'multilang' => true,
        'fields' => array(
            'id_name' => array(
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
            'status_student' => array(
                'type' => self::TYPE_BOOL
            ),
            'score' => array(
                'type' => self::TYPE_INT
            )
        ),
    );
};

$sql = 'SELECT `id_name`, `name`, `data`, `status_student`, AVG(score)
FROM `'._DB_PEFIX_.'studentsrating' `score`'