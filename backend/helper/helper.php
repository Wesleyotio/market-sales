<?php

/**
 * Formata uma data no formato yyyy/mm/dd H:i:s
 *
 * @param string $date
 * @return Datetime
 */
function formatDate($date) {
    return  date_create_from_format('Y-m-d H:i:s', $date);
}


/**
 * valida se é um objeto PDO valido
 *
 * @param mixed $pdoStatement
 * @return void 
 */
function validatePDO (mixed $pdoStatement): void
{
    if (!$pdoStatement) {
        throw new PDOStatement('failure to obtain a pdoStatement');
    }
}

/**
 * valida se é um objeto JSON valido
 *
 * @param string $objectData
 * @return void 
 */
function validateJson(string $objectData): void 
{
    if (!json_validate($objectData)) {
        throw new JsonException('Json for object is invalid');
    }
}