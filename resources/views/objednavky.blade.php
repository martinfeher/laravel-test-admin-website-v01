@extends('layouts.app')

@section('title', 'Objednavky')

@section('content')

    <div id="objednavky">
        <h5>Objednavky</h5>
        <br>
        <div>
            <table id="table-objednavky" class="table">
                <thead>
                <tr>
                    <th>Nazov</th>
                    <th>Popis</th>
                    <th>Dokument - nazov</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    {{--    <script src="/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>--}}
    <script>

        $(document).ready(function() {


        }); // end document ready


    </script>
@endsection




