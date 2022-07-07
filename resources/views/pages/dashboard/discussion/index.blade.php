@extends('layouts.dashboard')
@section('title')
    Daftar Diskusi
@endsection
@section('content')
<div class="tables-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card-style mb-30">
                <h4 class="mb-10">Daftar Diskusi</h4>
                <p class="text-sm mb-20">
                    Berikut adalah daftar diskusi yang anda buat di website NusaBelajar
                </p>
                <div class="table-wrapper table-responsive">
                    <table class="table" id="listDiscussion">
                        <thead>
                            <tr>
                                <th style="display: none">
                                    <h5>ID</h5>
                                </th>
                                <th class="text-center">
                                    <h5>No</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Judul Diskusi</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Status Diskusi</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Dibuat Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Diubah Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Detail Diskusi</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Ubah Diskusi</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Hapus Diskusi</h5>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('addon-script')
<script>
    var datatable = $('#listDiscussion').DataTable({
        lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '{{ url('user-discussion-list') }}',
        },
        columns: [
            {
                data: 'id',
                name: 'id',
                visible: false,
                orderable: false,
                searchable: false,
                class: 'text-center min-width',
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                class: 'text-center min-width',
            },
            { data: 'title', name: 'title', class: 'text-center min-width' },
            { data: 'status', name: 'status', class: 'text-center min-width' },
            { data: 'created_at', name: 'created_at', class: 'text-center min-width' },
            { data: 'updated_at', name: 'updated_at', class: 'text-center min-width' },
            {
                data: 'show',
                name: 'show',
                orderable: false,
                searchable: false,
                class: 'text-center',
            },
            {
                data: 'edit',
                name: 'edit',
                orderable: false,
                searchable: false,
                class: 'text-center',
            },
            {
                data: 'delete',
                name: 'delete',
                orderable: false,
                searchable: false,
                class: 'text-center',
            },
        ],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
        ],
    })
    $("body").on("click",".dashboard-discussion-destroy",function(){
        var current_object = $(this);
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus diskusi ini?',
            text: "Apabila diskusi anda sudah disetujui, maka diskusi anda tidak akan ditampilkan lagi di website. Apabila diskusi anda masih dalam proses peninjauan, administrator tidak akan meninjau diskusi yang anda hapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var form =  current_object.closest("form");
                form.submit();
            }
        });
    });
</script>
@endpush