<div>

    <input type="hidden" id="old_province" value="{{ old($province, $object->province ?? '') }}" />
    <input type="hidden" id="old_district" value="{{ old($district, $object->district ?? '') }}" />
    <input type="hidden" id="old_ward" value="{{ old($ward, $object->ward ?? '') }}" />

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-2">
        <div class="form-group" id="provinces-container" style="display: none">
            <label for="provinces" class="@error($province) form-label-error @else form-label @enderror">Chọn Tỉnh/Thành
                phố</label>
            <select id="provinces" name="{{ $province }}"></select>
            @error($province)
                <span class="form-alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group" id="districts-container" style="display: none">
            <label for="provinces" class="@error($district) form-label-error @else form-label @enderror">Chọn
                Quận/Huyện</label>
            <select id="districts" name="{{ $district }}"></select>
            @error($province)
                <span class="form-alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group" id="wards-container" style="display: none">
            <label for="provinces" class="@error($ward) form-label-error @else form-label @enderror">Chọn
                Xã/Phường</label>
            <select id="wards" name="{{ $ward }}"></select>
            @error($ward)
                <span class="form-alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group" id="detail-address-container" style="display:none;">
        <label for="detail-address" class="@error($address) form-label-error @else form-label @enderror">Chọn Tỉnh/Thành
            phố</label>
        <input type="text" class=" @error($address) form-input-error @else form-input @enderror" id="detail-address"
            name="{{ $address }}" value="{{ old($address, $object->address ?? '') }}"
            placeholder="Nhập chi tiết địa chỉ" />
        @error($address)
            <span class="form-alert">{{ $message }}</span>
        @enderror
    </div>
</div>
<script type="module">
    await provincesSelect.start()
</script>
