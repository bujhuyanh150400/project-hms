<?php

namespace App\Http\Requests\Admin\UsersController;

use App\Helper\PermissionAdmin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email',Rule::unique('users')],
            'name' => 'required',
            'password' => 'required|min:8|max:36',
            'conf_pass' => 'required|min:8|max:36|same:password',
            'address' => 'required|max:255',
            'phone' => 'required|numeric',
            'birth' => 'required|date',
            'gender' => 'required|in:1,2',
            'permission' => ['required',Rule::in(array_keys(PermissionAdmin::getList()))],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã tồn tại trong hệ thống.',

            'name.required' => 'Vui lòng nhập tên.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 36 ký tự.',

            'conf_pass.required' => 'Vui lòng nhập lại mật khẩu.',
            'conf_pass.min' => 'Mật khẩu xác nhận phải có ít nhất 8 ký tự.',
            'conf_pass.max' => 'Mật khẩu xác nhận không được vượt quá 36 ký tự.',
            'conf_pass.same' => 'Mật khẩu xác nhận không trùng khớp với mật khẩu.',

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
        ];
    }
}
