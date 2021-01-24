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

<!-- Potvrdit Vymazat Modal-->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Delete item</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="confirm_delete_message" style="text-align: center;">Ste si istý, že si prajete vymazať produkt s id <span id="vymazat_id"></span>?</p>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button><button id="confirmation-modal-delete-button" class="btn btn-danger btn-sm" type="button">delete</button></div>
        </div>
    </div>
</div>

<!-- Pridat Editovat Modal -->
<div class="modal fade" id="pridatEditovatTableData" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Pridať produkt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-body pt-4 px-4 pb-2" method="POST">
                    @csrf
                    <input value="" type="hidden" name="id" id="id" class="form-control modal-input col-md-7" maxlength="200">
                    <div class="form-group">
                        <div class="input-group">
                            <label for="nazov" class="col-form-label col-md-5">Názov:&nbsp;</label>
                            <input value="" type="text" name="nazov" id="nazov" class="form-control modal-input col-md-7" maxlength="200">
                        </div>
                        <div id="validation-info-nazov" class="offset-md-5 col-md-7 mt-2 p-1 validation-info">potrebné vyplniť, prosím zadajte text, maximum 250 symbolov</div>
                        <div id="error-message-nazov" class="alert alert-danger error-message offset-md-5 col-md-7 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="popis" class="col-form-label col-md-5">Popis:&nbsp;</label>
                            <textarea id="popis" name="popis_textarea" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                        </div>
                        <div id="validation-info-popis" class="offset-md-5 col-md-7 mt-2 p-1 validation-info">prosím zadajte text, maximum 5000 symbolov</div>
                        <div id="error-message-popis" class="alert alert-danger error-message offset-md-5 col-md-7 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="cena" class="col-form-label col-md-5">Cena:&nbsp;</label>
                            <input value="" type="text" name="cena" id="cena" class="form-control modal-input col-md-7" maxlength="11">
                        </div>
                        <div id="validation-info-cena" class="offset-md-5 col-md-7 mt-2 p-1 validation-info">potrebné vyplniť, prosím zadajte cenu</div>
                        <div id="error-message-cena" class="alert alert-danger error-message offset-md-5 col-md-7 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                        <button type="button" id="potvrdit-pridat" class="btn btn-primary">Potvrdiť</button>
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
        $('#pridatEditovatTableData').modal('show');
        $('.error-message').html('');
    });

    $(document).delegate("#edit_settings_accounts_row", "click", function(e){
        let selected_account = $('input[name="produkty_table_radio"]:checked').val();
    });

    $(document).delegate("#potvrdit-pridat", "click", function(e){

        // let id = $('#id').val();
        let nazov = $('#nazov').val();
        let popis = $('#popis').val();
        let cena = $('#cena').val();

        $.ajax({
            url: "/produkty/tabulka-pridat-data",
            type:'GET',
            dataType: "json",
            data: {
                nazov: nazov,
                popis: popis,
                cena: cena,
            },
            success: function(data) {
                if (data['status'] === undefined) {
                    if (data['nazov'] !== undefined) {
                        $('#error-message-nazov').html(data['nazov'][0]).fadeIn(700);
                    } else {
                        $('#error-message-nazov').html('');
                    }
                    if (data['popis'] !== undefined) {
                        $('#error-message-popis').html(data['popis'][0]).fadeIn(700);
                    } else {
                        $('#error-message-popis').html('');
                    }
                    if (data['cena'] !== undefined) {
                        $('#error-message-cena').html(data['cena'][0]).fadeIn(700);
                    } else {
                        $('#error-message-cena').html('');
                    }

                } else if (data.status === 'success') {
                    console.log('2');
                    $('.error-message').html('');
                    $('#table-produkty').DataTable().row.add( {
                        "id": data.id ,
                        "radio_btn": "<input type=\"radio\" id=\"tbl_radio_btn_" + data.id + "\" class=\"produkty_table_radio\" name=\"produkty_table_radio\" value=\"" + data.id + "\" >",
                        "nazov": nazov,
                        "popis": popis,
                        "cena": cena,
                        "vymazat": "<button type=\"button\" data-id=\"" + data.id + "\" class=\"btn btn-danger\">Vymazat</button>",
                    }).draw();
                    $('#pridatEditovatTableData').modal('hide');
                    $('#nazov').val('');
                    $('#popis').val('');
                    $('#cena').val('');
                }
            }
        });
    });

    $(document).delegate(".vymazat_btn", "click", function(e){
        let id = $(this).data("id");
        $('#confirmationModal').modal('show');
        $('#vymazat_id').html(id);
        $(document).delegate("#confirmation-modal-delete-button", "click", function(e){
            $('#confirmationModal').modal('hide');
            $.ajax({
                url: '/produkty/tabulka-vymazat-data',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function (data) {
                    if (data.status === 'success') {
                        $('#table-produkty').DataTable().row("#produkt_id_" + id).remove().draw();
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
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
            "createdRow": function( row, data, dataIndex ) {
                $(row).attr('id', 'produkt_id_' + data.id);
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




