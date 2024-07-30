<div  x-data="{formShow: @entangle('showForm')}">
    <div class="d-flex justify-content-between">
        <h2 class="h5 text-uppercase mb-4">Addresses</h2>
        <div class="ml-auto">
            <button type="button" @click="formShow = true" class="btn btn-primary rounded shadow">
                Add new address
            </button>
        </div>
    </div>

    <div x-show="formShow" @click.away="formShow = false"   class="form-container">
    <form  wire:submit.prevent="{{ ($editMode == true ) ? 'update_address' : 'store_address' }}" >
        
        @if ($editMode)
            <input type="hidden" wire:model="address_id" class="form_control">
        @endif
        
        <div class="row">
            <div class="col-lg-8 form-group">
                <label class="text-small text-uppercase" for="address_title">Address title</label>
                <input class="form-control" wire:model="address_title" type="text" placeholder="Enter Address Title">
                @error('address_title')
                    <span class="text-danger">{{$message}}</span>                    
                @enderror
            </div>

            <div class="col-lg-4 form-group">
                <label class="text-small text-uppercase" >&nbsp; </label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="default_address" wire:model="default_address">
                    <label for="default_address">Default Address ?</label>
                </div>
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="first_name" class="text-small text-uppercase" >First name </label>
                <input wire:model="first_name"  class="form-control form-control-lg" type="text">
                @error('first_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="last_name" class="text-small text-uppercase" >Last name </label>
                <input wire:model="last_name"  class="form-control form-control-lg" type="text">
                @error('last_name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="email" class="text-small text-uppercase" >Email </label>
                <input wire:model="email"  class="form-control form-control-lg" type="text">
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="mobile" class="text-small text-uppercase" >Mobile </label>
                <input wire:model="mobile"  class="form-control form-control-lg" type="text">
                @error('mobile')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="address" class="text-small text-uppercase" >Address </label>
                <input wire:model="address"  class="form-control form-control-lg" type="text">
                @error('address')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="address2" class="text-small text-uppercase" >Address2 </label>
                <input wire:model="address2"  class="form-control form-control-lg" type="text">
                @error('address2')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-4 form-group pt-2" >
                <label for="country_id" class="text-small text-uppercase" >Country </label>
                <select class="form-control form-control-lg" wire:model="country_id">
                    <option value=""></option>
                    @forelse ($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @empty
                        
                    @endforelse
                </select>
                @error('country_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-4 form-group pt-2" >
                <label for="state_id" class="text-small text-uppercase" >Satate </label>
                <select class="form-control form-control-lg" wire:model="state_id">
                    <option value=""></option>
                    @forelse ($states as $state)
                        <option value="{{$state->id}}">{{$state->name}}</option>
                    @empty
                        
                    @endforelse
                </select>
                @error('state_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-4 form-group pt-2" >
                <label for="city_id" class="text-small text-uppercase" >City </label>
                <select class="form-control form-control-lg" wire:model="city_id">
                    <option value=""></option>
                    @forelse ($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                    @empty
                        
                    @endforelse
                </select>
                @error('city_id')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="zip_code" class="text-small text-uppercase" >Zip Code </label>
                <input wire:model="zip_code"  class="form-control form-control-lg" type="text">
                @error('zip_code')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-6 form-group pt-2" >
                <label for="po_box" class="text-small text-uppercase" > P.O.Box </label>
                <input wire:model="po_box"  class="form-control form-control-lg" type="text">
                @error('po_box')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="col-lg-12 form-group pt-2">
                <button class="btn btn-dark" type="submit">
                    {{$editMode ? 'Update Address' : 'Add Address'}}
                </button>
            </div>


        </div>

    </form>
    </div>
  

    <div class="my-4">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Address title</th>
                        <th>Default</th>
                        <th class="col-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($addresses as $address)
                        <tr>
                            <td>{{$address->address_title}}</td>
                            <td>{{$address->defaultAddress()}}</td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" wire:click.prevent="edit_address('{{$address->id}}')" class="btn btn-success ">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" wire:click.prevent="delete_address('{{$address->id}}')" class="btn btn-danger ">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No Addresses found</td>
                        </tr>
                    @endforelse
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
