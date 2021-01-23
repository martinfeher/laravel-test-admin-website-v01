@extends('layouts.app')

@section('title', 'Produkty')

@section('content')

<div id="produkty">
        <h5>Produkty</h5>
        <br>
        <div>
            <div>
                <button type="button" id="pridat_btn" class="btn btn-primary">Pridať</button>
                <button type="button" id="editovat_btn" class="btn btn-secondary">Editovať</button>
            </div>
            <br>
            <table id="table-produkty" class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th></th>
                    <th>Nazov</th>
                    <th>Popis</th>
                    <th>Cena</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addEditTableRow" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Pridať produkt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-add-table-row-settings-accounts" class="modal-body pt-4 px-4 pb-2" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <label for="nazov" class="col-form-label col-md-5">Názov:&nbsp;</label>
                            <input value="" type="text" name="nazov" id="nazovID" class="form-control modal-input col-md-7" maxlength="200">
                        </div>
                        <div id="validation-info-nazov" class="offset-md-5 col-md-7 mt-2 p-1 validation-info" style="font-size: 0.9em;">prosím zadajte text, maximum 250 symbolov</div>
                        <div id="error-message-nazov" class="alert alert-danger error-message offset-md-5 col-md-7 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="popis" class="col-form-label col-md-5">Popis:&nbsp;</label>
                            <textarea id="popis_textarea" name="popis_textarea" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                        </div>
                        <div id="validation-info-popis" class="offset-md-5 col-md-7 mt-2 p-1 validation-info" style="font-size: 0.9em;">prosím zadajte text, maximum 5000 symbolov</div>
                        <div id="error-message-popis" class="alert alert-danger error-message offset-md-5 col-md-7 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="cena" class="col-form-label col-md-5">Cena:&nbsp;</label>
                            <input value="" type="text" name="cena" id="cenaID" class="form-control modal-input col-md-7" maxlength="30">
                        </div>
                        <div id="validation-info-cena" class="offset-md-5 col-md-7 mt-2 p-1 validation-info" style="font-size: 0.9em;">prosím zadajte cenu</div>
                        <div id="error-message-cena" class="alert alert-danger error-message offset-md-5 col-md-7 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                        <button type="button" class="btn btn-primary">Potvrdiť</button>
                    </div>
                </form>
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

        let datatable = createTableDataClientSide();

    }); // end document ready

    $(document).delegate("#pridat_btn", "click", function(e){
        $('#addEditTableRow').modal('show');
    });

    function createTableDataClientSide() {

        let datatable = $('#table-produkty').DataTable({
            "lengthChange": false,
            "searching": false,
            "bInfo" : false,
            "order": [[0, "asc"]],
            "pageLength": 10,
            "language": {
                "processing": "Načítavanie dát",
                "paginate": {
                    "previous": "Predchádzajúce",
                    "next": "Ďalšie"
                }
            },
            "ajax": {
                "url": '/produkty/tabulka-data',
                "data": {}
            },
            "columns": [
                {"data": "id", "title": "id", "orderable": true, "className": "text-center text-wrap", "width": "5%"},
                {"data": "radio_btn", "title": "", "orderable": false, "className": "text-center text-wrap radio_btn", "width": "5%"},
                {"data": "nazov","title": "Nazov", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                {"data": "popis","title": "Popis", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                {"data": "cena", "title": "Cena", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                {"data": "vymazat", "title": "", "orderable": false, "className": "text-center text-wrap", "width": "10%"},
            ],
        });
    }

</script>
@endsection




