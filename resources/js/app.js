import "./bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";
import jQuery from "jquery";
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import "flatpickr/dist/themes/airbnb.css";
import { Vietnam } from "flatpickr/dist/l10n/vn.js"
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
window.$ = jQuery;
$(document).ready(function () {
    flatpickr.localize(Vietnam)
    // Dùng để select với date picker
    flatpickr('.datepicker', {
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        locale: Vietnam,
    });
});
var notyf = new Notyf({
    duration: 10000,
    position: {
        x: 'right',
        y: 'top',
    },
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

