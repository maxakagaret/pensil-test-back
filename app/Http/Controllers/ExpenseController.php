<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Validator;

class ExpenseController extends Controller
{
    /**
     * JSON response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($status, $result, $message)
    {
        $responseCode = $status?200:404;
        $response = [
            'success' => $status,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, $responseCode);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Expense::all();
        return $this->sendResponse(true, $data->toArray(), 'Expenses retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'date' => 'required',
            'sum' => 'required'
        ]);
        if($validator->fails()){
            $messagesBag = $validator->errors()->getMessages();
            $errors = '';
            foreach($messagesBag as $key=>$message) {
                $errors.= ' '.$key;
            }
            return $this->sendResponse(false,[],'Validation Error. Fields:'.$errors);
        }
        $expense = Expense::create($input);
        return $this->sendResponse(true,['id'=>$expense->id],'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        if (is_null($expense)) {
            return $this->sendResponse(false,[],'Product not found.');
        }
        return $this->sendResponse(true,$expense->toArray(),'Product retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Expense $expense)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'date' => 'required',
            'sum' => 'required',
            'comment' => '',
            'name' => ''
        ]);
        if($validator->fails()){
            $messagesBag = $validator->errors()->getMessages();
            $errors = '';
            foreach($messagesBag as $key=>$message) {
                $errors.= ' '.$key;
            }
            return $this->sendResponse(false,[],'Validation Error. Fields:'.$errors);
        }
        $expense = Expense::find($id);
        $expense->date = $input['date'];
        $expense->sum = $input['sum'];
        $expense->comment = $input['comment'];
        $expense->save();
        return $this->sendResponse(true,[],'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return $this->sendResponse(true,[],'Product deleted successfully.');
    }
}