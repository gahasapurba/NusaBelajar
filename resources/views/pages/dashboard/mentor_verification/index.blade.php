@extends('layouts.dashboard')
@section('title')
    Daftar Verifikasi Mentor
@endsection
@section('content')
<div class="tables-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card-style mb-30">
                <h4 class="mb-10">Daftar Verifikasi Mentor</h4>
                <p class="text-sm mb-20">
                    Berikut adalah daftar verifikasi mentor yang anda buat di website NusaBelajar
                </p>
                <div class="table-wrapper table-responsive">
                    <table class="table" id="listMentorVerification">
                        <thead>
                            <tr>
                                <th style="display: none">
                                    <h5>ID</h5>
                                </th>
                                <th class="text-center">
                                    <h5>No</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Status Verifikasi Mentor</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Dibuat Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Diubah Pada</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Detail Verifikasi Mentor</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Ubah Verifikasi Mentor</h5>
                                </th>
                                <th class="text-center">
                                    <h5>Hapus Verifikasi Mentor</h5>
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
    var datatable = $('#listMentorVerification').DataTable({
        lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '{{ url('user-mentor-verification-list') }}',
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
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            },
        ],
    })
    $("body").on("click",".dashboard-mentor-verification-destroy",function(){
        var current_object = $(this);
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin menghapus verifikasi mentor ini?',
            text: "Apabila verifikasi mentor anda sudah disetujui, maka data anda sebagai mentor tidak akan ditampilkan lagi di website. Apabila verifikasi mentor anda masih dalam proses peninjauan, administrator tidak akan meninjau verifikasi mentor yang anda hapus",
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