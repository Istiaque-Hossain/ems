<?php
include 'header.php';
include 'auth.php';
include 'db.php';

require_once '../classes/Event.php';
$event  = new Event($db);
$events = $event->getAll();

include 'nav.php';

?>

<div class="container py-2">

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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php } ?>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>