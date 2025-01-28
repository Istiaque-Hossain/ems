<?php
include 'header.php';
include 'db.php';
require_once '../classes/Event.php';

$event  = new Event($db);
$events = $event->getRegEvent();


?>
<h1 class="text-center bg-primary text-white py-3 rounded shadow-lg">
    Event Management System
</h1>

<div class="container py-2">
    <div class="row py-2">
        <div class="col-md-10">
            <h2>All Events for register</h2>
        </div>

    </div>

    <?php
    if (isset($_SESSION['reg_message']))
    {
        echo $_SESSION['reg_message'];
        unset($_SESSION['reg_message']);
    }
    ?>

    <div class="row py-2">
        <div class="col-md-12">
            <div id="eventRegTable">
                <?php
                if (!empty($events))
                {
                    echo '<table id="eventsRegTable" class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Avaiable sit</th>
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
                                <button class="btn btn-warning btn-sm register-btn"
                                    data-id="' . htmlspecialchars($event['id']) . '"
                                    data-name="' . htmlspecialchars($event['name']) . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#eventRegModal">Register</button>
                                </td>
                            </tr>';
                    }

                    echo '</tbody></table>';
                }
                else
                {
                    echo '<h2>No data Found</h2>';
                }

                ?>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="eventRegModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="../process.php" id="eventForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Register Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eventId" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="eventReg">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {


        $('#eventsRegTable').DataTable({
            paging: true, // Enables pagination
            searching: true, // Adds a search box
            ordering: true, // Enables column sorting
            order: [
                [2, 'asc']
            ], // Sets the default sort column (Date) and order (ascending)
            pageLength: 10, // Number of rows per page
            lengthMenu: [5, 10, 25, 50], // Options for rows per page
            columnDefs: [{
                    orderable: false,
                    targets: 5
                } // Disable sorting for the 'Action' column
            ]
        });
    });

    $(document).ready(function() {
        // Handle the click event of the "Register" button
        $(document).on('click', '.register-btn', function() {
            const eventId = $(this).data('id'); // Get the event ID from the data attribute
            const eventName = $(this).data('name'); // Get the event name if needed

            // Populate the hidden input field in the modal with the event ID
            $('#eventId').val(eventId);

            // Optionally, update the modal title or any other fields with event data
            $('#eventModalLabel').text(`Register for Event: ${eventName}`);
        });
    });
</script>

<?php include 'footer.php'; ?>