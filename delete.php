<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
if (!isset($conn)) {
    die("❌ Database connection variable \$conn is not set.");
}
if (!isset($_GET['id'])) {
    header("Location: index.php?status=error");
    exit;
}

$id = $_GET['id'];

$query = "DELETE FROM dispatch WHERE id = $1";
$result = pg_query_params($conn, $query, array($id));

pg_close($conn);

if ($result) {
    header("Location: index.php?status=deleted");
    exit;
} else {
    header("Location: index.php?status=error");
    exit;
}
?>
