<?php
include 'db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=dispatch_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Dispatch Number</th>
        <th>Received From</th>
        <th>Subject</th>
        <th>Signature</th>
      </tr>";

$query = "SELECT * FROM dispatch ORDER BY id ASC";
$result = pg_query($conn, $query);

while ($row = pg_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['dispatch_number']}</td>
            <td>{$row['received_from']}</td>
            <td>{$row['subject']}</td>
            <td>{$row['signature']}</td>
          </tr>";
}

echo "</table>";

pg_close($conn);
?>