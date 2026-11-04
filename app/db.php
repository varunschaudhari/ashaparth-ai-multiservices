<?php
/**
 * Lazy PDO connection. Returns null (and logs) if the database is not
 * configured or unreachable, so the site keeps working and forms still email.
 */

defined('APP_ROOT') || exit;

function db(): ?PDO
{
    static $pdo = false;
    if ($pdo !== false) {
        return $pdo;
    }

    $cfg = config('db', []);
    if (empty($cfg['name']) || empty($cfg['user'])) {
        app_log('db', 'Database not configured (app/config.local.php).');
        return $pdo = null;
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
        $cfg['host'] ?? 'localhost',
        (int) ($cfg['port'] ?? 3306),
        $cfg['name']
    );

    try {
        $pdo = new PDO($dsn, $cfg['user'], $cfg['password'] ?? '', [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ]);
    } catch (PDOException $ex) {
        app_log('db', 'Connection failed: ' . $ex->getMessage());
        $pdo = null;
    }
    return $pdo;
}

/** Insert a row and return its id, or null on failure. Column names are trusted (from code). */
function db_insert(string $table, array $row): ?int
{
    $pdo = db();
    if (!$pdo) {
        return null;
    }
    $cols = array_keys($row);
    $sql  = sprintf(
        'INSERT INTO `%s` (`%s`) VALUES (%s)',
        $table,
        implode('`,`', $cols),
        implode(',', array_fill(0, count($cols), '?'))
    );
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($row));
        return (int) $pdo->lastInsertId();
    } catch (PDOException $ex) {
        app_log('db', "Insert into $table failed: " . $ex->getMessage());
        return null;
    }
}
