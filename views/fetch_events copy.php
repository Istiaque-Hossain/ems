<?php
include 'db.php';
require_once '../classes/Event.php';

$event  = new Event($db);
$events = $event->getAll();

if (!empty($events))
{
    echo '<table id="eventsTable" class="table">
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

    foreach ($events as $event)
    {
        echo '<tr>
                <td>' . htmlspecialchars($event['name']) . '</td>
                <td>' . htmlspecialchars($event['description']) . '</td>
                <td>' . htmlspecialchars($event['date']) . '</td>
                <td>' . htmlspecialchars($event['time']) . '</td>
                <td>' . htmlspecialchars($event['max_capacity']) . '</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="openModal(' . $event['id'] . ')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteEvent(' . $event['id'] . ')">Delete</button>';

        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
        {
            echo ' <button class="btn btn-warning btn-sm" onclick="dwnCsv(' . $event['id'] . ')">Edit</button>';
        }

        echo '</td>
            </tr>';
    }

    echo '</tbody></table>';

    echo '<h1>hi</h1>'
}
else
{
    echo '<h2>No data Found</h2>';
}
