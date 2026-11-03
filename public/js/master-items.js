$(document).ready(function () {
    $('#table').DataTable({
        searching: false,
        order: [[0, 'desc']],
    });
    getData();
});

$('.btn-get-data').click(function () {
    getData();
});

function getData() {
    $('#loading-filter').show();

    var dataTableObj = $('#table').DataTable();
    var filter_kode = $('#filter-kode').val();
    var filter_nama = $('#filter-nama').val();
    var filter_harga_min = $('#filter-harga-min').val();
    var filter_harga_max = $('#filter-harga-max').val();

    dataTableObj.clear().draw();

    $.ajax({
        url: MasterItems.searchUrl,
        dataType: 'json',
        tryCount: 0,
        retryLimit: 3,
        data: {
            kode: filter_kode,
            nama: filter_nama,
            hargamin: filter_harga_min,
            hargamax: filter_harga_max,
        },
        success: function (results) {
            $.each(results.data, function (index, item) {
                var harga_jual = Math.round(item.harga_beli + item.harga_beli * item.laba / 100);

                var fotoHtml = '-';
                if (item.foto) {
                    fotoHtml = '<img src="' + MasterItems.storageUrl + '/' + item.foto + '" alt="Foto" style="max-width:50px;max-height:50px;border-radius:4px;">';
                }

                var viewHtml = '<a href="' + MasterItems.viewUrl + '/' + item.kode + '" class="btn btn-primary btn-sm">View</a>';

                dataTableObj.row.add([
                    item.kode,
                    item.nama,
                    fotoHtml,
                    item.jenis,
                    item.harga_beli,
                    harga_jual,
                    item.supplier,
                    viewHtml,
                ]).draw(true);
            });
            $('#loading-filter').hide();
        },
        error: function () {
            this.tryCount++;
            if (this.tryCount <= this.retryLimit) {
                $.ajax(this);
                return;
            }
            alert('Terjadi kesalahan server, tidak dapat mengambil data');
            $('#loading-filter').hide();
        },
    });
}
