<div class="card-body">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Tên Khóa Học @error('name')<span class="help-block">*</span>@enderror</label>
        <div class="col-sm-10 {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($course) ? ($errors->has('name') ? old('name') : $course->name) : old('name') }}">
            @error('name')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">Thời Gian Khóa Học @error('date_start')<span class="help-block">*</span>@enderror</label>
        <div class="col-sm-4 {{ $errors->has('date_start') ? 'has-error' : '' }}">
            <input type="date" class="form-control" id="date_start" name="date_start" value="{{ isset($course) ? ($errors->has('date_start') ? old('date_start') : $course->date_start) : old('date_start') }}">
            @error('date_start')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
        <label style="text-align: center" for="address" class="col-sm-2 col-form-label">Đến Ngày @error('date_start')<span class="help-block">*</span>@enderror</label>
        <div class="col-sm-4 {{ $errors->has('date_end') ? 'has-error' : '' }}">
            <input type="date" class="form-control date" id="date_end" name="date_end" value="{{ isset($course) ? ($errors->has('date_end') ? old('date_end') : $course->date_end) : old('date_end') }}">
            @error('date_end')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Mô Tả @error('description')<span class="help-block">*</span>@enderror</label>
        <div class="col-sm-10 {{ $errors->has('name') ? 'has-error' : '' }}">
            <textarea id="editor1" required name="description">{{ isset($course) ? ($errors->has('description') ? old('description') : $course->description) : old('description') }}</textarea>
            @error('description')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="modal-footer" style="width: 100%">
            <a href="{{ route('courses.index') }}">
                <input type="button" class="btn btn-secondary btn-action" value="Hủy Bỏ" >
            </a>
            <button class="btn btn-danger">Lưu</button>
        </div>
    </div>
</div>
