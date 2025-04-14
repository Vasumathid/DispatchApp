<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';  // Ensure db.php is included to establish the connection.
if (!isset($conn)) {
    die("❌ Database connection variable \$conn is not set.");
}
if (!isset($_GET['id'])) {
    echo "No ID provided.";
    exit;
}

$id = $_GET['id'];

// Delete query
$query = "DELETE FROM dispatch WHERE id = $1";
$result = pg_query_params($conn, $query, array($id));

if ($result) {
    echo "Record deleted successfully!";
} else {
    echo "<p style='color:red;'>Error deleting record: " . pg_last_error($conn) . "</p>";
}

pg_close($conn);  // Close the connection after the query is executed.
?>
