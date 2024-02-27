<?php

namespace App\Http\Requests\Admin\UsersController;

use App\Helper\PermissionAdmin;
use App\Helper\UserStatus;
use App\Models\Clinic;
use App\Models\Specialties;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clinicIds = Clinic::pluck('id')->toArray();
        $speciatiyIds = Specialties::pluck('id')->toArray();
        return [
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->route('id'))],
            'name' => 'required',
            'address' => 'required|max:255',
            'phone' => 'required|numeric',
            'birth' => 'required|date',
            'gender' => 'required|in:1,2',
            'permission' => ['required', Rule::in(array_keys(PermissionAdmin::getList()))],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'clinic_id' => ['required', Rule::in($clinicIds)],
            'specialties_id' => ['required', Rule::in($speciatiyIds)],
            'description' => 'required|min:5',
            'user_status' => ['required', Rule::in(array_keys(UserStatus::getList()))],
            'examination_price' => 'required|integer|min:0',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã tồn tại trong hệ thống.',
            'name.required' => 'Vui lòng nhập tên.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'birth.required' => 'Vui lòng nhập ngày sinh.',
            'birth.date' => 'Ngày sinh không hợp lệ.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'permission.required' => 'Vui lòng chọn vai trò của người dùng.',
            'permission.in' => 'Bạn đang cố tình chọn sai quyền',
            'avatar.image' => 'Phải là ảnh',
            'avatar.mimes' => 'Bạn phải chọn các file jpeg,png,jpg,gif,svg',
            'avatar.max' => 'File tối đa 2048KB',
            'clinic_id.required' => 'Bạn cần chọn cơ sở trực thuộc',
            'clinic_id.in' => 'Cơ sở trực thuộc không tồn tại',
            'specialties_id.required' => 'Bạn cần chọn chuyên khoa phụ trách',
            'specialties_id.in' => 'Chuyên khoa phụ trách không tồn tại',
            'description.required' => 'Hãy nhập mô tả về bản thân',
            'description.min' => 'Hãy nhập ít nhất 5 kí tự',
            'user_status.required' => 'Bạn cần chọn cấp bậc',
            'user_status.in' => 'Cấp bậc không tồn tại',
            'examination_price.required' => 'Hãy nhập giá tiền khám',
            'examination_price.integer' => 'Giá tiền khám phải là số nguyên',
            'examination_price.min' => 'Giá tiền khám bé nhất = 0',
        ];
    }
}
