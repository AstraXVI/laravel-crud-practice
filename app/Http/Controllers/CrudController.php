<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrudModel;

class CrudController extends Controller
{
    public function insert(Request $request){
        $db = new CrudModel();
 
        $db->fullname = $request->fname;
        $db->email = $request->email;
        $db->mobile_num = $request->mobileNum;
 
        $db->save();
    }

    public function getContact(){
        $fetchContactData = CrudModel::get();

        $contactData = array();

        foreach($fetchContactData as $data){

            $action = '<button type="button" id="updateBtn" class="btn btn-info" data-id="'.$data->id.'" data-fullname="'.$data->fullname.'" data-email="'.$data->email.'" data-mobilenum="'.$data->mobile_num.'" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
            <button type="button" class="btn btn-danger" id="deleteBtn" data-id="'.$data->id.'">Delete</button>
            ';

            $contactData[] = array(
                'fname' => $data->fullname,
                'email' => $data->email,
                'mobileNum' => $data->mobile_num,
                'action' => $action,
            );
        }

        return json_encode($contactData);
    }


    public function update(Request $request){

        $contact = CrudModel::find($request->id);
 
        $contact->fullname = $request->fname;
        $contact->email = $request->email;
        $contact->mobile_num = $request->mobileNum;
         
        $contact->update();
    }


    public function delete(Request $request){

        $deleteContact = CrudModel::find($request->id)->delete();
    }



}
