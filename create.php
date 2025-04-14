<!DOCTYPE html>
<html>
<head>
    <title>Add Dispatch Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #008080;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }
        button:hover {
            background-color: #006666;
        }
    </style>
</head>
<body>
    <h2>Add New Dispatch Entry</h2>

    <form method="POST" action="">
        <label>Dispatch Number:</label>
        <input type="text" name="dispatch_number" required>

        <label>Received From:</label>
        <input type="text" name="received_from" required>

        <label>Subject:</label>
        <textarea name="subject" required></textarea>

        <label>Signature:</label>
        <input type="text" name="signature" required>

        <button type="submit" name="submit">Add Entry</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $dispatch_number = $_POST['dispatch_number'];
        $received_from = $_POST['received_from'];
        $subject = $_POST['subject'];
        $signature = $_POST['signature'];

        $host = 'localhost';
        $port = '5432';
        $dbname = 'dispatchdb';
        $user = 'postgres';
        $password = 'postgres';

        $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        if (!$conn) {
            echo "<p style='color:red;'>Connection failed.</p>";
            exit;
        }

        $query = "INSERT INTO dispatch (dispatch_number, received_from, subject, signature) 
                  VALUES ('$dispatch_number', '$received_from', '$subject', '$signature')";
        $result = pg_query($conn, $query);

        if ($result) {
            header("Location: index.php?status=created");
            exit;
        } else {
            echo "<p style='color:red;'>❌ Error: " . pg_last_error($conn) . "</p>";
        }
        
        pg_close($conn);
    }
    ?>
</body>
</html>

