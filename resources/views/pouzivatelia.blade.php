@extends('layouts.app')

@section('title', 'Používatelia | cassoviacode_interview_22-01-2021')

@section('content')

<div id="pouzivatelia">
    <h5>Používatelia</h5>
    <br>
    <div>
        <table id="table-pouzivatelia" class="table">
            <thead>
            <tr>
                <th>Meno</th>
                <th>Email</th>
                <th>Vytvorený</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
    <!-- Potvrdit Vymazat Modal-->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Potvrdiť vymazanie</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="confirm_delete_message" style="text-align: center;">Ste si istý, že si prajete vymazať používateľa s emailom <span id="vymazat_email"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Zavrieť</button>
                    <button id="confirmation-modal-delete-button" class="btn btn-danger btn-sm" type="button">Vymazať</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <link href="{{ asset("assets/libs/datatables/css/jquery.dataTables.min.css") }}" rel="stylesheet">
    <script src="{{ asset('assets/libs/bootstrap-4.5.3/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset("assets/libs/datatables/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("assets/libs/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset("assets/libs/datatables.net-responsive/js/dataTables.responsive.js") }}"></script>
    <script src="{{ asset("assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.js") }}"></script>
    <script>

    $(document).ready(function() {
        let datatable = vytvoritTabulku();
    });

    $(document).delegate(".vymazat_btn", "click", function(e){
        let id = $(this).data("id");
        $('#confirmationModal').modal('show');
        $('#vymazat_email').html($(this).data("email"));
        $(document).delegate("#confirmation-modal-delete-button", "click", function(e){
            $('#confirmationModal').modal('hide');
            $.ajax({
                url: '/pouzivatelia/vymazat-data',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function (data) {
                    if (data.status === 'success') {
                        $('#table-pouzivatelia').DataTable().row("#pouzivatel_id_" + id).remove().draw();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    });

    function vytvoritTabulku() {
        $('#table-pouzivatelia').DataTable().clear().destroy();
        let datatable = $('#table-pouzivatelia').DataTable({
            "lengthChange": false,
            "searching": true,
            "bInfo" : false,
            "order": [[1, "asc"]],
            "pageLength": 10,
            "language": {
                "processing": "Načítavanie dát",
                "search": "Vyhľadať",
                "paginate": {
                    "previous": "Predchádzajúce",
                    "next": "Ďalšie"
                }
            },
            "createdRow": function( row, data, dataIndex ) {
                $(row).attr('id', 'pouzivatel_id_' + data.id);
            },
            "ajax": {
                "url": '/pouzivatelia/tabulka-data',
                "data": {}
            },
            "columns": [
                {"data": "meno","title": "Meno", "orderable": true, "searchable": true, "className": "text-left text-wrap", "width": "10%"},
                {"data": "email","title": "Email", "orderable": true, "searchable": true, "className": "text-center text-wrap", "width": "20%"},
                {"data": "vytvoreny", "title": "Vytvorený", "orderable": true, "searchable": false, "className": "text-center text-wrap", "width": "15%"},
                {"data": "vymazat", "title": "", "orderable": false, "searchable": false, "className": "text-center text-wrap", "width": "10%"},
            ],
        });

        return datatable;
    }


</script>
@endsection




