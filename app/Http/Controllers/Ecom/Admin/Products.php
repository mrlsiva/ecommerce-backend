<?php

namespace App\Http\Controllers\Ecom\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Ecom\Admin\Media;
use App\Models\Product;
use App\Models\Category;
use Validator;

class Products extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;    
    
    protected $mediaHandler;

    public function __construct(Media $media)
    {
        $this->mediaHandler = $media;
    }

	public function showProductsPage()
    {
        return view('ecom.products');
    }

    public function createProduct()
    {
        $categories = Category::all();
        $action = 'add';
        $product = new Product();
        return view('ecom.add-product', compact('action', 'categories', 'product'));
    }

    /* Get All Products  */
    public function getAllProducts()
    {
        try {
            $products = Product::with('media')->get();    
		    return response()->json(['success' => true, 'data' => $products], $this->successStatus); 
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        }     
    }

    /* Add new Product  */
    public function storeProduct(Request $request)
    {
        try {	
            //dd($request->all());		
			$validator = Validator::make($request->all(), [ 
                'product-name' => 'required|min:3',
				'description' => 'required',
				'short-description' => 'nullable',
				'category_id' => 'required|numeric',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric',
                'stocks' => 'required|numeric',
				'status' => 'required',
				'visibility' => 'required',  
                'image-thumb' => 'required|file|mimes:jpg,png,webp',
                'image-gallery' => 'required|array',
                'image-gallery.*' => 'file|mimes:jpg,png,webp'                  
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	            

            /* Product Data */ 
            $product = new Product();
            $product->name = $input['product-name'];            
            $product->description = $input['description'];
            $product->short_description = isset($input['short-description']) ? $input['short-description'] : null;
            $product->category_id = $input['category_id'];
            $product->price  = $input['price'];
            $product->discount  = $input['discount'] ? $input['discount'] : null ;
            $product->stocks  = $input['stocks'] ? $input['stocks'] : null;
            $product->status = $input['status'];
            $product->visibility = $input['visibility'];         
            $product->save();

            /* Product Meta Data   
            $productmeta = new ProductMeta();
            $productmeta->product_id  = $product->id;
            $productmeta->title  = isset($input['meta_title']) ? $input['meta_title'] : null; 
            $productmeta->keywords  = isset($input['meta_keywords']) ? $input['meta_keywords'] : null;
            $productmeta->description  = isset($input['meta_description']) ? $input['meta_description'] : null;
            $productmeta->save(); */  

            /* Product Image */ 
            if ($request->hasFile('image-thumb')) {                 
                $uploaded = $this->mediaHandler->uploadMedia($request, 'image-thumb', $product, 'product_image');                           
            }          

            /* Product Gallery */     
            if ($input['image-gallery']) {                    
                $uploaded = $this->mediaHandler->uploadMultipleMedia($request, 'image-gallery', $product, 'product_gallery');                                                 
            }

            $message = 'Product added successfully';;
            return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }

    public function editProduct(Request $request, string $id)
    {
        //$products = Product::all();
        $categories = Category::all();
        $product = Product::with('media')->where('id', $id)->get(); 
        $action = 'edit';
        //dd($product);
        return view('ecom.add-product', compact('action', 'product', 'categories'));
    }

    /* Update Product  */
    public function updateProduct(Request $request)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'product-name' => 'required|min:3',
				'description' => 'required',
				'short-description' => 'nullable',
				'category_id' => 'required|numeric',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric',
                'stocks' => 'required|numeric',
				'status' => 'required',
				'visibility' => 'required',  
                'image-thumb' => 'nullable|file|mimes:jpg,png,webp',
                'image-gallery' => 'nullable|array',
                'image-gallery.*' => 'file|mimes:jpg,png,webp'       
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	
           
            /* Product Data */            
            $product = Product::findOrFail($input['product_id']);
            $product->name = $input['product-name'];            
            $product->description = $input['description'];
            $product->short_description = isset($input['short-description']) ? $input['short-description'] : null;
            $product->category_id = $input['category_id'];
            $product->price  = $input['price'];
            $product->discount  = $input['discount'] ? $input['discount'] : null ;
            $product->stocks  = $input['stocks'] ? $input['stocks'] : null;
            $product->status = $input['status'];
            $product->visibility = $input['visibility'];         
            $product->save();                      

            /* Product Image */ 
            if ( isset($input['image-thumb']) ) {                   
                $clearmedia = $this->mediaHandler->clearMedia($product, 'product_image');                           
                $uploaded = $this->mediaHandler->uploadMedia($request, 'image-thumb', $product, 'product_image');                           
            }          

            /* Product Gallery */     
            if ( isset($input['image-gallery']) ) {    
                $clearmedia = $this->mediaHandler->clearMedia($product, 'product_gallery');                
                $uploaded = $this->mediaHandler->uploadMultipleMedia($request, 'image-gallery', $product, 'product_gallery');                                                 
            }

            $message = 'Product updated successfully';;
            return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }

    /* Delete Product  */
    public function deleteProduct(Request $request, $id)
    {
        try {	
            $product = Product::findOrFail($id);
            $product->clearMediaCollection('product_image');
            $product->clearMediaCollection('product_gallery');
            $product->delete();
      
            $message = 'Product deleted successfully';;
            return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
        }
        catch (\Throwable $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\PDOException $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } catch (\Exception $exception) {
            return response()->json(['error'=> json_encode($exception->getMessage(), true)], $this->errorStatus );
        } 
    }
}