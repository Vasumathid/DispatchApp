<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all rows from the dispatch table
$result = pg_query($conn, "SELECT * FROM dispatch ORDER BY id ASC");

if (!$result) {
    echo "An error occurred.\n";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dispatch Management</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        a.button { background: #4CAF50; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
        a.edit { background: #2196F3; }
        a.delete { background: #f44336; }
    </style>
</head>
<body>
    <h2>📄 Dispatch List</h2>
    <?php if (isset($_GET['status'])): ?>
    <div id="statusMessage" style="padding: 10px; border-radius: 6px; margin-bottom: 20px;
        <?php echo $_GET['status'] == 'success' ? 'background-color: #d4edda; color: #155724;' : 'background-color: #f8d7da; color: #721c24;'; ?>">
        <?php
            switch ($_GET['status']) {
                case 'success':
                    echo "✅ Entry updated successfully!";
                    break;
                case 'created':
                    echo "✅ Entry created successfully!";
                    break;
                case 'deleted':
                    echo "🗑️ Entry deleted successfully!";
                    break;
                case 'error':
                    echo "❌ An error occurred.";
                    break;
            }
        ?>
    </div>
<?php endif; ?>



    <p><a href="create.php" class="button">+ Add New Dispatch</a></p>
    <a href="export.php" class="btn btn-success">Download Excel</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Dispatch Number</th>
            <th>Received From</th>
            <th>Subject</th>
            <th>Signature</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = pg_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['dispatch_number']) ?></td>
            <td><?= htmlspecialchars($row['received_from']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= htmlspecialchars($row['signature']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="button edit">✏️ Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="button delete" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<script>
    setTimeout(() => {
        const msg = document.getElementById('statusMessage');
        if (msg) {
            msg.style.transition = 'opacity 0.5s ease, transform 0.3s ease'; // Adding transform for a slight movement
            msg.style.opacity = '0';
            msg.style.transform = 'translateY(-10px)'; // Moving message upwards before fading out
            setTimeout(() => msg.remove(), 800); // Remove from DOM after complete fade out
        }
    }, 5000); // 5 seconds
</script>
