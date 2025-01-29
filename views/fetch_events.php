<?php
include 'db.php';
require_once '../classes/Event.php';

$event = new Event($db);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 5;

$events = $event->getAll($page, $itemsPerPage);
$totalCount = $event->getTotalCount();

$totalPages = ceil($totalCount / $itemsPerPage);


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

            echo '<form class="d-inline" action="download_csv.php" method="post">
                    <input type="hidden" name="eventId" value="' . $event['id'] . '">
                    <button class="btn btn-success btn-sm" type="submit"> Attendee(.csv) </button>
                  </form> ';
        }
        echo '</td>
            </tr>';
    }

    echo '</tbody></table>';

    echo '<nav><ul class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++)
    {
        $active = ($i == $page) ? 'active' : '';
        echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul></nav>';
}
else
{
    echo '<h2>No data Found</h2>';
}
