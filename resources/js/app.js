import "./bootstrap";
import JQuery from 'jquery';
import "bootstrap-icons/font/bootstrap-icons.css";
import {Notyf} from 'notyf';
import 'notyf/notyf.min.css';
import 'flowbite';
import 'flowbite-datepicker';
import 'flowbite/dist/datepicker.turbo.js';
import 'selectize/dist/css/selectize.css';
import 'selectize';

window.$ = JQuery;

const app = {
    navMenu: {
        subMenus: $('.navmenu__left-sub-item'),
        prepareSubNav: function () {
            this.subMenus.each(function (index, subMenu) {
                const subMenuActive = $(subMenu).find("li[data-active='true']");
                if (subMenuActive.length > 0) {
                    $(subMenu).removeClass('hidden');
                } else {
                    $(subMenu).addClass('hidden');
                }
            });

        },
        start: function () {
            this.prepareSubNav();
        }
    },
    start: function () {
        this.navMenu.start();
        // khởi tạo notyf
        const notyf = new Notyf({
            duration: 10000,
            position: {
                x: 'right',
                y: 'top',
            },
            dismissible: true,
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    dismissible: true,
                    icon: {
                        className: 'bi bi-cone-striped',
                        tagName: 'i',
                        text: 'warning'
                    },
                },
                {
                    type: 'error',
                    background: 'indianred',
                    dismissible: true
                },
                {
                    type: 'info',
                    background: '#0ea5e9',
                    icon: false,
                    dismissible: true
                }
            ]
        });
        window.notyf = notyf; // Thêm vào global scope nếu cần
        this.loadingForm();


    },
    loadingForm: function () {
        $('form.form-loading-submit').on('submit', function () {
            $('#loading-section').removeClass('hidden');
        });
    }
}
app.start();

const provinces = {
    PROVINCE: 'province',
    DISTRICT: 'district',
    WARD: 'ward',
    old_province: $('#old_province').val(),
    old_district: $('#old_district').val(),
    old_ward: $('#old_ward').val(),
    loadAjax: function (option = this.PROVINCE, id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${site_root_url}/api/provinces/v1/${option}`,
                type: 'GET',
                data: {id},
                dataType: 'json',
                success: function (response) {
                    resolve(response.data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    reject(thrownError)
                }
            });
        });
    },
    start: async function () {
        const _this = this;
        if (_this.old_province != "") {
            await _this.getProvince();
            $('#provinces')[0].selectize.setValue(_this.old_province);
        } else {
            await _this.getProvince();
        }
        if (_this.old_district != "") {
            await _this.getDistrict(_this.old_province);
            $('#districts')[0].selectize.setValue(_this.old_district);
        }
        if (_this.old_ward != "") {
            await _this.getWard(_this.old_district);
            $('#wards')[0].selectize.setValue(_this.old_ward);
            $('#detail-address-container').fadeIn(100);
        }
        $('#provinces').on('change', async function () {
            await _this.getDistrict($(this).val());
        });
        $('#districts').on('change', async function () {
            await _this.getWard($(this).val());
        });
        $('#wards').on('change', function () {
            $('#detail-address-container').fadeIn(100);
        });
    },
    getProvince: async function (id = "") {
        try {
            const province = await this.loadAjax(this.PROVINCE, id);
            $('#provinces').selectize({
                valueField: 'code',
                labelField: 'name',
                searchField: 'name',
                create: false,
            });
            const selectProvince = $('#provinces')[0].selectize;
            selectProvince.clear();
            selectProvince.clearOptions();
            selectProvince.addOption(province);
            selectProvince.refreshOptions();
            $('#provinces-container').fadeIn(100);
        } catch (error) {
            $('#provinces-container').hide();
            notyf.open({
                type: 'error',
                message: error
            });
        }
    },
    getDistrict: async function (id) {
        try {
            const district = await this.loadAjax(this.DISTRICT, id);
            $('#districts').selectize({
                valueField: 'code',
                labelField: 'name',
                searchField: 'name',
                create: false,
            });
            const setlectDistrict = $('#districts')[0].selectize;
            setlectDistrict.clear();
            setlectDistrict.clearOptions();
            setlectDistrict.addOption(district);
            setlectDistrict.refreshOptions();
            $('#districts-container').fadeIn(100);
        } catch (error) {
            $('#districts-container').hide();
        }
    },
    getWard: async function (id) {
        try {
            const ward = await this.loadAjax(this.WARD, id);
            $('#wards').selectize({
                valueField: 'code',
                labelField: 'name',
                searchField: 'name',
                create: false,
            });
            const selectWards = $('#wards')[0].selectize;
            selectWards.clear();
            selectWards.clearOptions();
            selectWards.addOption(ward);
            selectWards.refreshOptions();
            $('#wards-container').fadeIn(100);
        } catch (error) {
            $('#wards-container').hide();
            $('#detail-address-container').hide();
            $('#detail-address').val('');
        }
    }

}
window.provincesSelect = provinces;

