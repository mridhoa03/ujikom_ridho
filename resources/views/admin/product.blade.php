@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <section class="content">
                            <!-- Default box -->
                            <div class="card">
                                <div class="card-body">
                                <a class="btn btn-primary" href="javascript:void(0)" id="tambahdata">
                                    Tambah Data
                                </a>
                                <br/>
                                <br/>
                                <table class="table table-bordered data-table" width="100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="10px">No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th width="71px">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                </div>
                            </div>
                            <!-- /.card -->

                        </section>
                        <!-- /.content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      //INDEX TABEL
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/produk') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
            {data: 'name', name: 'name'},
            {data: 'slug', name: 'slug'},
            {data: 'name.category', name: 'category_id'},
            {data: 'price', name: 'price'},
            {data: 'stok', name: 'stok'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#tambahdata').click(function () {
        $('#form').trigger("reset");
        $('#category_id').trigger("reset");
        $('#product_id').val('');
        $('#modal').modal({backdrop: 'static', keyboard: false});
        $('#modal').modal('show');
    });
    $('body').on('click','.edit',function(){
        var idProduk = $(this).data('id');
        $.get("{{ url('admin/produk') }}"+"/"+idProduk+"/edit", function(data){
            // console.log(data);
            $('#modal').modal({backdrop: 'static', keyboard: false});
            $('#modal').modal('show');
            $('#product_id').val(data.produk.id);
            $('#name').val(data.produk.name);
            $('#category_id').html('');
            $('#category_id').html(data.category);
            $('#price').val(data.produk.price);
            $('#stok').val(data.produk.stok);
            // $('#foto').html(data.produk.foto);
            $('#description').val(data.produk.deskripsi);
        });
    });
    $('body').on('click','.hapus', function(){
        var idProduk = $(this).data('id');
        $.ajax({
            type: "DELETE",
            url: "{{ url('admin/produk-destroy') }}"+"/"+idProduk,
            success: function(data){
                table.draw();
            },
            error: function(request, status, error) {
                console.log(error);
            }
        });
    });
    //KETIKA BUTTON SAVE DI KLIK
    $('#simpan').click(function (e) {
        e.preventDefault();
        // $(this).hide();
        var formdata = new FormData($('#form')[0]);
        $.ajax({
            data: formdata,
            url: "{{ url('admin/produk-store') }}",
            type: "POST",
            cache:false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#form').trigger("reset");
                $('#modal').modal('hide');
                table.draw();
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            error: function (request, status, error) {
                console.log(error);
            }
        });
    });
    $.ajax({
        url: "{{ url('admin/kategori') }}",
        method: "GET",
        dataType: "json",
        success: function (berhasil) {
            $.each(berhasil.data, function (key, value) {
                $('#category_id').append(
                    `
                    <option value="${value.id}">
                        ${value.nama}
                    </option>
                    `
                )
            })
        },
        error: function () {
            console.log('data tidak ada');
        }
    });
});
</script>
@endsection
