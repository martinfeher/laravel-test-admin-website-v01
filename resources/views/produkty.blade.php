@extends('layouts.app')

@section('title', 'Produkty | cassoviacode_interview_22-01-2021')

@section('content')

<div id="produkty">
        <h5>Produkty</h5>
        <br>
        <div>
            <div>
                <button type="button" id="pridat_produkt_btn" class="btn btn-primary mr-1">Pridať produkt</button>
                <button type="button" id="upravit_produkt_btn" class="btn btn-secondary upravit-btn-disabled">Upraviť produkt</button>
            </div>
            <br>
            <table id="table-produkty" class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>id</th>
                    <th>Nazov</th>
                    <th>Popis</th>
                    <th>Cena</th>
                    <th></th>
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
                <h5 class="modal-title" id="confirmationModalLabel">Potvrdiť vymazanie</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="confirm_delete_message" style="text-align: center;">Ste si istý, že si prajete vymazať produkt s id <span id="vymazat_id"></span>?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Zavrieť</button>
                <button id="confirmation-modal-delete-button" class="btn btn-danger btn-sm" type="button">Vymazať</button>
            </div>
        </div>
    </div>
</div>

<!-- Pridat Editovat Produkt Modal -->
<div class="modal fade" id="pridat_editovat_tabluka_modal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pridat_produkt_modal_titulok">Pridať produkt</h5>
                <h5 class="modal-title" id="upravit_produkt_modal_titulok">Upraviť produkt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-body pt-4 px-4 pb-2">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="input-group">
                            <label for="nazov" class="col-form-label col-md-4">Názov:&nbsp;</label>
                            <input value="" type="text" name="nazov" id="nazov" class="form-control modal-input col-md-8" maxlength="200">
                        </div>
                        <div id="validation-info-nazov" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím zadajte text, maximum 250 symbolov</div>
                        <div id="error-message-nazov" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="popis" class="col-form-label col-md-4">Popis:&nbsp;</label>
                            <textarea id="popis" name="popis_textarea" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                        </div>
                        <div id="validation-info-popis" class="offset-md-4 col-md-8 p-1 validation-info">prosím zadajte text, maximum 5000 symbolov</div>
                        <div id="error-message-popis" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="cena" class="col-form-label col-md-4">Cena:&nbsp;</label>
                            <input value="" type="text" name="cena" id="cena" class="form-control modal-input col-md-8" maxlength="11">
                        </div>
                        <div id="validation-info-cena" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím zadajte cenu</div>
                        <div id="error-message-cena" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                        <button type="button" id="pridat-potvrdit-btn" class="btn btn-primary">Potvrdiť</button>
                        <button type="button" id="upravit-potvrdit-btn" class="btn btn-primary">Upraviť</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Vytvoriť Objednávku Modal -->
<div class="modal fade" id="vytvorit_objednavku_tabluka_modal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vytvorit_objednavku_modal_titulok">Vytvoriť Objednávku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-body pt-4 px-4 pb-2">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <div class="input-group">
                            <label for="nazovt_objednavky" class="col-form-label col-md-5">Názov Objednávky:</label>
                            <input value="" type="text" name="nazov_objednavky" id="nazov_objednavky" class="form-control modal-input col-md-7" maxlength="200">
                        </div>
                        <div id="validation-info-nazov_objednavky" class="offset-md-5 col-md-7 p-1 validation-info">potrebné vyplniť, prosím zadajte text, maximum 250 symbolov</div>
                        <div id="error-message-nazov_objednavky" class="alert alert-danger error-message offset-md-5 col-md-7 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="popis_objednavky" class="col-form-label col-md-5">Popis Objednávky:</label>
                            <textarea id="popis_objednavky" name="popis_objednavky_textarea" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                        </div>
                        <div id="validation-info-popis_objednavky" class="offset-md-5 col-md-7 p-1 validation-info">prosím zadajte text, maximum 5000 symbolov</div>
                        <div id="error-message-popis_objednavky" class="alert alert-danger error-message offset-md-5 col-md-7 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label for="produkt_modal" class="col-form-label col-md-5">Produkt</label>
                            <input value="" type="text" name="produkt_modal" id="produkt_modal" class="form-control modal-input col-md-7" maxlength="200" disabled>
                        </div>
                        <div id="validation-info-produkty" class="offset-md-5 col-md-7 p-1 validation-info">potrebné vyplniť, prosím zadajte cenu</div>
                        <div id="error-message-produkty" class="alert alert-danger error-message offset-md-4 col-md-á mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                        <button type="button" id="vytvorit_objednavku_potvrdit-btn" class="btn btn-primary">Vytvoriť Objednávku</button>
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
        let datatable = vytvoritTabulku();
    });
    $(document).delegate("#pridat_produkt_btn", "click", function(e){
        $('#pridat_produkt_modal_titulok').show();
        $('#upravit_produkt_modal_titulok').hide();
        $('#pridat-potvrdit-btn').show();
        $('#upravit-potvrdit-btn').hide();
        $('#pridat_editovat_tabluka_modal').modal('show');
        $('.error-message').html('');
    });
    $(document).delegate("#upravit_produkt_btn", "click", function(e){
        $('#upravit_produkt_modal_titulok').show();
        $('#pridat_produkt_modal_titulok').hide();
        $('#pridat_editovat_tabluka_modal').modal('show');
        $('.error-message').html('');
    });
    $(document).delegate(".vytvorit_objednavku_btn", "click", function(e){
        $('#vytvorit_objednavku_tabluka_modal').modal('show');
        let id = $(this).data('id');
        let nazov = $(this).data('nazov');
        $('#produkt_modal').val('id: ' + id + ', ' + nazov);
        $('#vytvorit_objednavku_potvrdit-btn').attr('data-produkt_id', String(id));
        $('.error-message').html('');
    });

    $(document).delegate("#pridat-potvrdit-btn", "click", function(e){
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
                        "vytvorit_objednavku": "<button type=\"button\" data-id=\"" + data.id + "\" class=\"btn btn-secondary vytvorit_objednavku_btn\">Vytvoriť objednávku</button>",
                        "vymazat": "<button type=\"button\" data-id=\"" + data.id + "\" class=\"btn btn-danger\">Vymazat</button>",
                    }).draw();
                    $('#pridat_editovat_tabluka_modal').modal('hide');
                    $('#nazov').val('');
                    $('#popis').val('');
                    $('#cena').val('');
                }
            }
        });
    });

    $(document).delegate("#upravit_produkt_btn", "click", function(e){
        let id = $('input[name="produkty_table_radio"]:checked').val();
        $('#upravit-potvrdit-btn').show();
        $('#pridat-potvrdit-btn').hide();
        $('.error-message').html('');
        $.ajax({
            url: '/produkty/tabulka-uprava-data',
            method: 'GET',
            dataType: 'json',
            data: {
                id: id,
            },
            success: function (data) {
                $('#id').val(id);
                $('#nazov').val(data.nazov);
                $('#popis').val(data.popis);
                $('#cena').val(data.cena);
                $('#pridat_editovat_tabluka_modal').modal('show');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).delegate("#upravit-potvrdit-btn", "click", function(e){
        let id = $('#id').val();
        let nazov = $('#nazov').val();
        let popis = $('#popis').val();
        let cena = $('#cena').val();
        $.ajax({
            url: "/produkty/tabulka-upravit-data",
            type:'GET',
            dataType: "json",
            data: {
                id: id,
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
                    $('#pridat_editovat_tabluka_modal').modal('hide');
                    $('.error-message').html('');
                    let datatable = vytvoritTabulku();
                    datatable.on('draw', function () {
                        $('#tbl_radio_btn_' + id).prop('checked', true);
                    });
                }
            }
        });
    });

    $(document).delegate("#vytvorit_objednavku_potvrdit-btn", "click", function(e){
        let nazov_objednavky = $('#nazov_objednavky').val();
        let popis_objednavky = $('#popis_objednavky').val();
        let produkt_id = $(this).data('produkt_id');
        $('.error-message').html('');
        $.ajax({
            url: '/produkty/vytvorit-objednavku',
            method: 'GET',
            dataType: 'json',
            data: {
                nazov_objednavky: nazov_objednavky,
                popis_objednavky: popis_objednavky,
                produkt_id: produkt_id,
            },
            success: function (data) {
                if (data['status'] === undefined) {
                    if (data['nazov_objednavky'] !== undefined) {
                        $('#error-message-nazov_objednavky').html(data['nazov_objednavky'][0]).fadeIn(700);
                    } else {
                        $('#error-message-nazov_objednavky').html('');
                    }
                    if (data['popis_objednavky'] !== undefined) {
                        $('#error-message-popis_objednavky').html(data['popis_objednavky'][0]).fadeIn(700);
                    } else {
                        $('#error-message-popis_objednavky').html('');
                    }
                } else if (data.status === 'success') {
                    $('#vytvorit_objednavku_tabluka_modal').modal('hide');
                    $('#nazov_objednavky').val('');
                    $('#popis_objednavky').val('');
                }
            },
            error: function (error) {
                console.log(error);
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

    $(document).delegate("#table-produkty tr", "click", function(e){
        let id = $(this).data('id');
        $('#tbl_radio_btn_' + id).prop('checked', true);
        let radio_btn_state = 0;
        if (radio_btn_state === 0) {
            $('#upravit_produkt_btn').removeClass("upravit-btn-disabled");
        }
        radio_btn_state = 1;
    });

    function vytvoritTabulku() {
        $('#table-produkty').DataTable().clear().destroy();
        let datatable = $('#table-produkty').DataTable({
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
                $(row).attr('id', 'produkt_id_' + data.id);
                $(row).attr('data-id', data.id);
            },
            "ajax": {
                "url": '/produkty/tabulka-data',
                "data": {}
            },
            "columns": [
                {"data": "radio_btn", "title": "", "orderable": false, "className": "text-center text-wrap radio_btn", "width": "5%"},
                {"data": "id", "title": "id", "orderable": true, "className": "text-center text-wrap", "width": "5%"},
                {"data": "nazov","title": "Nazov", "orderable": true, "className": "text-center text-wrap", "width": "10%"},
                {"data": "popis","title": "Popis", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                {"data": "cena", "title": "Cena", "orderable": true, "className": "text-center text-wrap", "width": "15%"},
                {"data": "vytvorit_objednavku", "title": "", "orderable": false, "className": "text-center text-wrap", "width": "15%"},
                {"data": "vymazat", "title": "", "orderable": false, "className": "text-center text-wrap", "width": "10%"},
            ],
        });

        return datatable;
    }


</script>
@endsection




