<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Validator;

class ProductController extends Controller
{
    public $title;
    public function __construct()
    {
        $this->title = 'Produk';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['route' => route('admin.product.index'), 'text' => 'Produk'],
        ];
        return view('admin.product.index',compact('breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['route' => route('admin.product.index'), 'text' => 'Produk'],
            ['route' => route('admin.product.create'), 'text' => 'Tambah Produk'],
        ];
        return view('admin.product.create',compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'          => 'required',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'image'         => 'required|image|mimes:jpg,png,jpeg',
            'description'   => ''
        ];

        $messages = [
            'name.required'    => 'Nama produk belum diisi',
            'price.required'   => 'Harga produk belum diisi',
            'price.numeric'    => 'Harga produk harus angka',
            'stock.required'   => 'Stok belum diisi',
            'stock.numeric'    => 'Stok harus angka',
            'image.required'   =>  'Gambar belum diisi',
            'image.image'      =>  'Format gambar harus jpg, png atau jpeg',
            'image.mimes'      =>  'Format gambar harus jpg, png atau jpeg',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        DB::beginTransaction();
        try {
            $imageName = time().'.'.$request->image->extension();

            $product = Product::create([
                'name'  => $data['name'],
                'price' => $data['price'],
                'image' => $imageName,
                'stock' => $data['stock'],
                'description' => $data['description']
            ]);

            if($product){
                $request->image->storeAs('public/images', $imageName);
            }

            DB::commit();

            return redirect()->back()
                ->withSuccess(Lang::get('messages.insert.success', ['attribute' => $this->title]));
        }catch (\Exception $e){
            return redirect()->back()->withInput()
                ->withErrors(Lang::get('messages.insert.failed', ['attribute' => $this->title]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [
            ['route' => route('admin.product.index'), 'text' => 'Produk'],
            ['route' => route('admin.product.edit',['product' => $id]), 'text' => 'Perbarui Produk'],
        ];

        $product = Product::find($id);

        return view('admin.product.create',compact('breadcrumbs','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'name'          => 'required',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric',
            'description'   => ''
        ];

        $messages = [
            'name.required'    => 'Nama produk belum diisi',
            'price.required'   => 'Harga produk belum diisi',
            'price.numeric'    => 'Harga produk harus angka',
            'stock.required'   => 'Stok belum diisi',
            'stock.numeric'    => 'Stok harus angka',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $product = Product::find($id);

        DB::beginTransaction();
        try {
            if($request->image){
                $imageName = time().'.'.$request->image->extension();
            }else{
                $imageName = null;
            }

            if($imageName){
                $updateData = [
                    'name'          => $data['name'],
                    'price'         => $data['price'],
                    'image'         => $imageName,
                    'stock'         => $data['stock'],
                    'description'   => $data['description']
                ];
            }else{
                $updateData = [
                    'name'          => $data['name'],
                    'price'         => $data['price'],
                    'stock'         => $data['stock'],
                    'description'   => $data['description']
                ];
            }

            $update = Product::where('id',$id)->update($updateData);

            if($update && $request->image){
                Storage::disk('public')->delete('/images/'.$product->image);
                $request->image->storeAs('public/images', $imageName);
            }


            DB::commit();

            return redirect()->back()->withInput()
                ->withSuccess(Lang::get('messages.update.success', ['attribute' => $this->title]));
        }catch (\Exception $e){
            return redirect()->back()->withInput()
                ->withErrors(Lang::get('messages.update.failed', ['attribute' => $this->title]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        try{
            if (Storage::disk('public')->exists('/images/'.$product->image)) {
                Storage::disk('public')->delete('/images/'.$product->image);
            }

            $product->delete();
        }catch (\Exception $e){

        }

        return redirect()->back()->withSuccess('Produk berhasil dihapus');
    }

    public function export()
    {
        return (new ProductExport())->download('produk.xlsx');
    }

    public function datatable(Request $request)
    {

        $data = Product::where(function($query) use($request){
            if($request->name){
                $query->where('name','LIKE','%'.$request->name.'%');
            }

            if($request->price){
                $query->orWhere('price','LIKE','%'.$request->price.'%');
            }

            if($request->stock){
                $query->orWhere('stock','LIKE','%'.$request->stock.'%');
            }
        });

        $result =  DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                return '<img src="'.url('storage/images/'.$row->image).'" class="img-thumbnail">';
            })
            ->addColumn('action', function ($row) {
                return '<div class="input-group">
                    <a href="'.route('admin.product.edit',['product' => $row->id]).'" class="btn btn-warning"><i class="bi bi-clipboard-check"></i></a>
                    <form action="'.route('admin.product.destroy',['product' => $row->id]).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>';
            })
            ->rawColumns(['image','action']);

        return $result->make();
    }
}
