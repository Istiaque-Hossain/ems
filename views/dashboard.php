<?php include 'header.php'; ?>
<h2>All Events</h2>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event['name']); ?></td>
                <td><?= htmlspecialchars($event['description']); ?></td>
                <td><?= htmlspecialchars($event['start_date']); ?></td>
                <td><?= htmlspecialchars($event['end_date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'footer.php'; ?>