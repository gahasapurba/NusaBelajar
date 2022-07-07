@extends('layouts.admin')
@section('title')
    Arsip Tag Artikel
@endsection
@section('content')
<div class="tables-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card-style mb-30">
                <h4 class="mb-10">Arsip Tag Artikel</h4>
                <p class="text-sm mb-20">
                    Berikut adalah arsip tag artikel yang ada di website NusaBelajar
                </p>
                <div class="table-wrapper table-responsive">
                    <table class="table" id="trashArticleTag">
                        <thead>
                            <tr>
                                <th style="display: none">
                                    <h5>ID</h5>
                                </th>
                                <th class="text-center">
                                    <h5>No</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Nama Tag Artikel</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Dibuat Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Diubah Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Dihapus Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Tampilkan Kembali Tag Artikel</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Hapus Permanen Tag Artikel</h5>
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
    var datatable = $('#trashArticleTag').DataTable({
        lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '{{ url('admin-article-tag-trash') }}',
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
            { data: 'name', name: 'name', class: 'text-center min-width' },
            { data: 'created_at', name: 'created_at', class: 'text-center min-width' },
            { data: 'updated_at', name: 'updated_at', class: 'text-center min-width' },
            { data: 'deleted_at', name: 'deleted_at', class: 'text-center min-width' },
            {
                data: 'restore',
                name: 'restore',
                orderable: false,
                searchable: false,
                class: 'text-center',
            },
            {
                data: 'kill',
                name: 'kill',
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
    $("body").on("click",".admin-article-tag-restore",function(){
        event.preventDefault();
        const url = $(this).attr('href');
        Swal.fire({
            title: 'Apakah anda yakin ingin menampilkan kembali tag artikel ini?',
            text: "Pengguna akan dapat melihat tag artikel ini lagi. Seluruh data terkait dengan tag artikel ini tidak ikut ditampilkan kembali. Anda harus menampilkan satu per satu data terkait dengan tag artikel ini. Anda dapat menghapus kembali tag artikel ini nantinya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tampilkan Kembali',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
    $("body").on("click",".admin-article-tag-kill",function(){
        var current_object = $(this);
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus permanen tag artikel ini?',
            text: "Pengguna tidak akan dapat melihat tag artikel ini lagi. Seluruh data terkait dengan tag artikel ini akan ikut terhapus permanen. Anda tidak dapat menampilkan kembali tag artikel ini nantinya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Permanen',
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