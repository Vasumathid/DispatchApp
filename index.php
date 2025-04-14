<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if search term is set
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Build the query with a WHERE clause if search term is present
$query = "SELECT * FROM dispatch";
if ($searchTerm != '') {
    // Use LIKE for partial matching, with wildcards around the search term
    $query .= " WHERE dispatch_number LIKE '%$searchTerm%' 
                OR received_from LIKE '%$searchTerm%' 
                OR subject LIKE '%$searchTerm%' 
                OR signature LIKE '%$searchTerm%'";
}
$query .= " ORDER BY id ASC";

// Fetch filtered results from the dispatch table
$result = pg_query($conn, $query);

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
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input {
            padding: 8px;
            width: 300px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h2>📄 Dispatch List</h2>
    

    <!-- Status Message -->
    <?php if (isset($_GET['status'])): ?>
    <div id="statusMessage" style="padding: 10px; border-radius: 6px; margin-bottom: 20px;
        <?php echo $_GET['status'] == 'success' ? 'background-color: #d4edda; color: #155724;' : 'background-color: #f8d7da; color: #721c24;'; ?>">
        <?php
            switch ($_GET['status']) {
                case 'updated':
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
    <!-- Search Form -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search by Dispatch Number, Received From, Subject, or Signature">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Table -->
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
