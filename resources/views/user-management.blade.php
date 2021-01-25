@extends('layouts.app')

@section('title', 'User management | cassoviacode_interview_22-01-2021')

@section('content')

<div id="logs_page" class="card">
    <div class="card-body overflow-hidden p-lg-6">
        <h5>Logs</h5>
        <br>
        <div>
            <label for="logs_select">Select table: &nbsp;</label>
            <select name="logs_select" id="logs_select" class="select_month">
                @foreach ($logs_tables as $key => $logs_table)
                    @if ($logs_table->selected === 1)
                        <option value="{{ $logs_table->table_name }}" selected>{{ $logs_table->table_name }}</option>
                    @else
                        <option value="{{ $logs_table->table_name }}">{{ $logs_table->table_name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <div id="search_wrapper" style="position: relative">
                <label id="table_search_label" for="search_table">Search: </label>
                <input type="text" id="search_table" placeholder="#transid">
                <div id="search-loading-indicator" class='spinner-border spinner-border-sm' style="display:none; position: absolute; top: 3px; left: 265px; margin-top: 1px; width: 16px; height: 16px; color: #4242d0;" role='status'><span class='sr-only'>Loading...</span></div>
            </div>
            <table id="logs" class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100 dataTable dtr-inline" style="width:100%; font-size: 1em; border: 1px solid #EEE;">
                <thead>
                <tr>
                    <th style="color: transparent;">transid</th>
                    <th>rowid</th>
                    <th>requesttype</th>
                    <th>accountid</th>
                    <th>datasent</th>
                    <th>datareceived</th>
                    <th class="text-center">logged</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
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




