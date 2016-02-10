<?php

namespace App\Http\Controllers;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {
    
    public function home(){
        
        $name = 'Hasan';
    
    return view('welcome') ->with('name', $name);
    }
    
    public function main(){
    
    return view('main');
    }
}
    