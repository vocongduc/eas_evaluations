<div class="card-body">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Tiêu Đề</label>
        <div class="col-sm-10 ">
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên form..." value="{{ isset($form) ? ($errors->has('name') ? old('name') : $form->name) : old('name') }}">
            @error('name')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Maint Point</label>
        <div class="col-sm-10 ">
            <select class="custom-select dynamic main_point_id" id="main_point_id" name="main_point_id" data-dependent="category_id">
                <option selected="" value="">Choose...</option>
                @foreach($mainpoints as $mainpoint => $key)
                    <option value="{{ $key }}">{{ $mainpoint }}</option>
                @endforeach
            </select>
            @error('main_point_id')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Danh Mục</label>
        <div class="col-sm-10 ">
            <select class="custom-select dynamic" id="category_id" name="category_id"  data-dependent="criteria_id">
                <option selected="" value="">Choose...</option>
            </select>
            @error('category_id')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Danh Sách Tiêu Chí</label>
        <div class="col-sm-10 ">
            <!-- table point -->
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Chọn</th>
                    <th scope="col">Tiêu chí</th>
                    <th scope="col">Điểm</th>
                </tr>
                </thead>
                <tbody id="criteria_id" name="criteria_id">
                <tr></tr>
                </tbody>
            </table>
            @error('criteria_id')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Mô Tả Form Đánh Giá</label>
        <div class="col-sm-10 ">
            <textarea id="editor1" required name="description">{{ isset($form) ? ($errors->has('description') ? old('description') : $form->description) : old('description') }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="modal-footer" style="width: 100%">
            <a href="{{ route('forms.index') }}">
                <input type="button" class="btn btn-secondary btn-action" value="Hủy Bỏ">
            </a>
            <button class="btn btn-danger">Lưu</button>
        </div>
    </div>
</div>
<input type="hidden" name="criteria_id" value="{{ isset($form) ? ($errors->has('criteria_id') ? old('criteria_id') : $arrCriteriasForm) : old('criteria_id') }}"/>

