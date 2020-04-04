@extends('layouts.app')

@section('content')
    <table>

@foreach($items as $item)
    <tr>
        <td><a href="{{$item->id }}">{{$item->id }}</a></td>
        <td>{{ $item->title }}</td>
        <td>{{ $item->created_at }}</td>
    </tr>
    @endforeach

    </table>
    @endsection
