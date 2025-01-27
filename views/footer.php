    <!-- </div> -->
    <script>
        $(document).ready(function() {
            $('#eventsTable').DataTable({
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
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>

    </html>