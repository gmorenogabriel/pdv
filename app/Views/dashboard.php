
<body>
    <div class="container mt-4">
        <h1 class="text-center">Ejemplo de DataTables con Bootstrap</h1>
        <table id="miTabla" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Posición</th>
                    <th>Oficina</th>
                    <th>Edad</th>
                    <th>Fecha de Inicio</th>
                    <th>Salario</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011/04/25</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>63</td>
                    <td>2011/07/25</td>
                    <td>$170,750</td>
                </tr>
            </tbody>
        </table>
    </div>

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
