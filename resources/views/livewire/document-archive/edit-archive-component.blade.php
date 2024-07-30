<div>
    <form action="{{ route('admin.document_archives.update', $documentArchive->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="row">
            <div class="col-sm-12 col-md-9">

                <!-- document category -->
                <div class="row">



                    <div class="col-sm-12 col-md-6   pt-3">
                        <label for="document_category_id" class="text-small text-uppercase">
                            {{ __('panel.document_category_name') }} </label>
                        <select class="form-control form-control-lg" name="document_category_id"
                            wire:model="document_category_id">
                            <option value="">---</option>
                            @forelse ($document_categories as $document_category)
                                <option value="{{ $document_category->id }}"
                                    {{ old('document_category_id', $documentArchive->documentType->documentCategory->id) == $document_category->id ? 'selected' : null }}>
                                    {{ $document_category->doc_cat_name }}

                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('document_category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12  col-md-6 pt-3">

                        <label for="document_type_id" class="text-small text-uppercase">
                            {{ __('panel.document_type_name') }}
                        </label>
                        <select class="form-control form-control-lg" name="document_type_id"
                            wire:model="document_type_id">
                            <option value="">---</option>
                            @forelse ($document_types as $document_type)
                                <option value="{{ $document_type->id }}">
                                    {{ $document_type->doc_type_name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('document_type_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 pt-3">
                        <label for="doc_archive_name"> {{ __('panel.document_archive_name') }} </label>
                        <input type="text" id="doc_archive_name" wire:model="doc_archive_name"
                            name="doc_archive_name" value="{{ old('doc_archive_name') }}" class="form-control"
                            placeholder="">
                        @error('doc_archive_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- row -->
                <div class="row" wire:ignore>
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h6 class="card-title mb-1">ارفق مستند هنا </h6>
                                    <p class="text-muted card-sub-title">يجب ان يكون المستند ضمن الصيغ التالية ( .pdf ,
                                        .docx)</p>
                                </div>

                                <div>

                                    <input type="file" name="doc_archive_attached_file" class="dropify"
                                        data-default-file="{{ asset('assets/document_archives/' . $documentArchive->doc_archive_attached_file) }}"
                                        accept=".pdf, .docx" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-md-3">

                {{-- publish_start publish time field --}}
                <div class="row">
                    <div class="col-sm-12 col-md-12 pt-3">
                        <label for="published_on"> {{ __('panel.published_date') }} </label>
                        <input type="text" id="published_on" wire:model.defer="published_on" name="published_on"
                            value="{{ old('published_on', now()->format('Y-m-d H:i A')) }}"
                            class="form-control flatpickr_publihsed_on">
                        @error('published_on')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 pt-3">
                        <label for="status">{{ __('panel.status') }}</label>
                        <div class="main-toggle-group-demo">
                            <div class="main-toggle main-toggle-success {{ $status == 1 ? 'on' : '' }}"
                                id="main-toggler" wire:click="toggleStatus">
                                <span></span>
                            </div>
                        </div>
                        <input type="hidden" wire:model.defer="status" name="status" id="status"
                            value="{{ $status }}">
                    </div>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 ">
                {{-- submit button  --}}
                <div class="form-group pt-3">
                    <button type="submit" name="submit" class="btn btn-primary">
                        {{ __('panel.save_data') }}</button>
                </div>
            </div>
        </div>

    </form>
</div>
