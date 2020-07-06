<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class User extends Model implements Authenticatable, CanResetPasswordContract

{
    use HasRoles;
    use Notifiable;
    use AuthenticatableTrait;
    use CanResetPassword;

    protected $table = 'users';
    protected $fillable = ['id', 'name', 'email', 'address', 'phone', 'image', 'birth_day', 'password','guard_name','status','team_id'];
    protected $hidden = ['remember_token'];

    /**
     * rls form permit
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function formPermit(){
        return $this->hasMany(FormPermit::class);
    }

    /**
     * rls form
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function form(){
        return $this->belongsToMany(Form::class, UserForm::class, 'user_id', 'form_id');
    }

    /**
     * rls user form
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userForm(){
        return $this->hasMany(UserForm::class);
    }

    /**
     * relationship with roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class);
    }

    public function form_permit()
    {
        return $this->belongsTo(FormPermission::class,'user_id','id');
    }
    /**
     * Get the team that owns the user.
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    /**
     * rls user mainPointUsers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mainPointUsers(){
        return $this->hasMany(MainPointUserFormPermit::class, 'user_id', 'id');
    }

    /**
     * get information user
     *
     * @return \App\Models\User
     */
	public function getUser($id)
	{
        return User::findOrFail($id);
	}

    /**
     * Update user
     *
     * @param \Illuminate\Http\Request $request
     * @param array $input
     * @return boolean
     */
    public function updateUser($input, $id)
    {
        $user = User::findOrFail($id);

        if (isset($input['image'])) {
            $fileExtension = $input['image']->getClientOriginalExtension();
            $uploadPath = 'upload';
            $fileName =$uploadPath .'/'.time() . "_image".'.'. $fileExtension;
            $input['image']->move($uploadPath, $fileName);
            $input['image'] = $fileName;
        }
        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
        return $user->update($input);
    }

    /**
     * user search
     *
     * @param $name
     * @return mixed
     */
    public function search($name){
        $users = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select(DB::raw('users.name as user_name,
                    users.email,
                    users.image,
                    users.address,
                    users.id,
                    model_has_roles.role_id,
                    roles.name as role_name'))
            ->where('users.name','like',"%{$name}%")->paginate(10);
        return $users;
    }

    /**
     * create users
     *
     * @param $data
     * @param $fileName
     * @return mixed
     */
    public function store($data, $fileName){
        $upload = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phoneNumber'],
            'image' => $fileName,
            'birth_day' => $data['birthDate'],
            'password' => Hash::make('123456'),
            'guard_name' => 'web',
            'team_id' => $data['team_id']
        ]);
        return $upload;
    }

    /**
     * update user
     *
     * @param $data
     * @param $fileName
     * @param $id
     * @return mixed
     */
    public function updateData($data, $fileName, $id){
        User::where('id',$id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phoneNumber'],
            'image' => $fileName,
            'birth_day' => $data['birthDate'],
            'password' => Hash::make('Aa@12345'),
            'guard_name' => 'web',
            'team_id' => $data['team_id']
        ]);
        return true;
    }
}
