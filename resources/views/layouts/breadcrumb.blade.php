<?php
$url = request()->getPathInfo();
$items = explode('/',$url);
unset($items[0])
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                   @foreach ($items as $key => $item)
                   @if ($key == count($items))
                   <li class="breadcrumb-item" aria-current="page">{{Str::ucfirst($item)}}</li>
                       
                   @else
                   <li class="breadcrumb-item" ><a href="/{{$item}}">{{Str::ucfirst($item)}}</a></li>
                   @endif
                   @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
  </section>