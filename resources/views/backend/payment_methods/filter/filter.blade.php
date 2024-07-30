<div class="card-body">
    <form action="{{ route('admin.payment_methods.index') }}" method="get">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-2">
                <div class="form-group">
                    <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}"
                        class="form-control" placeholder="ابحث هنا">
                </div>
            </div>
            <div class="col-md-2 d-none d-md-block">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">عرض الكل</option>
                        <option value="1" {{ old('status', request()->input('status')) == '1' ? 'selected' : '' }}>
                            مفعل</option>
                        <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>
                            غير مفعل</option>
                    </select>
                </div>
            </div>
            <div class="d-none d-sm-block col-sm-4 col-md-2">
                <div class="form-group">
                    <select name="sort_by" class="form-control">
                        {{-- <option value="">---</option> --}}
                        <option value="id"
                            {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>رقم الحقل
                        </option>
                        <option value="name"
                            {{ old('sort_by', request()->input('sort_by')) == 'name' ? 'selected' : '' }}>عنوان شركة
                            الدفع
                        </option>
                        <option value="created_at"
                            {{ old('sort_by', request()->input('sort_by')) == 'created_at' ? 'selected' : '' }}>
                            تاريخ الانشاء
                        </option>
                        <option value="published_on"
                            {{ old('sort_by', request()->input('sort_by')) == 'published_on' ? 'selected' : '' }}>
                            تاريخ النشر</option>

                    </select>
                </div>
            </div>
            <div class="col-md-2 d-none d-md-block">
                <div class="form-group">
                    <select name="order_by" class="form-control">
                        {{-- <option value="">---</option> --}}
                        <option value="asc"
                            {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>تصاعدي
                        </option>
                        <option value="desc"
                            {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : '' }}>تنازلي
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-1 d-none d-md-block">
                <div class="form-group">
                    <select name="limit_by" class="form-control">
                        {{-- <option value="">---</option> --}}
                        <option value="10"
                            {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                        <option value="20"
                            {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : '' }}>20</option>
                        <option value="50"
                            {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : '' }}>50</option>
                        <option value="100"
                            {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            <div class="col-2 col-sm-2 col-md-2 ">
            </div>
            <div class="col-2 col-sm-2 col-md-1">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-link">بحث</button>
                </div>
            </div>
        </div>
    </form>
</div>
