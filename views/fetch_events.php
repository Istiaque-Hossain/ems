<?php
include 'db.php';
$query = "SELECT * FROM events";
$result = $db->query($query);

if ($result->num_rows > 0)
{
    echo '<table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Capacity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc())
    {
        echo '<tr>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['description']) . '</td>
                <td>' . htmlspecialchars($row['date']) . '</td>
                <td>' . htmlspecialchars($row['time']) . '</td>
                <td>' . htmlspecialchars($row['max_capacity']) . '</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="openModal(' . $row['id'] . ')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteEvent(' . $row['id'] . ')">Delete</button>
                </td>
            </tr>';
    }
    echo '</tbody></table>';
}
else
{
    echo '<h2>No data Found</h2>';
}
