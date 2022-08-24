
@extends('layouts.app')
@section('content')
    @livewire('login')

    @livewireScripts

 @endsection   

<style type="text/css">
    #sin-up .card{
        box-shadow: 0 .1rem 1rem .25rem rgba(0,0,0,.05)!important;
        border: none!important;
        padding: 50px;
        border-radius: 10px;
    }
    #sin-up .img img{
        width: 200px;
        margin: 0 auto;
        display: block;
    }
    #sin-up .head-txt{
        text-align: center;
    }
    #sin-up .head-txt h2{
        color: #211f1c;
        font-weight: 600;
    }
    #sin-up .head-txt p{
        color: #b5b0a1;
        font-weight: 600;
        font-size: 16px;
    }
    #sin-up .head-txt p a{
        color: #4fc9da;
        text-decoration: none;
    }
    #sin-up .card label{
        color: #211f1c;
        font-size: 16px;
    }
    #sin-up .card input{
        background-color: #f8f6f2;
        border-color: #f8f6f2;
        color: #716d66;
        height: 40px;
        transition: color .2s ease,background-color .2s ease;
    }
    #sin-up .card .form-check{
        padding: 0;
    }
    #sin-up .card .btn-primary{
        display: block;
        width: 100%;
        height: 45px;
        background-color: #063579;
        font-size: 18px;
    }
    input[type=checkbox] + label {
          display: block;
          margin: 0.2em;
          cursor: pointer;
          padding: 0.2em;
        }

        input[type=checkbox] {
          display: none;
        }

        input[type=checkbox] + label:before {
          content: "\2714";
          border: 0.1em solid #000;
          border-radius: 0.2em;
          display: inline-block;
          width: 25px;
          height: 25px;
          padding-left: 0.2em;
          padding-bottom: 0.3em;
          margin-right: 0.2em;
          vertical-align: bottom;
          color: transparent;
          transition: .2s;
        }

        input[type=checkbox] + label:active:before {
          transform: scale(0);
        }

        input[type=checkbox]:checked + label:before {
          background-color: #063579;
          border-color: #063579;
          color: #fff;
        }

        input[type=checkbox]:disabled + label:before {
          transform: scale(1);
          border-color: #aaa;
        }

        input[type=checkbox]:checked:disabled + label:before {
          transform: scale(1);
          background-color: #bfb;
          border-color: #bfb;
        }

        @media (min-width: 320px) and (max-width: 767px) {
            #sin-up .card{
                padding: 10px;
            }
        }

</style>
    
