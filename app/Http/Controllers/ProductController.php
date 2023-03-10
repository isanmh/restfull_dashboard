<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // orm eloquent (object relational mapping / query builder)
        // order by id desc
        // $products = Product::all();
        // $products = Product::all()->sortByDesc('id');

        // logika search
        if ($request->has('search')) {
            // "SELECT * FROM products WHERE name LIKE '%keyword%' OR description LIKE '%keyword%'"
            $r = $request->search;
            $products = Product::orwhere('name', 'like', "%$r%")
                ->orwhere('price', 'like', "%$r%")
                ->orderBy('id', 'desc')
                ->paginate(5);
        } else {
            $products = Product::orderBy('id', 'desc')->paginate(5);
        }

        // query builder
        // $products = DB::table('products')->get();
        // $products = Product::orderBy('id', 'desc')->get(); // orm + query builder

        // return view('products.index', [
        //     'p' => $products
        // ]);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'price' => 'required|integer',
        //     'description' => 'required|string',
        //     'image' => 'image|mimes:png,jpg,webp,jpeg,svg|max:2048'
        // ]);

        // validasi dengan bahasa indonesia
        $request->validate(
            // ini rules
            [
                "name" => 'required|string|max:255',
                'price' => 'required|integer',
                'description' => 'required|string',
                'image' => 'image|mimes:png,jpg,webp,jpeg,svg|max:2048'
            ],
            // ini validasi manual
            [
                'name.required' => 'Nama produk harus diisi',
                'name.string' => 'Nama produk harus berupa string',
                'price.required' => 'Price produk harus diisi',
                'price.string' => 'Price produk harus berupa angka',
                'description.required' => 'Description produk harus diisi',
                'image.image' => "File harus berupa gambar",
                'image.mimes' => "Gambar harus berekstensi png, jpg, webp, jpeg, svg",
                'image.max' => "Ukuran gambar maksimal 2MB",
            ]
        );

        $input = $request->all();
        // logika untuk upload gambar
        if ($image = $request->file('image')) {
            $targetPath = 'assets/images/';
            // nama baru
            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            // pindahkan gambar ke folder
            $image->move($targetPath, $product_img);
            // replace nama gambar
            $input['image'] = "$product_img";
        }
        // orm untuk insert data (INSERT INTO ... VALUES)
        Product::create($input);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // dd($product);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // dd($product);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'string|max:255',
            'price' => 'integer',
            'description' => 'string',
            'image' => 'image|mimes:png,jpg,webp,jpeg,svg|max:2048'
        ]);

        $input = $request->all();
        // logika jika ada gambar yang diupload
        if ($image = $request->file('image')) {
            $targetPath = 'assets/images/';
            // gambar lama dihapus
            if ($product->image) {
                unlink($targetPath . $product->image);
            }

            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($targetPath, $product_img);
            $input['image'] = "$product_img";
        } else {
            // user tidak mengupload gambar
            unset($input['image']);
        }
        // Query Update (UPDATE ... SET ...) dengan ORM update()
        $product->update($input);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $targetPath = 'assets/images/';
        // query delete (DELETE FROM ... WHERE ...)
        $product->delete(); // dia berubah jadi soft delete (soft delete adalah delete yang tidak langsung menghapus data dari database, melainkan mengubah kolom deleted_at menjadi waktu saat ini)

        // jika ada gambar kita hapus gambarnya
        // if ($product->image) {
        //     unlink($targetPath . $product->image);
        // }

        return redirect()->route('products.index')->with(
            'success',
            'Produk berhasil dihapus'
        );
    }

    // ini untuk ke halaman dashboard
    public function dashboard()
    {
        return view('products.dashboard');
    }

    // ini untuk menampilkan halaman trash
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(5);
        return view('products.trash', compact('products'));
    }

    // buat restore data
    public function restore($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->first();
        $product->restore();
        return redirect()->route('products.trash')->with('success', 'Produk berhasil direstore');
    }

    // hapus permanen
    public function deletePermanent($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->first();
        // hapus gambar permanent
        $target = 'assets/images/';
        if ($product->image) {
            unlink($target . $product->image);
        }
        // hapus data permanent
        $product->forceDelete();
        return redirect()->route('products.trash')->with('success', 'Produk berhasil dihapus permanen');
    }
}
