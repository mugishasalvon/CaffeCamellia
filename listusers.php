<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            background-image: url('camellia.jpg');
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            
            max-width: 800px;
            margin: 20px;
            text-align: center;
        }

        h1, h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color:rgb(2, 17, 4);
        }

        /* Table Styles */
        table {
            width: 100%;
            margin-top: 2rem;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color:rgb(2, 1, 19);
            color: white;
        }

        table tr:hover {
            background-color:rgb(59, 110, 187);
        }

        /* Message Styles */
        .message {
            margin-top: 1rem;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            text-align: center;
        }

        .message.info {
            background-color: #e9f5ff;
            color: #31708f;
            border: 1px solid #bce8f1;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User List</h1>

        <h2></h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Camellia";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT userid, username FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["userid"] . "</td>
                        <td>" . $row["username"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='message info'>No users found in the database.</div>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>