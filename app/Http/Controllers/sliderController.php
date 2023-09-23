<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\Slider;
use Illuminate\Http\Request;

class sliderController extends Controller
{
    public function getData()
    {
        $images = Slider::orderBy('display_order')->get();
        // dd($images);
        return view('image-silder', compact('images'));
    }


    // public function updateOrder(Request $request)
    // {
    //     $data = $request->input('dataArray');

    //     // Dump and die to print the data for debugging
    //     // dd($data);

    //     // ------------------------------

    //     // $jsonData = $request->input('dataArray');
    //     // $dataArray = json_decode($jsonData, true);
    //     // foreach ($dataArray as $item) {
    //     //     $id = $item['id'];

    //     //     // Find the Slider record by its 'id'
    //     //     $imageData = Slider::find($id);

    //     //     if ($imageData) {
    //     //         // Update the fields based on the data in $item
    //     //         $imageData->image_url = $item['image_url'];

    //     //         // Save the updated record
    //     //         $imageData->save();
    //     //     }
    //     // }

    //     return response()->json(['message' => $data]);
    // }


    public function store(Request $request)
    {
        // $request->validate([
        //     'image_url' => 'required|string',
        //     'display_order' => 'required|integer',
        // ]);

        // Create a new Slider instance and save it
        Slider::create([
            'image_url' => $request->input('image_url'),
            'display_order' => Slider::count() + 1,
        ]);

        return redirect()->route('slider_home')->with('success', 'Image created successfully');
    }

    public function destroy($id)
    {
        // Find the Slider record by its 'id'
        $imageData = Slider::find($id);

        if (!$imageData) {
            return redirect()->route('slider_home')->with('error', 'Image not found');
        }

        // Delete the record
        $imageData->delete();

        return redirect()->route('slider_home')->with('success', 'Image deleted successfully');
    }
    public function updateOrder(Request $request, $index)
    {
        $inputValue = (int)$request->input('input_name');
        // $copyArray = [...$inputValue];

        
        $imageArray = Slider::orderBy('display_order')->pluck('id')->toArray();

        if (count($imageArray) >= $inputValue && $inputValue >= 1){
            $key = array_search((int)$index, $imageArray);
            if ($key !== false) {
                unset($imageArray[$key]);
            }
            
            array_splice($imageArray, $inputValue-1, 0, (int)$index);
            
            foreach ($imageArray as $indx => $item) {
                $imageData = Slider::find($item);
                $imageData->display_order = $indx+1;
                $imageData->save();
                echo(" | ". $item );
            }
            return redirect()->route('slider_home')->with('warning', 'Image order change');
        } else {
            return redirect()->route('slider_home')->with('error', 'Order limit cross');
        }

    }
}
