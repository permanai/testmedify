$(document).ready(function () {
    $('#table').DataTable({
        searching: false,
        order: [[0, 'asc']],
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

    dataTableObj.clear().draw();

    $.ajax({
        url: Kategori.searchUrl,
        dataType: 'json',
        tryCount: 0,
        retryLimit: 3,
        data: {
            kode: filter_kode,
            nama: filter_nama,
        },
        success: function (results) {
            $.each(results.data, function (index, item) {
                var viewHtml = '<a href="' + Kategori.viewUrl + '/' + item.id + '" class="btn btn-primary btn-sm">View</a>';

                dataTableObj.row.add([
                    item.kode,
                    item.nama,
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
