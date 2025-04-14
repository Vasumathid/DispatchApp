<?php
include 'db.php';

// Redirect to index if no ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Fetch existing record
$query = "SELECT * FROM dispatch WHERE id = $1";
$result = pg_query_params($conn, $query, array($id));
$data = pg_fetch_assoc($result);

if (!$data) {
    echo "<p style='color:red;'>Record not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Dispatch Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin: auto;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #008080;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }
        button:hover {
            background-color: #006666;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Dispatch Entry</h2>
    <form method="POST" action="">
        <label>Dispatch Number:</label>
        <input type="text" name="dispatch_number" value="<?php echo $data['dispatch_number']; ?>" required>

        <label>Received From:</label>
        <input type="text" name="received_from" value="<?php echo $data['received_from']; ?>" required>

        <label>Subject:</label>
        <textarea name="subject" required><?php echo $data['subject']; ?></textarea>

        <label>Signature:</label>
        <input type="text" name="signature" value="<?php echo $data['signature']; ?>" required>

        <button type="submit" name="update">Update Entry</button>
    </form>

    <?php
    if (isset($_POST['update'])) {
        $dispatch_number = $_POST['dispatch_number'];
        $received_from = $_POST['received_from'];
        $subject = $_POST['subject'];
        $signature = $_POST['signature'];

        $updateQuery = "UPDATE dispatch 
                        SET dispatch_number = $1, received_from = $2, subject = $3, signature = $4 
                        WHERE id = $5";

        $result = pg_query_params($conn, $updateQuery, array($dispatch_number, $received_from, $subject, $signature, $id));

        if ($result) {
            echo "<p style='color:green;'>✅ Entry updated successfully!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . pg_last_error($conn) . "</p>";
        }
    }

    pg_close($conn);
    ?>
</div>
</body>
</html>
