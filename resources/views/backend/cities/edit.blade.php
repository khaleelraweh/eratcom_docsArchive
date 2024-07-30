@extends('layouts.admin')
@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_city') }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            <i class="fa fa-solid fa-chevron-left chevron"></i>
                        @else
                            <i class="fa fa-solid fa-chevron-right chevron"></i>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('admin.cities.index') }}">
                            {{ __('panel.show_cities') }}
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- body part  --}}
        <div class="card-body">
            <form action="{{ route('admin.cities.update', $city->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-12 col-md-6 pt-4">
                        <div class="form-group">
                            <label for="name">إسم المدينة</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $city->name) }}"
                                class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 pt-4">
                        <div class="form-group">
                            <label for="name_native">إسم المدينة native</label>
                            <input type="text" id="name_native" native="name_native"
                                value="{{ old('name_native', $city->name_native) }}" class="form-control">
                            @error('name_native')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 pt-4">
                        <label for="state_id">المقاطعة</label>
                        <select name="state_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($states as $state)
                                <option value="{{ $state->id }}"
                                    {{ old('state_id', $city->state->id) == $state->id ? 'selected' : null }}>
                                    {{ $state->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('state_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-12 col-md-6 pt-4">
                        <label for="status">الحالة</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $city->status) == '1' ? 'selected' : null }}>مفعل
                            </option>
                            <option value="0" {{ old('status', $city->status) == '0' ? 'selected' : null }}>غير مفعل
                            </option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                {{-- end row --}}

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">
                        {{ __('panel.update_data') }}
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
