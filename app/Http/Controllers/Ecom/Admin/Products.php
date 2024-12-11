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
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        return view('ecom.product-form', compact('action', 'categories', 'product'));
    }

    /* Get All Products  */
    public function getAllProducts()
    {
        try {
            $products = Product::with('media')->orderBy('id', 'desc')->get();    
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
           // $jsonData = json_encode($input); // Convert POST data to JSON string
           // return response()->json($jsonData);
           // dd( $jsonData );            

            /* Product Data */ 
            $product = new Product();
            $product->name = $input['product-name'];            
            $product->description = $input['description'];
            $product->short_description = isset($input['short-description']) ? $input['short-description'] : null;
            $product->category_id = $input['category_id'];
            $product->price  = $input['price'];
            $product->discount  = isset($input['discount']) ? $input['discount'] : null ;
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
        $product = Product::with('media')->where('id', $id)->get(); 
        if ($product->isEmpty()) {
            // Return an error response if the product does not exist
            return response()->json(['success' => false, 'error'=> 'Product not found'], 404); 	
        }      
        // Return a JSON response
        return response()->json($product, 200);	
    }

    public function editProductForm(Request $request, string $id)
    {       
        $categories = Category::all();
        $action = 'edit';
        $product = Product::with('media')->where('id', $id)->get(); 
        if ($product->isEmpty()) {
            // Return an error response if the product does not exist
            abort(404, 'Product not found');
        }    
        return view('ecom.product-form', compact('action', 'product', 'categories'));        
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
            $product->discount  = isset($input['discount']) ? $input['discount'] : null ;
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
            // Remove the existing media
            $product->clearMediaCollection('product_image');
            $product->clearMediaCollection('product_gallery');
            $product->delete();         
        } catch (ModelNotFoundException $e) {
            return response()->json(['success'=> false, 'error'=> 'Product not found'], 404 );
        }        
    
        $message = 'Product deleted successfully';;
        return response()->json(['success'=> true, 'message' => $message], $this->successStatus);
    }
}