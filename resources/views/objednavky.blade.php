@extends('layouts.app')

@section('title', 'Objednávky | cassoviacode_interview_22-01-2021')

@section('content')

<div id="objednavky">
    <h5>Objednávky</h5>
    <br>
    <div>
        <div>
            <button type="button" id="pridat_objednavku_btn" class="btn btn-success mr-1">Vytvoriť objednavku</button>
            <button type="button" id="upravit_objednavku_btn" class="btn btn-secondary upravit-btn-disabled">Upraviť objednavku</button>
        </div>
        <br>
        <table id="table-objednavky" class="table">
            <thead>
            <tr>
                <th></th>
                <th>Názov</th>
                <th>Popis</th>
                <th>Produkty</th>
                <th>Dokument</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>
    <!-- Pridat Objednavku Modal -->
    <div class="modal fade" id="pridat_tabluka_modal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pridat_objednavk_modal_titulok">Vytvoriť objednavku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="pridat_tabluka_form" class="pt-2 pl-2 pb-1" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="input-group">
                                <label for="pridat_nazov" class="col-form-label col-md-4">Názov objednávky:&nbsp;</label>
                                <input value="" type="text" name="nazov" id="pridat_nazov" class="form-control modal-input col-md-8" maxlength="200">
                            </div>
                            <div id="pridat_validation-info-nazov" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím zadajte text, maximum 250 symbolov</div>
                            <div id="pridat_error-message-nazov" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="pridat_popis" class="col-form-label col-md-4">Popis objednávky:&nbsp;</label>
                                <textarea id="pridat_popis" name="popis" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                            </div>
                            <div id="pridat_validation-info-popis" class="offset-md-4 col-md-8 p-1 validation-info">prosím zadajte text, maximum 5000 symbolov</div>
                            <div id="pridat_error-message-popis" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="pridat_produkty" class="col-form-label col-md-4">Produkt:&nbsp;</label>
                                <select name="produkty" id="pridat_produkty">
                                    @foreach($produkty as $produkt)
                                        <option value="{{ $produkt->id }}">{{ $produkt->id }} - {{ $produkt->nazov }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="pridat_validation-info-produkty" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím vyberte produkt</div>
                            <div id="pridat_error-message-produkty" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="pridat_dokument_upload" class="col-form-label col-md-4">Nahrať dokument:&nbsp;</label>
                                <input type="file" name="dokument_upload" id="pridat_dokument_upload" class="form-control modal-input col-md-8">
                                <div id="pridat_validation-info-dokument_upload" class="offset-md-4 col-md-8 p-1 validation-info">prosím nahrajte dokument v jednom z týchto formátov JPG, PNG, DOC, DOCX, PDF</div>
                                <div id="pridat_error-message-dokument_upload" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                            </div>
                            <div class="input-group">
                                <label for="pridat_dokument_name" class="col-form-label col-md-4">Dokument:&nbsp;</label>
                                <input type="text" name="dokument_name" id="pridat_dokument_name" class="form-control modal-input col-md-8" disabled="disabled">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                            <button type="submit" id="pridat-potvrdit-btn" class="btn btn-primary">Potvrdiť</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Upravit Objednavku Modal -->
    <div class="modal fade" id="upravit_tabluka_modal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upravit_objednavk_modal_titulok">Upraviť objednavku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="upravit_tabluka_form" class="pt-2 pl-2 pb-1" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="upravit_id">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="upravit_nazov" class="col-form-label col-md-4">Názov objednávky:&nbsp;</label>
                                <input value="" type="text" name="nazov" id="upravit_nazov" class="form-control modal-input col-md-8" maxlength="200">
                            </div>
                            <div id="upravit_validation-info-nazov" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím zadajte text, maximum 250 symbolov</div>
                            <div id="upravit_error-message-nazov" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="upravit_popis" class="col-form-label col-md-4">Popis objednávky:&nbsp;</label>
                                <textarea id="upravit_popis" name="popis" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                            </div>
                            <div id="upravit_validation-info-popis" class="offset-md-4 col-md-8 p-1 validation-info">prosím zadajte text, maximum 5000 symbolov</div>
                            <div id="upravit_error-message-popis" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="upravit_produkty" class="col-form-label col-md-4">Produkt:&nbsp;</label>
                                <select name="produkty" id="upravit_produkty">
                                    @foreach($produkty as $produkt)
                                        <option value="{{ $produkt->id }}">{{ $produkt->id }} - {{ $produkt->nazov }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="upravit_validation-info-produkty" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím vyberte produkt</div>
                            <div id="upravit_error-message-produkty" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="upravit_dokument_upload" class="col-form-label col-md-4">Nahrať dokument:&nbsp;</label>
                                <input type="file" name="dokument_upload" id="upravit_dokument_upload" class="form-control modal-input col-md-8">
                                <div id="upravit_validation-info-dokument_upload" class="offset-md-4 col-md-8 p-1 validation-info">prosím nahrajte dokument v jednom z týchto formátov JPG, PNG, DOC, DOCX, PDF</div>
                                <div id="upravit_error-message-dokument_upload" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                            </div>
                            <div class="input-group">
                                <label for="upravit_dokument_name" class="col-form-label col-md-4">Dokument:&nbsp;</label>
                                <input type="text" name="dokument_name" id="upravit_dokument_name" class="form-control modal-input col-md-8" disabled="disabled">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                            <button type="submit" id="upravit_upravit-potvrdit-btn" class="btn btn-primary">Upraviť</button>
                        </div>
                    </form>
                </div>
            </div>
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
                    <p class="confirm_delete_message" style="text-align: center;">Ste si istý, že si prajete vymazať objednávku s názvom <span id="vymazat_nazov"></span>?</p>
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
        }); // end document ready

        $(document).delegate("#pridat_objednavku_btn", "click", function(e){
            $('#pridat_tabluka_modal').modal('show');
            $('.error-message').html('').hide();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#pridat_tabluka_form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "/objednavky/tabulka-pridat-data",
                type:'POST',
                data: formData,
                dataType:'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data['status'] === undefined) {
                        if (data['nazov'] !== undefined) {
                            $('#pridat_error-message-nazov').html(data['nazov'][0]).fadeIn(700);
                        } else {
                            $('#pridat_error-message-nazov').html('');
                        }
                        if (data['popis'] !== undefined) {
                            $('#pridat_error-message-popis').html(data['popis'][0]).fadeIn(700);
                        } else {
                            $('#pridat_error-message-popis').html('');
                        }
                        if (data['produkty'] !== undefined) {
                            $('#pridat_error-message-produkty').html(data['produkty'][0]).fadeIn(700);
                        } else {
                            $('#pridat_error-message-produkty').html('');
                        }
                        if (data['dokument_upload'] !== undefined) {
                            $('#pridat_error-message-dokument_upload').html(data['dokument_upload'][0]).fadeIn(700);
                        } else {
                            $('#pridat_error-message-dokument_upload').html('');
                        }
                    } else if (data.status === 'success') {
                        $('.error-message').html('');
                        let datatable = vytvoritTabulku();
                        $('#pridat_tabluka_modal').modal('hide');
                        $('#pridat_nazov').val('');
                        $('#pridat_popis').val('');
                        $('#pridat_produkty').val('');
                        $('#pridat_dokument_name').val('');
                    }
                }
            });
        });

        $(document).delegate("#upravit_objednavku_btn", "click", function(e){
            let id = $('input[name="objednavky_table_radio"]:checked').val();
            $.ajax({
                url: '/objednavky/tabulka-uprava-data',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function (data) {
                    $('#upravit_id').val(id);
                    $('#upravit_nazov').val(data.nazov);
                    $('#upravit_popis').val(data.popis);
                    $('#upravit_produkty').val(data.produkty);
                    $('#upravit_dokument_name').val(data.dokument_name);
                    $('#upravit_tabluka_modal').modal('show');
                    $('.error-message').html('').hide();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $('#upravit_tabluka_form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "/objednavky/tabulka-upravit-data",
                type:'POST',
                data: formData,
                dataType:'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data['status'] === undefined) {
                        if (data['nazov'] !== undefined) {
                            $('#upravit_error-message-nazov').html(data['nazov'][0]).fadeIn(700);
                        } else {
                            $('#upravit_error-message-nazov').html('');
                        }
                        if (data['popis'] !== undefined) {
                            $('#upravit_error-message-popis').html(data['popis'][0]).fadeIn(700);
                        } else {
                            $('#upravit_error-message-popis').html('');
                        }
                        if (data['produkty'] !== undefined) {
                            $('#upravit_error-message-produkty').html(data['produkty'][0]).fadeIn(700);
                        } else {
                            $('#upravit_error-message-produkty').html('');
                        }
                        if (data['dokument_upload'] !== undefined) {
                            $('#upravit_error-message-dokument_upload').html(data['dokument_upload'][0]).fadeIn(700);
                        } else {
                            $('#upravit_error-message-dokument_upload').html('');
                        }
                    } else if (data.status === 'success') {
                        $('#upravit_tabluka_modal').modal('hide');
                        $('.error-message').html('').hide();
                        let datatable = vytvoritTabulku();
                        datatable.on('draw', function () {
                            $('#tbl_radio_btn_' + formData.get('id')).prop('checked', true);
                        });
                    }
                }
            });
        });

        $(document).delegate("#table-objednavky tr", "click", function(e){
            let id = $(this).data('id');
            $('#tbl_radio_btn_' + id).prop('checked', true);
            let radio_btn_state = 0;
            if (radio_btn_state === 0) {
                $('#upravit_objednavku_btn').removeClass("upravit-btn-disabled");
            }
            radio_btn_state = 1;
        });

        $(document).delegate(".vymazat_btn", "click", function(e){
            let id = $(this).data("id");
            let nazov = $(this).data("nazov");
            $('#confirmationModal').modal('show');
            $('#vymazat_nazov').html(nazov);
            $(document).delegate("#confirmation-modal-delete-button", "click", function(e){
                $('#confirmationModal').modal('hide');
                $.ajax({
                    url: '/objednavky/tabulka-vymazat-data',
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        if (data.status === 'success') {
                            $('#table-objednavky').DataTable().row("#objednavk_id_" + id).remove().draw();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });

        function vytvoritTabulku() {
            $('#table-objednavky').DataTable().clear().destroy();
            let datatable = $('#table-objednavky').DataTable({
                "lengthChange": false,
                "searching": false,
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
                    $(row).attr('id', 'objednavk_id_' + data.id);
                    $(row).attr('data-id', data.id);
                },
                "ajax": {
                    "url": '/objednavky/tabulka-data',
                    "data": {}
                },
                "columns": [
                    {"data": "radio_btn", "title": "", "orderable": false, "className": "text-center text-wrap radio_btn", "width": "10%"},
                    {"data": "nazov","title": "Názov", "orderable": true, "className": "text-left text-wrap", "width": "20%"},
                    {"data": "popis","title": "Popis", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                    {"data": "produkty_zoznam", "title": "Produkty", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                    {"data": "dokument_name", "title": "Dokument", "orderable": false, "className": "text-center text-wrap", "width": "20%"},
                    {"data": "vymazat", "title": "", "orderable": false, "className": "text-center text-wrap", "width": "10%"},
                ],
            });

            return datatable;
        }


    </script>
@endsection




