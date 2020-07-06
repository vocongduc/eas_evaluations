<div class="card-body">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Tên Team @error('name')<span class="help-block">*</span>@enderror</label>
        <div class="col-sm-10 {{ $errors->has('name') ? 'has-error' : '' }}">
            <input type="text" class="form-control" id="name" name="name" value="{{ isset($team) ? ($errors->has('name') ? old('name') : $team->name) : old('name') }}">
            @error('name')
                <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row" style="display: flex">
        <label for="name" class="col-sm-2 col-form-label">Tên Khóa Học @error('name')<span class="help-block">*</span>@enderror</label>
        <div class="col-sm-10">
            <select class="form-control" name="course_id">
                <option value="">Chọn Khóa Học</option>
                @foreach($courses as $id => $name)
                    <option value="{{ $id }}" {{ (isset($team) && ($team->course_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <br/>
            @error('course_id')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="modal-footer" style="width: 100%">
            <a href="{{ route('teams.index') }}">
                <input type="button" class="btn btn-secondary btn-action" value="Hủy Bỏ" >
            </a>
            <button class="btn btn-danger">Lưu</button>
        </div>
    </div>
</div>
