@extends('layouts.app')

@section('title', 'Objednavky | cassoviacode_interview_22-01-2021')

@section('content')

    <div id="objednavky">
        <h5>Objednávky</h5>
        <br>
        <div>
            <div>
                <button type="button" id="pridat_btn" class="btn btn-success mr-1">Vytvoriť objednavku</button>
                <button type="button" id="upravit_btn" class="btn btn-secondary upravit-btn-disabled">Upraviť objednavku</button>
            </div>
            <br>
            <table id="table-objednavky" class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>Nazov</th>
                    <th>Popis</th>
                    <th>Produkty</th>
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
                    <p class="confirm_delete_message" style="text-align: center;">Ste si istý, že si prajete vymazať objednávku s názvom <span id="vymazat_nazov"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Zavrieť</button>
                    <button id="confirmation-modal-delete-button" class="btn btn-danger btn-sm" type="button">Vymazať</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Pridat Editovat Modal -->
    <div class="modal fade" id="pridat_editovat_tabluka_modal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pridat_objednavk_modal_titulok">Vytvoriť objednavku</h5>
                    <h5 class="modal-title" id="upravit_objednavk_modal_titulok">Upraviť objednavku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="pridat_editovat_tabluka_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="nazov" class="col-form-label col-md-4">Názov objednávky:&nbsp;</label>
                                <input value="" type="text" name="nazov" id="nazov" class="form-control modal-input col-md-8" maxlength="200">
                            </div>
                            <div id="validation-info-nazov" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím zadajte text, maximum 250 symbolov</div>
                            <div id="error-message-nazov" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="popis" class="col-form-label col-md-4">Popis objednávky:&nbsp;</label>
                                <textarea id="popis" name="popis_textarea" class="form-control" rows="5" cols="50" maxlength="5000" placeholder=""></textarea>
                            </div>
                            <div id="validation-info-popis" class="offset-md-4 col-md-8 p-1 validation-info">prosím zadajte text, maximum 5000 symbolov</div>
                            <div id="error-message-popis" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="produkty" class="col-form-label col-md-4">Produkt:&nbsp;</label>
                                <select name="produkty" id="produkty">
                                    @foreach($produkty as $produkt)
                                        <option value="{{ $produkt->id }}">{{ $produkt->id }} - {{ $produkt->nazov }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="validation-info-produkty" class="offset-md-4 col-md-8 p-1 validation-info">potrebné vyplniť, prosím vyberte produkt</div>
                            <div id="error-message-produkty" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <label for="image_upload" class="col-form-label col-md-4">Nahrať dokument:&nbsp;</label>
                                <input type="file" name="image_upload" id="images" class="form-control modal-input col-md-8">
                            </div>
                            <div id="validation-info-image_upload" class="offset-md-4 col-md-8 p-1 validation-info">prosím nahrajte dokument v jednom z týchto formátov JPG, PNG, DOC, DOCX, PDF</div>
                            <div id="error-message-image_upload" class="alert alert-danger error-message offset-md-4 col-md-8 mt-2 p-1" style="font-size: 0.9em; display:none;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"data-dismiss="modal">Zatvoriť</button>
                            <button type="submit" id="pridat-potvrdit-btn" class="btn btn-primary">Potvrdiť</button>
                            <button type="submit" id="upravit-potvrdit-btn" class="btn btn-primary">Upraviť</button>
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
        }); // end document ready

        $(document).delegate("#pridat_btn", "click", function(e){
            $('#pridat_objednavk_modal_titulok').show();
            $('#upravit_objednavk_modal_titulok').hide();
            $('#pridat-potvrdit-btn').show();
            $('#upravit-potvrdit-btn').hide();
            $('#pridat_editovat_tabluka_modal').modal('show');
            $('.error-message').html('');
        });

        $(document).delegate("#upravit_btn", "click", function(e){
            $('#upravit_objednavk_modal_titulok').show();
            $('#pridat_objednavk_modal_titulok').hide();
            $('#pridat_editovat_tabluka_modal').modal('show');
            $('.error-message').html('');
        });

        // $(document).delegate("#pridat-potvrdit-btn", "click", function(e){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#pridat_editovat_tabluka_form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            console.log('formData');
            console.log(formData);
            $('#image-input-error').text('');

            let nazov = $('#nazov').val();
            let popis = $('#popis').val();
            let produkty = $('#produkty').val();

            $.ajax({
                url: "/objednavky/tabulka-pridat-data",
                type:'POST',
                // dataType: "json",
                // data: {
                //     nazov: nazov,
                //     popis: popis,
                //     produkty: produkty,
                // },
                data: formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,

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
                        if (data['produkty'] !== undefined) {
                            $('#error-message-produkty').html(data['produkty'][0]).fadeIn(700);
                        } else {
                            $('#error-message-produkty').html('');
                        }
                    } else if (data.status === 'success') {
                        console.log('2');
                        $('.error-message').html('');
                        $('#table-objednavky').DataTable().row.add( {
                            "id": data.id ,
                            "radio_btn": "<input type=\"radio\" id=\"tbl_radio_btn_" + data.id + "\" class=\"objednavky_table_radio\" name=\"objednavky_table_radio\" value=\"" + data.id + "\" >",
                            "nazov": nazov,
                            "popis": popis,
                            "produkty": produkty,
                            "vymazat": "<button type=\"button\" data-id=\"" + data.id + "\" class=\"btn btn-danger\">Vymazat</button>",
                        }).draw();
                        $('#pridat_editovat_tabluka_modal').modal('hide');
                        $('#nazov').val('');
                        $('#popis').val('');
                        $('#produkty').val('');
                    }
                }
            });
        });

        $(document).delegate("#upravit_btn", "click", function(e){
            let id = $('input[name="objednavky_table_radio"]:checked').val();
            $('#upravit-potvrdit-btn').show();
            $('#pridat-potvrdit-btn').hide();
            $('.error-message').html('');
            $.ajax({
                url: '/objednavky/tabulka-uprava-data',
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id,
                },
                success: function (data) {
                    $('#id').val(id);
                    $('#nazov').val(data.nazov);
                    $('#popis').val(data.popis);
                    $('#produkty').val(data.produkty);
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
            let produkty = $('#produkty').val();
            $.ajax({
                url: "/objednavky/tabulka-upravit-data",
                type:'GET',
                dataType: "json",
                data: {
                    id: id,
                    nazov: nazov,
                    popis: popis,
                    produkty: produkty,
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
                        if (data['produkty'] !== undefined) {
                            $('#error-message-produkty').html(data['produkty'][0]).fadeIn(700);
                        } else {
                            $('#error-message-produkty').html('');
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

        $(document).delegate("#table-objednavky tr", "click", function(e){
            let id = $(this).data('id');
            $('#tbl_radio_btn_' + id).prop('checked', true);
            let radio_btn_state = 0;
            if (radio_btn_state === 0) {
                $('#upravit_btn').removeClass("upravit-btn-disabled");
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


        // $(function() {
        //     // Multiple images preview with JavaScript
        //     var multiImgPreview = function(input, imgPreviewPlaceholder) {
        //
        //         if (input.files) {
        //             var filesAmount = input.files.length;
        //
        //             for (i = 0; i < filesAmount; i++) {
        //                 var reader = new FileReader();
        //
        //                 reader.onload = function(event) {
        //                     $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
        //                 }
        //
        //                 reader.readAsDataURL(input.files[i]);
        //             }
        //         }
        //
        //     };
        //
        //     $('#images').on('change', function() {
        //         multiImgPreview(this, 'div.imgPreview');
        //     });
        // });

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
                    {"data": "radio_btn", "title": "", "orderable": false, "className": "text-center text-wrap radio_btn", "width": "5%"},
                    {"data": "nazov","title": "Nazov", "orderable": true, "className": "text-left text-wrap", "width": "20%"},
                    {"data": "popis","title": "Popis", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                    {"data": "produkty", "title": "Produkty", "orderable": true, "className": "text-center text-wrap", "width": "20%"},
                    {"data": "vymazat", "title": "", "orderable": false, "className": "text-center text-wrap", "width": "10%"},
                ],
            });

            return datatable;
        }


    </script>
@endsection




