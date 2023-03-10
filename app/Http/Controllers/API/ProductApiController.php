<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductApiController extends Controller
{
    public function test()
    {
        return response()->json(
            [
                'msg' => 'api product testing'
            ],
            200
        );
    }

    // tampilkan data products
    public function index()
    {
        // $products = Product::all();
        $products = Product::orderBy('id', 'desc')->paginate(5);
        return response()->json(
            [
                // 'code' => Response::HTTP_OK,
                // 'message' => 'berhasil menampilkan data',
                // 'data' => $products,
                $products,
            ],
            Response::HTTP_OK
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'image|mimes:png,jpg,webp,jpeg,svg|max:2048',
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $target = 'assets/images/';
            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($target, $product_img);
            $input['image'] = "$product_img";
        }

        Product::create($input);

        $data = [
            'code' => Response::HTTP_CREATED,
            'message' => 'Berhasil menambahkan data',
            'data' => $input
        ];
        return response()->json($data, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $data = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
                'data' => $product
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        } else {
            $data = [
                'code' => Response::HTTP_OK,
                'message' => 'Berhasil menampilkan detail data',
                'data' => $product
            ];
            return response()->json($data, Response::HTTP_OK);
        }
    }

    public function update(Request $request, $id)
    {
        // cari data
        $product = Product::find($id);

        $request->validate([
            'name' => 'string|max:255',
            'price' => 'integer',
            'description' => 'string',
            'image' => 'image|mimes:png,jpg,webp,jpeg,svg|max:2048',
        ]);
        $input = $request->all();

        if ($image = $request->file('image')) {
            $target = 'assets/images/';
            // gambar lama dihapus
            if ($product->image) {
                unlink($target . $product->image);
            }
            $product_img = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($target, $product_img);
            $input['image'] = "$product_img";
        }
        $product->update($input); // masukan update data ke database
        $data = [
            'code' => Response::HTTP_OK,
            'message' => 'Berhasil mengubah data',
            'data' => $product
        ];
        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            $data = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        } else {
            $product->delete();
            $data = [
                'code' => Response::HTTP_OK,
                'message' => 'Berhasil menghapus data',
            ];
            return response()->json($data, Response::HTTP_OK);
        }
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(5);
        $data = [
            'code' => Response::HTTP_OK,
            'message' => 'berhasil menampilkan data produk yang dihapus',
            'data' => $products,
        ];
        return response()->json(
            $data,
            Response::HTTP_OK
        );
    }

    public function deletePermanent($id)
    {
        // cari data dari trash
        $product = Product::onlyTrashed()->find($id);

        if (is_null($product)) {
            $data = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        } else {
            $product->forceDelete();
            $data = [
                'code' => Response::HTTP_OK,
                'message' => 'Berhasil menghapus data',
            ];
            return response()->json($data, Response::HTTP_OK);
        }
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->where('id', $id)->first();
        if (is_null($product)) {
            $data = [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Data produk tidak ditemukan',
                'data' => $product
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        } else {
            $product->restore();
            $data = [
                'code' => Response::HTTP_OK,
                'message' => 'Berhasil mengembalikan data',
                'data' => $product
            ];
            return response()->json($data, Response::HTTP_OK);
        }
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $product = Product::orwhere('name', 'like', "%$search%")
            ->orwhere('price', 'like', "%$search%")
            ->orderBy('id', 'desc')
            ->paginate(5);

        $data = [
            'code' => Response::HTTP_OK,
            'message' => 'berhasil menampilkan data',
            'data' => $product,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
