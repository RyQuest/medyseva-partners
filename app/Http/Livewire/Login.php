<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Hash;
use App\User;
class Login extends Component
{
    public $email, $password;
    public function render()
    {
        return view('livewire.login')->extends('layouts.app');
    }


    public function login()
    {   
       
     
        $this->validate( [
            'email' => 'required|email',
            'password' => 'required',
        ]);
     
        if(auth()->attempt(array('email' => $this->email, 'password' => $this->password)))
        {
            if (auth()->user()->role == 'admin') {
                return redirect()->to('admin.home');
            }else if (auth()->user()->role == 'manager') {
                return redirect()->to('manager.home');
            }else{
                return redirect()->to('home');
            }
        }else{
            session()->flash('error', 'Email-Address And Password Are Wrong.');

            return redirect()->to('/');
                
        }
          
    }





}
