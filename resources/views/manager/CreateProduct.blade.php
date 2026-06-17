@extends('layout.layouts')
@section('CreateProduct', 'создание продукта')
@section('content')
    <div class="content_row">
        @if(session()->has('success'))
            <div class="content_row" style="color: #1b60d6">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="content_column">
            <h2>Добавление тавара</h2>
            <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form_group">
                    <input type="text" name="name" placeholder="Введите название"  value="">
                </div>

                <div class="form_group">
                    <input type="text" name="price" placeholder="Введите цену"  value="">
                </div>

                <div class="form_group">
                    <input type="text" name="qty" placeholder="Введите количество"  value="">
                </div>

                <div class="form_group">
                    <input type="text" name="description" placeholder="Введите описание"  value="">
                </div>

{{--                <div class="form_group">--}}
{{--                    <select name="category_id">--}}
{{--                        <option disabled  selected>Выберите категорию</option>--}}
{{--                        @foreach($categories as $categ)--}}
{{--                            <option value="{{ $categ->id }}">{{ $categ->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

                <div class="form_group">
                    <input type="file" name="image">
                </div>

                <div class="form_group">
                    <input type="submit" value="Добавить">
                </div>
            </form>
        </div>
    </div>
@endsection
