<?php
include 'header.php';
include 'auth.php';
include 'db.php';

require_once '../classes/Event.php';
$event  = new Event($db);
$events = $event->getAll();

include 'nav.php';

?>

<!-- <div class="container py-2">

    <div class="row py-2">
        <div class="col-md-6">
            <h2>All Events</h2>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-9">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100"> Add New</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-2">
        <div class="col-md-12">
            <?php
            if ($events == null)
            {
                echo '<h2>No data Found</h2>';
            }
            else
            {

            ?>
                <table class="table">
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
                    <tbody>

                        <?php foreach ($events as $event): ?>

                            <tr>
                                <td><?= htmlspecialchars($event['name']); ?></td>
                                <td><?= htmlspecialchars($event['description']); ?></td>
                                <td><?= htmlspecialchars($event['date']); ?></td>
                                <td><?= htmlspecialchars($event['time']); ?></td>
                                <td><?= htmlspecialchars($event['max_capacity']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="openModal(<?= $event['id']; ?>)">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteEvent(<?= $event['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php } ?>
        </div>
    </div>

</div> -->

<div class="container py-2">

    <!-- Header Section -->
    <div class="row py-2">
        <div class="col-md-6">
            <h2>All Events</h2>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-9">
                    <form class="d-flex" role="search" id="searchForm">
                        <input class="form-control me-2" id="searchInput" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#eventModal" onclick="resetModal()">Add New</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="row py-2">
        <div class="col-md-12">
            <div id="eventTable">
                <?php include 'fetch_events.php'; ?>
            </div>
        </div>
    </div>

</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="eventForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add/Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eventId" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" step="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" id="max_capacity" name="max_capacity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        fetchEvents();

        // Fetch all events
        function fetchEvents() {
            $.ajax({
                url: 'fetch_events.php',
                method: 'GET',
                success: function(data) {
                    $('#eventTable').html(data);
                }
            });
        }

        // Reset Modal Form
        window.resetModal = function() {
            $('#eventForm')[0].reset();
            $('#eventId').val('');
            $('#eventModalLabel').text('Add New Event');
        };

        // Add/Edit Event
        $('#eventForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const id = $('#eventId').val();
            const url = id ? 'edit_event.php' : 'add_event.php';

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function() {
                    fetchEvents();
                    $('#eventModal').modal('hide');
                    $('.modal-backdrop').remove();
                }
            });
        });

        // Delete Event
        window.deleteEvent = function(id) {
            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: 'delete_event.php',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        fetchEvents();
                    }
                });
            }
        };

        // Edit Event
        window.openModal = function(id) {
            $.ajax({
                url: 'get_event.php',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    const event = JSON.parse(data);
                    $('#eventId').val(event.id);
                    $('#name').val(event.name);
                    $('#description').val(event.description);
                    $('#date').val(event.date);
                    $('#time').val(event.time);
                    $('#max_capacity').val(event.max_capacity);
                    $('#eventModalLabel').text('Edit Event');
                    $('#eventModal').modal('show');
                }
            });
        };

        // Search Event
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            const query = $('#searchInput').val();

            $.ajax({
                url: 'search_event.php',
                method: 'GET',
                data: {
                    query
                },
                success: function(data) {
                    $('#eventTable').html(data);
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>