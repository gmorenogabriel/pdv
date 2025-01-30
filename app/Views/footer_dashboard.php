    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inicialización de DataTables -->
    <script>
        $(document).ready(function () {
            $('#miTabla').DataTable({
                paging: true,
                searching: true,
                info: true,
                lengthChange: true,
                pageLength: 5
            });
        });
    </script>
</body>
</html>
</body>
</html>
