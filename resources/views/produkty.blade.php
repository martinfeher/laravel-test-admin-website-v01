@extends('layouts.app')

@section('title', 'Produkty')

@section('content')

<div id="produkty">
        <h5>Produkty</h5>
        <br>
        <div>
            <table id="table-produkty" class="table">
                <thead>
                <tr>
                    <th>Nazov</th>
                    <th>Popis</th>
                    <th>Cena</th>
                </tr>
                </thead>
            </table>
        </div>
</div>
@endsection

@section('scripts')
    <link href="/assets/lib/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="/assets/lib/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
    <script src="/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
    <script>

    $(document).ready(function() {

        let datatable = createTableDataClientSide();

    }); // end document ready

    function createTableDataClientSide() {

        let datatable = $('#table-produkty').DataTable({
            "bDestroy": true,
            "scrollX": true,
            "language": {
                "processing": "loading",
            },
            "order": [[0, "asc"]],
            "pageLength": 12,
            "ajax": {
                "url": '/produkty/tabulka-data',
                "data": {
                    "tbl": tbl
                }
            },
            "columns": [
                {"data": "Nazov", "searchable": true, "className": "text-center text-wrap", "width": "40%"},
                {"data": "Popis", "searchable": true, "className": "text-center text-wrap", "width": "30%"},
                {"data": "Cena", "searchable": true, "className": "text-center text-wrap", "width": "30%"},
            ],
        });
    }

</script>
@endsection




