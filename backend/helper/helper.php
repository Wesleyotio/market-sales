<?php

declare(strict_types=1);

/**
 * Formata uma data no formato yyyy/mm/dd H:i:s
 *
 * @param string $date
 * @return DateTimeImmutable
 */
function formatDate(string $date): DateTimeImmutable 
{
    return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date);
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

/**
 * valida se um array possui todas as chaves esperadas
 *
 * @param array $requireKeys
 * @param array $arrayForCheck
 * @return bool 
 */
function validateArrayKeys(array $requireKeys, array $arrayForCheck): bool 
{
    $missingKeys = array_diff($requireKeys, array_keys($arrayForCheck));
    return empty($missingKeys);
}

/**
 * valida se as chaves um array está contido na chaves em outro array
 *
 * @param array $subArrayKeys
 * @param array $superArrayKeys
 * @return bool 
 */
function validateKeysContainedInArray(array $subArrayKeys, array $superArrayKeys): bool 
{
    foreach ($subArrayKeys as $key) {
        if (!in_array($key, $superArrayKeys)) {
            return false;
        }
    }
    return true;
}