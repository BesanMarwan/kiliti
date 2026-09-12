@props(['name'=>''])

<?php
$rand = rand(100, 9999);
$separator='->';
$format="DD-MM-YYYY";
$old=set_if($_GET[$name]);
$start=explode($separator,$old)[0]??'';
$end=explode($separator,$old)[1]??'';
?>

<div class="mb-0">
    <input type="hidden" name="separator" value="{{$separator}}">
    <input class="form-control form-control-solid" placeholder="بحث حسب مدة" name="{{$name}}" value="{{$old}}" id="dateRange{{$rand}}" {{$attributes}}/>
</div>
@push('js')
    <script>


        function cb(start, end) {
            $("#dateRange{{$rand}}").val(start.format("{{$format}}") + "{!! $separator !!}" + end.format("{{$format}}"));
        }

        $("#dateRange{{$rand}}").daterangepicker({
            opens: "left",
            @if($start &&$end)
                startDate: moment('{{$start}}',"{{$format}}"),
                endDate: moment('{{$end}}',"{{$format}}"),
            @endif
            ranges: {
                "اليوم": [moment(), moment()],
                "الامس": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "اخر اسبوع": [moment().subtract(6, "days"), moment()],
                "اخر شهر": [moment().subtract(29, "days"), moment()],
                "هذا الشهر": [moment().startOf("month"), moment().endOf("month")],
                "الشهر السابق": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            },
            "locale": {
                direction: 'rtl',
                "format": "{{$format}}",
                "separator": "{!! $separator !!}",
                "applyLabel": "تأكيد",
                "cancelLabel": "تفريغ",
                "fromLabel": "من تاريخ",
                "toLabel": "الى تاريخ",
                "customRangeLabel": "تخصيص",
                "weekLabel": "اسبوع",
                "daysOfWeek": [
                    "أحد",
                    "اثنين",
                    "ثلاثاء",
                    "اربعاء",
                    "خميس",
                    "جمعة",
                    "سبت"
                ],
                "monthNames": [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "ابريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "اغسطس",
                    "سبتمبر",
                    "اكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
                "firstDay": 0
            },
        }, cb);
        $('#dateRange{{$rand}}').on('cancel.daterangepicker', function(ev, picker) {
            //do something, like clearing an input
            $('#dateRange{{$rand}}').val('');
        });
        @if(!$start &&!$end)
            $('#dateRange{{$rand}}').trigger('cancel.daterangepicker')
        @endif

    </script>
@endpush
