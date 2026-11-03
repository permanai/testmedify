<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = Kategori::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', 'LIKE', '%' . $kode . '%');
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('id', 'kode', 'nama')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = Kategori::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('kategori.form.index', $data);
    }

    public function singleView($id)
    {
        $data['data'] = Kategori::with('masterItems')->findOrFail($id);
        return view('kategori.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new Kategori;
        } else {
            $data_item = Kategori::find($id);
        }

        $data_item->kode = $request->kode;
        $data_item->nama = $request->nama;
        $data_item->save();

        return redirect('kategori');
    }

    public function delete($id)
    {
        Kategori::find($id)->delete();
        return redirect('kategori');
    }

    public function exportPdf($id)
    {
        $data = Kategori::with('masterItems')->findOrFail($id);
        $tanggal_cetak = now()->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') . ' WIB';

        $pdf = Pdf::loadView('kategori.pdf.kategori_detail', compact('data', 'tanggal_cetak'))
            ->setPaper('a4', 'landscape');

        $filename = 'kategori_' . $data->kode . '_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }
}
