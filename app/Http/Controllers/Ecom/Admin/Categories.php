<?php

namespace App\Http\Controllers\Ecom\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Ecom\Admin\Media;
use App\Models\Category;
use App\Models\Product;
use Validator;


class Categories extends Controller
{
    public $successStatus = 200;
	public $errorStatus = 400;

    protected $mediaHandler;

    public function __construct(Media $media)
    {
        $this->mediaHandler = $media;
    }
	
	public function showCategories()
    {
        //$categories = Category::with('media')->get(); dd($categories);
       // return view('ecom.categories', ['categories' => $categories]);
        return view('ecom.categories');
    }

    public function createCategory()
    {
        $categories = Category::all();
        return view('ecom.add-category', compact('categories'));
    }

    /* Get All Category  */
    public function getAllCategories()
    {
        try {
            $categories = Category::with('media')->get(); 
		    return response()->json(['success' => true, 'data' => $categories], $this->successStatus); 
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

    /* Add new Category  */
    public function storeCategory(Request $request)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
                'category_parent' => 'required|numeric',
                'order' => 'required|numeric',
                'image-thumb' => 'required|file|mimes:jpg,png,webp'                
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 	

            /* Category Data */ 
            $category = new Category();
            $category->name = $input['name'];
            $category->category_parent = $input['category_parent'];            
            $category->order = $input['order'];
            $category->save();
        
            /* Category Images */ 
            if ($request->hasFile('image-thumb')) {                 
                $uploaded = $this->mediaHandler->uploadMedia($request, 'image-thumb', $category, 'categories');                           
            }

            $message = 'Category added successfully';;
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

    public function editCategory(Request $request, string $id)
    {
        $categories = Category::all();
        $category = Category::with('media')->where('id', $id)->get(); 
        //dd($category);
        return view('ecom.edit-category', compact('category', 'categories'));
    }

    /* Update Category  */
    public function updateCategory(Request $request)
    {
        try {			
			$validator = Validator::make($request->all(), [ 
                'name' => 'required|min:3',
                'category_id' => 'required',
                'category_parent' => 'required|numeric',
                'order' => 'required|numeric',
                'image-thumb' => 'required|file|mimes:jpg,png,webp'                
            ]);
            if ($validator->fails()) {   
				$message = 'Validation Error';
                return response()->json(['success' => false, 'error'=>$validator->errors(), 'message' => $message], 401); 				
            }
			$input = $request->all(); 
            
   // $message = 'Category updated successfully';;
  //  return response()->json(['success'=> true, 'message' => $message], $this->successStatus);

            /* Category Data */            
            $category = Category::findOrFail($input['category_id']);
            $category->name = $input['name'];
            $category->category_parent = $input['category_parent'];            
            $category->order = $input['order'];                   
            $category->save();                         

            /* Category Images */            
            if ($request->hasFile('image-thumb')) { 
                //$mediaHandler = new Media();
                $clearmedia = $this->mediaHandler->clearMedia($category, 'categories');
                $uploaded = $this->mediaHandler->uploadMedia($request, 'image-thumb', $category, 'categories');
            }

            $message = 'Category updated successfully';;
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

    /* Delete Category  */
    public function deleteCategory(Request $request, $id)
    {
        try {	
            $category = Category::findOrFail($id);
            // Remove the existing media
            $category->clearMediaCollection('categories');
            $category->delete();
            
            $message = 'Category deleted successfully';;
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