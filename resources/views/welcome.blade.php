<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>كليتي — العرض التقديمي</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500;600;700&family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap">
    <style>

        body{margin:0;font-family:'IBM Plex Sans Arabic',system-ui,sans-serif;background:#10262E}
        a{color:#0E7C70}a:hover{color:#0A5C53}
        .ic{fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        .slide-in{animation:slideIn .9s cubic-bezier(.22,.8,.2,1) both}
        @keyframes slideIn{from{opacity:0;transform:scale(1.035);filter:blur(8px)}to{opacity:1;transform:none;filter:none}}
        .rise{animation:rise .85s cubic-bezier(.22,.8,.2,1) both}
        @keyframes rise{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:none}}
        .d1{animation-delay:.1s}.d2{animation-delay:.2s}.d3{animation-delay:.3s}.d4{animation-delay:.4s}.d5{animation-delay:.5s}.d6{animation-delay:.6s}.d7{animation-delay:.7s}.d8{animation-delay:.8s}.d9{animation-delay:.9s}
        .pop{animation:pop 1s cubic-bezier(.3,1.35,.4,1) both .25s}
        @keyframes pop{from{opacity:0;transform:scale(.72)}to{opacity:1;transform:none}}
        .spin{animation:spin 48s linear infinite;transform-origin:center;transform-box:fill-box}
        @keyframes spin{to{transform:rotate(360deg)}}
        .flow{stroke-dasharray:6 8;animation:flow 1.3s linear infinite}
        @keyframes flow{to{stroke-dashoffset:-28}}
        .pulse{animation:pulse 2.6s ease-in-out infinite;transform-origin:center;transform-box:fill-box}
        @keyframes pulse{0%,100%{opacity:.35;transform:scale(1)}50%{opacity:.9;transform:scale(1.18)}}
        .nav-btn{transition:background-color .25s}
        .nav-btn:hover{background:#1F4A55}
        .nav-btn:disabled{opacity:.35;cursor:default}
        .nav-btn:focus-visible,.dot:focus-visible{outline:2px solid #7FD3C6;outline-offset:2px}
        @media (prefers-reduced-motion: reduce){.slide-in,.rise,.pop,.spin,.flow,.pulse{animation-duration:.01ms!important;animation-iteration-count:1!important;animation-delay:0s!important}}


        html,body{margin:0;height:100%;background:#0A1A20;}
        .stage-wrapper{position:fixed;inset:0;display:flex;align-items:center;justify-content:center;overflow:hidden;
            padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px);}
        .stage{width:1280px;height:720px;position:relative;transform-origin:center center;flex:none;border-radius:16px;overflow:hidden;}
        .slide-panel{position:absolute;inset:0;display:none;}
        .slide-panel.active{display:block;}
        .dot-fill{display:block;height:8px;border-radius:4px;transition:width .45s cubic-bezier(.22,.8,.2,1),background-color .45s;}

    </style>
</head>
<body>
<div class="stage-wrapper">
    <div class="stage" id="stage" dir="rtl" style="font-family:'IBM Plex Sans Arabic',system-ui,sans-serif">


        <div style="position: absolute; inset: 0; background-color: #10262E; transition: background-color .9s ease"></div>
        <svg viewBox="0 0 1280 720" width="1280" height="720" aria-hidden="true" style="position: absolute; inset: 0; color: #7FD3C6; transition: color .9s ease">
            <path d="M80 90L240 210L150 420L60 640M240 210L420 330L330 560L150 420M420 330L520 120L700 60L880 170L1040 80L1210 190L1120 380L1230 560L980 640L760 690L560 640L330 560M520 120L240 210M880 170L1120 380M1120 380L980 640M420 330L560 640" fill="none" stroke="currentColor" stroke-width="1" opacity="0.13"></path>
            <g fill="currentColor" opacity="0.22">
                <circle cx="80" cy="90" r="4"></circle><circle cx="240" cy="210" r="5"></circle><circle cx="150" cy="420" r="4"></circle><circle cx="60" cy="640" r="3"></circle><circle cx="420" cy="330" r="4"></circle><circle cx="330" cy="560" r="5"></circle><circle cx="520" cy="120" r="3"></circle><circle cx="700" cy="60" r="4"></circle><circle cx="880" cy="170" r="5"></circle><circle cx="1040" cy="80" r="3"></circle><circle cx="1210" cy="190" r="4"></circle><circle cx="1120" cy="380" r="5"></circle><circle cx="1230" cy="560" r="3"></circle><circle cx="980" cy="640" r="4"></circle><circle cx="760" cy="690" r="3"></circle><circle cx="560" cy="640" r="4"></circle>
            </g>
        </svg>


        <div class="slide-panel" id="panel-1"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, 0.65fr); gap: 40px; align-items: center; color: #F5EFE6">
                <div style="display: flex; flex-direction: column; gap: 26px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 16px; font-weight: 500; color: #7FD3C6"><span style="width: 36px; height: 2px; background: #7FD3C6"></span><span>منصة رقمية للرعاية الصحية · Keliti</span></div>
                    <h1 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 62px; line-height: 1.2">منصة كليتي<br><span style="color: #7FD3C6">لإدارة رحلة مريض الكلى</span></h1>
                    <p class="rise d3" style="margin: 0; font-size: 22px; line-height: 1.7; color: #C9D6D3">من المعلومات المتفرقة… إلى رحلة علاجية مترابطة.</p>
                    <div class="rise d4" style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px; font-size: 16px; font-weight: 500">
                        <span style="padding: 8px 16px; border-radius: 999px; background: rgba(127, 211, 198, 0.12); border: 1px solid rgba(127, 211, 198, 0.35)">المريض</span>
                        <svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M7 8l-4 4 4 4M17 8l4 4-4 4M3 12h18"></path></svg>
                        <span style="padding: 8px 16px; border-radius: 999px; background: rgba(127, 211, 198, 0.12); border: 1px solid rgba(127, 211, 198, 0.35)">الطبيب</span>
                        <svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M7 8l-4 4 4 4M17 8l4 4-4 4M3 12h18"></path></svg>
                        <span style="padding: 8px 16px; border-radius: 999px; background: rgba(127, 211, 198, 0.12); border: 1px solid rgba(127, 211, 198, 0.35)">مركز غسيل الكلى</span>
                        <svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M7 8l-4 4 4 4M17 8l4 4-4 4M3 12h18"></path></svg>
                        <span style="padding: 8px 16px; border-radius: 999px; background: rgba(127, 211, 198, 0.12); border: 1px solid rgba(127, 211, 198, 0.35)">العائلة</span>
                    </div>
                </div>
                <div class="pop" style="display: flex; justify-content: center">
                    <svg viewBox="0 0 400 400" width="380" height="380" aria-hidden="true">
                        <circle class="spin" cx="200" cy="200" r="178" fill="none" stroke="#7FD3C6" stroke-width="1.5" stroke-dasharray="4 10" opacity="0.5"></circle>
                        <circle cx="200" cy="200" r="130" fill="none" stroke="#7FD3C6" stroke-width="1" opacity="0.18"></circle>
                        <g stroke="#7FD3C6" stroke-width="2" fill="none"><path class="flow" d="M200 138V86"></path><path class="flow" d="M262 200H314"></path><path class="flow" d="M200 262V314"></path><path class="flow" d="M138 200H86"></path></g>
                        <g fill="#173943" stroke="#7FD3C6" stroke-width="1.5"><circle cx="200" cy="52" r="34"></circle><circle cx="348" cy="200" r="34"></circle><circle cx="200" cy="348" r="34"></circle><circle cx="52" cy="200" r="34"></circle></g>
                        <g class="ic" style="color: #F5EFE6" stroke-width="1.8">
                            <g transform="translate(186 38) scale(1.15)"><circle cx="12" cy="8" r="4"></circle><path d="M4 21a8 8 0 0 1 16 0"></path></g>
                            <g transform="translate(334 186) scale(1.15)"><path d="M6 3v5a4 4 0 0 0 8 0V3"></path><path d="M10 12v3a5 5 0 0 0 10 0v-2"></path><circle cx="20" cy="11" r="2"></circle></g>
                            <g transform="translate(186 334) scale(1.15)"><path d="M4 21V7l8-4 8 4v14"></path><path d="M12 9v6M9 12h6M9 21v-3h6v3"></path></g>
                            <g transform="translate(38 186) scale(1.15)"><circle cx="9" cy="8" r="3"></circle><circle cx="17" cy="9" r="2.5"></circle><path d="M3 20v-1a5 5 0 0 1 10 0v1M14 20v-1a4 4 0 0 1 7-2.6"></path></g>
                        </g>
                        <circle class="pulse" cx="200" cy="200" r="74" fill="none" stroke="#7FD3C6" stroke-width="1.5"></circle>
                        <circle cx="200" cy="200" r="62" fill="#0E7C70"></circle>
                        <g transform="translate(164 164) scale(1.2)" fill="none" stroke="#F5EFE6" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path transform="translate(-4 2)" d="M24 6C12 6 5 17 5 30s7 24 19 24c8 0 11-6 8-12-2-4-2-8 1-12 3-4 3-9 0-13-2-4-5-5-9-5z"></path>
                            <path transform="translate(64 2) scale(-1 1)" d="M24 6C12 6 5 17 5 30s7 24 19 24c8 0 11-6 8-12-2-4-2-8 1-12 3-4 3-9 0-13-2-4-5-5-9-5z"></path>
                            <circle cx="30" cy="16" r="3.5"></circle><path d="M30 22v22M23 26l7 6 7-6"></path>
                        </g>
                        <g font-size="15" fill="#C9D6D3" text-anchor="middle" font-family="IBM Plex Sans Arabic, sans-serif"><text x="200" y="104">المريض</text><text x="348" y="252">الطبيب</text><text x="200" y="398">مركز الغسيل</text><text x="52" y="252">العائلة</text></g>
                    </svg>
                </div>
            </div></div><div class="slide-panel" id="panel-2"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 22px; color: #15282E">
                <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #B04A34"><span style="width: 32px; height: 2px; background: #B04A34"></span><span>التحدي</span></div>
                <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 42px; line-height: 1.3">مريض الكلى لا يحتاج تذكيرًا فقط…<br><span style="color: #0E7C70">بل يحتاج متابعة متكاملة</span></h2>
                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px">
                    <div class="rise d3" style="display: flex; gap: 18px; padding: 20px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px">
                        <div style="flex-shrink: 0; width: 52px; height: 52px; border-radius: 14px; background: #F5E0D8; color: #B04A34; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><rect x="3" y="9" width="18" height="6" rx="3" transform="rotate(-45 12 12)"></rect><path d="M8.5 8.5l7 7"></path></svg></div>
                        <div style="display: flex; flex-direction: column; gap: 4px"><div style="font-size: 20px; font-weight: 600">تشتّت خطة العلاج</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">الأدوية والمتابعة موزّعة بين المريض والطبيب والعائلة دون ربط مركزي.</div></div>
                    </div>
                    <div class="rise d4" style="display: flex; gap: 18px; padding: 20px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px">
                        <div style="flex-shrink: 0; width: 52px; height: 52px; border-radius: 14px; background: #F5E0D8; color: #B04A34; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"></rect><path d="M4 9h16M4 15h16M10 3v18"></path></svg></div>
                        <div style="display: flex; flex-direction: column; gap: 4px"><div style="font-size: 20px; font-weight: 600">بيانات غير منظّمة</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">السوائل والأعراض والقياسات تُسجَّل ورقيًا أو عبر مجموعات عشوائية.</div></div>
                    </div>
                    <div class="rise d5" style="display: flex; gap: 18px; padding: 20px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px">
                        <div style="flex-shrink: 0; width: 52px; height: 52px; border-radius: 14px; background: #F5E0D8; color: #B04A34; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"></path></svg></div>
                        <div style="display: flex; flex-direction: column; gap: 4px"><div style="font-size: 20px; font-weight: 600">الاعتماد على WhatsApp</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">التواصل اليدوي والملفات المتفرقة يزيدان من ضياع المعلومات الطبية الحرجة.</div></div>
                    </div>
                    <div class="rise d6" style="display: flex; gap: 18px; padding: 20px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px">
                        <div style="flex-shrink: 0; width: 52px; height: 52px; border-radius: 14px; background: #F5E0D8; color: #B04A34; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path d="M4 20V4M4 20h16"></path><path d="M8 15l4-4 3 3 5-6"></path></svg></div>
                        <div style="display: flex; flex-direction: column; gap: 4px"><div style="font-size: 20px; font-weight: 600">صعوبة تقييم الأثر</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">المؤسسات الداعمة تفتقر لطريقة واضحة لقياس أثر التمويل ومتابعة جودة الخدمات.</div></div>
                    </div>
                </div>
                <div class="rise d7" style="margin-top: auto; display: flex; align-items: center; gap: 18px; padding: 16px 28px; background: #10262E; color: #F5EFE6; border-radius: 18px">
                    <span style="font-family: 'El Messiri', serif; font-size: 54px; line-height: 0.6; color: #7FD3C6">”</span>
                    <span style="font-family: 'El Messiri', serif; font-size: 24px; font-weight: 600">المشكلة ليست نقص المعلومات فقط، بل تشتّتها.</span>
                </div>
            </div></div><div class="slide-panel" id="panel-3"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; align-items: center; gap: 22px; color: #F5EFE6; text-align: center">
                <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #7FD3C6"><span style="width: 32px; height: 2px; background: #7FD3C6"></span><span>الحل المقترح</span><span style="width: 32px; height: 2px; background: #7FD3C6"></span></div>
                <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 50px; line-height: 1.2">منصة <span style="color: #7FD3C6">كليتي</span> المتكاملة</h2>
                <p class="rise d3" style="margin: 0; font-size: 20px; color: #C9D6D3">منصة واحدة تجمع رحلة مريض الكلى وتربط الأطراف المعنية في مكان واحد.</p>
                <div style="margin-top: 14px; display: flex; align-items: center; gap: 8px">
                    <div class="rise d4" style="width: 140px; height: 150px; box-sizing: border-box; border-radius: 22px; background: #173943; border: 1px solid rgba(127, 211, 198, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px"><div style="width: 56px; height: 56px; border-radius: 50%; background: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path d="M6 3v5a4 4 0 0 0 8 0V3"></path><path d="M10 12v3a5 5 0 0 0 10 0v-2"></path><circle cx="20" cy="11" r="2"></circle></svg></div><div style="font-size: 18px; font-weight: 600">الطبيب</div></div>
                    <svg width="48" height="8" viewBox="0 0 48 8" aria-hidden="true"><path class="flow" d="M0 4H48" stroke="#7FD3C6" stroke-width="2"></path></svg>
                    <div class="rise d5" style="width: 140px; height: 150px; box-sizing: border-box; border-radius: 22px; background: #173943; border: 1px solid rgba(127, 211, 198, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px"><div style="width: 56px; height: 56px; border-radius: 50%; background: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><circle cx="9" cy="8" r="3"></circle><circle cx="17" cy="9" r="2.5"></circle><path d="M3 20v-1a5 5 0 0 1 10 0v1M14 20v-1a4 4 0 0 1 7-2.6"></path></svg></div><div style="font-size: 18px; font-weight: 600">العائلة</div></div>
                    <svg width="48" height="8" viewBox="0 0 48 8" aria-hidden="true"><path class="flow" d="M0 4H48" stroke="#7FD3C6" stroke-width="2"></path></svg>
                    <div class="pop" style="width: 230px; height: 210px; box-sizing: border-box; border-radius: 30px; background: #0E7C70; border: 2px solid #7FD3C6; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px">
                        <svg viewBox="0 0 64 64" width="72" height="72" aria-hidden="true" fill="none" stroke="#F5EFE6" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path transform="translate(-4 2)" d="M24 6C12 6 5 17 5 30s7 24 19 24c8 0 11-6 8-12-2-4-2-8 1-12 3-4 3-9 0-13-2-4-5-5-9-5z"></path><path transform="translate(64 2) scale(-1 1)" d="M24 6C12 6 5 17 5 30s7 24 19 24c8 0 11-6 8-12-2-4-2-8 1-12 3-4 3-9 0-13-2-4-5-5-9-5z"></path><circle cx="30" cy="16" r="3.5"></circle><path d="M30 22v22M23 26l7 6 7-6"></path></svg>
                        <div style="font-family: 'El Messiri', serif; font-size: 36px; font-weight: 700; line-height: 1.1">كليتي</div>
                        <div style="font-size: 15px; color: #D5F1EC">المنصة المركزية</div>
                    </div>
                    <svg width="48" height="8" viewBox="0 0 48 8" aria-hidden="true"><path class="flow" d="M48 4H0" stroke="#7FD3C6" stroke-width="2"></path></svg>
                    <div class="rise d5" style="width: 140px; height: 150px; box-sizing: border-box; border-radius: 22px; background: #173943; border: 1px solid rgba(127, 211, 198, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px"><div style="width: 56px; height: 56px; border-radius: 50%; background: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path d="M4 21V7l8-4 8 4v14"></path><path d="M12 9v6M9 12h6M9 21v-3h6v3"></path></svg></div><div style="font-size: 18px; font-weight: 600">مركز الغسيل</div></div>
                    <svg width="48" height="8" viewBox="0 0 48 8" aria-hidden="true"><path class="flow" d="M48 4H0" stroke="#7FD3C6" stroke-width="2"></path></svg>
                    <div class="rise d4" style="width: 140px; height: 150px; box-sizing: border-box; border-radius: 22px; background: #173943; border: 1px solid rgba(127, 211, 198, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px"><div style="width: 56px; height: 56px; border-radius: 50%; background: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21a8 8 0 0 1 16 0"></path></svg></div><div style="font-size: 18px; font-weight: 600">المريض</div></div>
                </div>
                <div class="rise d7" style="margin-top: auto; display: flex; gap: 14px; font-size: 17px; font-weight: 500">
                    <span style="display: flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 999px; background: rgba(127, 211, 198, 0.1); border: 1px solid rgba(127, 211, 198, 0.3)"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M5 12l5 5 9-10"></path></svg>بيانات منظّمة</span>
                    <span style="display: flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 999px; background: rgba(127, 211, 198, 0.1); border: 1px solid rgba(127, 211, 198, 0.3)"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M5 12l5 5 9-10"></path></svg>متابعة مستمرة</span>
                    <span style="display: flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 999px; background: rgba(127, 211, 198, 0.1); border: 1px solid rgba(127, 211, 198, 0.3)"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M5 12l5 5 9-10"></path></svg>تنبيهات ذكية</span>
                    <span style="display: flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 999px; background: rgba(127, 211, 198, 0.1); border: 1px solid rgba(127, 211, 198, 0.3)"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #7FD3C6"><path d="M5 12l5 5 9-10"></path></svg>صلاحيات آمنة</span>
                </div>
            </div></div><div class="slide-panel" id="panel-4"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 26px; color: #15282E">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>رحلة المريض</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 46px; line-height: 1.2">كيف يعمل <span style="color: #0E7C70">كليتي</span>؟</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px">
                    <div class="rise d3" style="display: flex; flex-direction: column; gap: 10px; padding: 22px 24px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="display: flex; align-items: center; gap: 12px"><span style="font-family: 'El Messiri', serif; font-size: 38px; font-weight: 700; color: #0E7C70; line-height: 1">01</span><span style="flex-grow: 1; height: 1px; background: #D8CBB6"></span></div><div style="font-size: 20px; font-weight: 600">إنشاء الملف الطبي</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">تسجيل بيانات المريض وتاريخ جلسات الغسيل.</div></div>
                    <div class="rise d4" style="display: flex; flex-direction: column; gap: 10px; padding: 22px 24px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="display: flex; align-items: center; gap: 12px"><span style="font-family: 'El Messiri', serif; font-size: 38px; font-weight: 700; color: #0E7C70; line-height: 1">02</span><span style="flex-grow: 1; height: 1px; background: #D8CBB6"></span></div><div style="font-size: 20px; font-weight: 600">الخطة العلاجية والأدوية</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">إدخال الجرعات ومواعيد الأدوية بدقة.</div></div>
                    <div class="rise d5" style="display: flex; flex-direction: column; gap: 10px; padding: 22px 24px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="display: flex; align-items: center; gap: 12px"><span style="font-family: 'El Messiri', serif; font-size: 38px; font-weight: 700; color: #0E7C70; line-height: 1">03</span><span style="flex-grow: 1; height: 1px; background: #D8CBB6"></span></div><div style="font-size: 20px; font-weight: 600">التسجيل اليومي</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">تسجيل السوائل والقياسات والجلسات والأعراض.</div></div>
                    <div class="rise d6" style="display: flex; flex-direction: column; gap: 10px; padding: 22px 24px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="display: flex; align-items: center; gap: 12px"><span style="font-family: 'El Messiri', serif; font-size: 38px; font-weight: 700; color: #0E7C70; line-height: 1">04</span><span style="flex-grow: 1; height: 1px; background: #D8CBB6"></span></div><div style="font-size: 20px; font-weight: 600">التنبيهات الذكية</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">استقبال تذكيرات الأدوية وتنبيهات تجاوز السوائل.</div></div>
                    <div class="rise d7" style="display: flex; flex-direction: column; gap: 10px; padding: 22px 24px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="display: flex; align-items: center; gap: 12px"><span style="font-family: 'El Messiri', serif; font-size: 38px; font-weight: 700; color: #0E7C70; line-height: 1">05</span><span style="flex-grow: 1; height: 1px; background: #D8CBB6"></span></div><div style="font-size: 20px; font-weight: 600">مشاركة الصلاحيات</div><div style="font-size: 16px; line-height: 1.6; color: #4E6166">تمكين العائلة والطبيب من الاطلاع الآمن والمباشر.</div></div>
                    <div class="rise d8" style="display: flex; flex-direction: column; gap: 10px; padding: 22px 24px; background: #10262E; color: #F5EFE6; border-radius: 18px"><div style="display: flex; align-items: center; gap: 12px"><span style="font-family: 'El Messiri', serif; font-size: 38px; font-weight: 700; color: #7FD3C6; line-height: 1">06</span><span style="flex-grow: 1; height: 1px; background: rgba(127, 211, 198, 0.4)"></span></div><div style="font-size: 20px; font-weight: 600">متابعة وتقارير المركز</div><div style="font-size: 16px; line-height: 1.6; color: #C9D6D3">حصول الأطباء والمراكز على تقارير دقيقة لدعم القرار.</div></div>
                </div>
            </div></div><div class="slide-panel" id="panel-5"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 24px; color: #15282E">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>السوق المستهدف</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 46px; line-height: 1.2">لمن صُمّم <span style="color: #0E7C70">كليتي</span>؟</h2>
                </div>
                <div style="display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 0.7fr); gap: 24px; flex-grow: 1">
                    <div style="display: flex; flex-direction: column; gap: 14px">
                        <div class="rise d3" style="display: flex; gap: 16px; align-items: center; padding: 18px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="flex-shrink: 0; width: 50px; height: 50px; border-radius: 14px; background: #10262E; color: #7FD3C6; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21a8 8 0 0 1 16 0"></path></svg></div><div style="display: flex; flex-direction: column; gap: 2px"><div style="font-size: 14px; font-weight: 600; color: #0E7C70">المستفيد الأساسي</div><div style="font-size: 19px; font-weight: 600">مرضى الكلى، وخاصة مرضى غسيل الكلى المستمرين.</div></div></div>
                        <div class="rise d4" style="display: flex; gap: 16px; align-items: center; padding: 18px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="flex-shrink: 0; width: 50px; height: 50px; border-radius: 14px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><circle cx="9" cy="8" r="3"></circle><circle cx="17" cy="9" r="2.5"></circle><path d="M3 20v-1a5 5 0 0 1 10 0v1M14 20v-1a4 4 0 0 1 7-2.6"></path></svg></div><div style="display: flex; flex-direction: column; gap: 8px"><div style="font-size: 14px; font-weight: 600; color: #0E7C70">الأطراف المستفيدة</div><div style="display: flex; flex-wrap: wrap; gap: 8px; font-size: 16px; font-weight: 500"><span style="padding: 5px 14px; border-radius: 999px; background: #EFE7DA">أفراد العائلة</span><span style="padding: 5px 14px; border-radius: 999px; background: #EFE7DA">مراكز غسيل الكلى</span><span style="padding: 5px 14px; border-radius: 999px; background: #EFE7DA">الأطباء</span></div></div></div>
                        <div class="rise d5" style="display: flex; gap: 16px; align-items: center; padding: 18px 22px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 18px"><div style="flex-shrink: 0; width: 50px; height: 50px; border-radius: 14px; background: #F6E6CC; color: #9A5F12; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M12 20s-7-4.5-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.5-7 10-7 10z"></path></svg></div><div style="display: flex; flex-direction: column; gap: 6px"><div style="font-size: 14px; font-weight: 600; color: #9A5F12">الجهات الدافعة / العملاء</div><div style="font-size: 17px; line-height: 1.6"><b style="font-weight: 600">غزة:</b> المنظمات غير الحكومية (NGOs) والمؤسسات الصحية المموّلة.<br><b style="font-weight: 600">التوسع:</b> مراكز غسيل الكلى.</div></div></div>
                    </div>
                    <div class="rise d6" style="display: flex; flex-direction: column; gap: 18px; padding: 24px 26px; background: #10262E; color: #F5EFE6; border-radius: 22px">
                        <div style="font-family: 'El Messiri', serif; font-size: 24px; font-weight: 700; color: #7FD3C6">مسار التوسع الاستراتيجي</div>
                        <div style="display: flex; flex-direction: column; gap: 0; position: relative">
                            <div style="display: flex; gap: 14px; align-items: flex-start; padding-bottom: 20px"><div style="flex-shrink: 0; width: 38px; height: 38px; border-radius: 50%; background: #0E7C70; border: 2px solid #7FD3C6; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M12 21s-7-6-7-11a7 7 0 0 1 14 0c0 5-7 11-7 11z"></path><circle cx="12" cy="10" r="2.5"></circle></svg></div><div><div style="font-size: 19px; font-weight: 600">غزة</div><div style="font-size: 14px; color: #C9D6D3">نقطة الانطلاق والاختبار</div></div></div>
                            <div style="display: flex; gap: 14px; align-items: flex-start; padding-bottom: 20px"><div style="flex-shrink: 0; width: 38px; height: 38px; border-radius: 50%; background: #173943; border: 2px solid rgba(127, 211, 198, 0.6); display: flex; align-items: center; justify-content: center; color: #7FD3C6; font-weight: 600">02</div><div><div style="font-size: 19px; font-weight: 600">فلسطين</div><div style="font-size: 14px; color: #C9D6D3">الضفة الغربية والداخل</div></div></div>
                            <div style="display: flex; gap: 14px; align-items: flex-start"><div style="flex-shrink: 0; width: 38px; height: 38px; border-radius: 50%; background: #173943; border: 2px solid rgba(127, 211, 198, 0.4); display: flex; align-items: center; justify-content: center; color: #7FD3C6; font-weight: 600">03</div><div><div style="font-size: 19px; font-weight: 600">المنطقة العربية</div><div style="font-size: 14px; color: #C9D6D3">والشرق الأوسط</div></div></div>
                        </div>
                    </div>
                </div>
            </div></div><div class="slide-panel" id="panel-6"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 24px; color: #15282E">
                <div style="display: flex; align-items: flex-end; justify-content: space-between; gap: 24px">
                    <div style="display: flex; flex-direction: column; gap: 12px">
                        <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>الإصدار الأول</span></div>
                        <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 46px; line-height: 1.2">أهم المميزات</h2>
                    </div>
                    <span class="rise d2" style="font-family: 'El Messiri', serif; font-size: 22px; font-weight: 700; padding: 6px 18px; border-radius: 999px; background: #10262E; color: #7FD3C6">V1</span>
                </div>
                <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px">
                    <div class="rise d2" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><rect x="3" y="9" width="18" height="6" rx="3" transform="rotate(-45 12 12)"></rect><path d="M8.5 8.5l7 7"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">إدارة الأدوية والتذكيرات</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">تسجيل الجرعات وتنبيهات مواعيد الدواء.</div></div></div>
                    <div class="rise d3" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M12 3s6 7 6 11a6 6 0 0 1-12 0c0-4 6-11 6-11z"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">متابعة السوائل</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">تنبيه فوري عند تجاوز الحد المسموح.</div></div></div>
                    <div class="rise d4" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><rect x="5" y="4" width="14" height="17" rx="2"></rect><path d="M9 4h6v3H9zM12 11v6M9 14h6"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">تسجيل الأعراض</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">وفق قواعد طبية معتمدة ورصد دقيق.</div></div></div>
                    <div class="rise d3" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M7 3v13a3 3 0 0 0 6 0V3M6 3h8M7 10h6M15 3h4M16 3v9"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">التحاليل والقياسات</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">حفظ المؤشرات الطبية ومتابعة تطوّرها.</div></div></div>
                    <div class="rise d4" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M3 10h18M8 3v4M16 3v4"></path><path d="M9 15l2 2 4-4"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">متابعة جلسات الغسيل</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">جدولة الجلسات وتأكيد الحضور بانتظام.</div></div></div>
                    <div class="rise d5" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><rect x="3" y="4" width="18" height="13" rx="2"></rect><path d="M8 21h8M12 17v4M7 12l3-3 2 2 4-4"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">لوحة الطبيب والمركز</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">متابعة حالة المرضى عبر لوحة تحكم مخصّصة.</div></div></div>
                    <div class="rise d4" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><circle cx="9" cy="8" r="3"></circle><circle cx="17" cy="9" r="2.5"></circle><path d="M3 20v-1a5 5 0 0 1 10 0v1M14 20v-1a4 4 0 0 1 7-2.6"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">مشاركة العائلة</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">صلاحيات يحدّدها المريض لمتابعة أسرية آمنة.</div></div></div>
                    <div class="rise d5" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M6 16V11a6 6 0 0 1 12 0v5l2 2H4z"></path><path d="M10 21h4"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">الإشعارات الفورية</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">تنبيهات سريعة عبر نظام FCM الموثوق.</div></div></div>
                    <div class="rise d6" style="display: flex; gap: 14px; align-items: center; padding: 18px 20px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 16px"><div style="flex-shrink: 0; width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"></rect><circle cx="9" cy="11" r="2"></circle><path d="M6 16c.5-1.5 1.7-2 3-2s2.5.5 3 2M14 10h4M14 14h4"></path></svg></div><div><div style="font-size: 18px; font-weight: 600">بطاقة طبية</div><div style="font-size: 14.5px; line-height: 1.55; color: #4E6166">بطاقة طوارئ طبية رقمية وقابلة للطباعة.</div></div></div>
                </div>
            </div></div><div class="slide-panel" id="panel-7"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 24px; color: #F5EFE6">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #7FD3C6"><span style="width: 32px; height: 2px; background: #7FD3C6"></span><span>الفرق</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 46px; line-height: 1.2"><span style="color: #7FD3C6">كليتي</span> ليس مجرد تطبيق تذكير</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 22px">
                    <div class="rise d3" style="display: flex; flex-direction: column; gap: 14px; padding: 24px 28px; border-radius: 22px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(245, 239, 230, 0.14)">
                        <span style="align-self: flex-start; font-size: 14px; font-weight: 600; padding: 4px 14px; border-radius: 999px; background: rgba(240, 160, 140, 0.14); color: #F0A08C">تطبيق تقليدي</span>
                        <div style="font-family: 'El Messiri', serif; font-size: 30px; font-weight: 700; color: #DDE3E1">تذكير بالأدوية فقط</div>
                        <div style="display: flex; align-items: center; gap: 14px; padding: 14px 0">
                            <div style="width: 54px; height: 54px; border-radius: 50%; background: rgba(245, 239, 230, 0.08); border: 1px dashed rgba(245, 239, 230, 0.35); display: flex; align-items: center; justify-content: center; color: #B7C4C1"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M6 16V11a6 6 0 0 1 12 0v5l2 2H4z"></path><path d="M10 21h4"></path></svg></div>
                            <svg width="140" height="10" viewBox="0 0 140 10" aria-hidden="true"><path d="M0 5H50M90 5H140" stroke="rgba(245,239,230,0.3)" stroke-width="2" stroke-dasharray="3 6"></path><path d="M64 0l12 10M76 0L64 10" stroke="#F0A08C" stroke-width="2"></path></svg>
                            <div style="width: 54px; height: 54px; border-radius: 50%; border: 1px dashed rgba(245, 239, 230, 0.25)"></div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 18px; color: #F0A08C"><svg class="ic" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"></path></svg>ميزة محدودة ومنعزلة</div>
                    </div>
                    <div class="rise d4" style="display: flex; flex-direction: column; gap: 14px; padding: 24px 28px; border-radius: 22px; background: #0E7C70; border: 1px solid #7FD3C6">
                        <span style="align-self: flex-start; font-size: 14px; font-weight: 600; padding: 4px 14px; border-radius: 999px; background: #10262E; color: #7FD3C6">كليتي</span>
                        <div style="font-family: 'El Messiri', serif; font-size: 30px; font-weight: 700">رحلة علاجية متكاملة</div>
                        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px; padding: 14px 0; font-size: 16px; font-weight: 600">
                            <span style="padding: 8px 14px; border-radius: 12px; background: rgba(16, 38, 46, 0.35)">المريض</span><span aria-hidden="true">⇄</span>
                            <span style="padding: 8px 14px; border-radius: 12px; background: rgba(16, 38, 46, 0.35)">الطبيب</span><span aria-hidden="true">⇄</span>
                            <span style="padding: 8px 14px; border-radius: 12px; background: rgba(16, 38, 46, 0.35)">مركز الغسيل</span><span aria-hidden="true">⇄</span>
                            <span style="padding: 8px 14px; border-radius: 12px; background: rgba(16, 38, 46, 0.35)">العائلة</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 18px; color: #E4F6F2"><svg class="ic" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M5 12l5 5 9-10"></path></svg>كل الأطراف في منظومة واحدة</div>
                    </div>
                </div>
                <div class="rise d6" style="margin-top: auto; display: flex; align-items: center; gap: 20px; padding: 18px 26px; border-radius: 18px; background: #FFFDF9; color: #15282E">
                    <div style="flex-shrink: 0; width: 52px; height: 52px; border-radius: 14px; background: #10262E; color: #7FD3C6; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="26" height="26" aria-hidden="true"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"></path><path d="M9 12l2 2 4-4"></path></svg></div>
                    <div style="display: flex; flex-direction: column; gap: 2px"><div dir="ltr" style="text-align: right; font-size: 14px; font-weight: 600; color: #0E7C70; letter-spacing: 0.04em">Patient Journey Platform</div><div style="font-size: 21px; font-weight: 600">المريض يتحكّم تمامًا بصلاحيات وصول العائلة والجهات العلاجية لبياناته.</div></div>
                </div>
            </div></div><div class="slide-panel" id="panel-8"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 24px; color: #15282E">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>المنافسة</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 44px; line-height: 1.2">تطبيقات تتبّع كثيرة… <span style="color: #0E7C70">ومنظومة واحدة فقط</span></h2>
                </div>
                <div class="rise d3" style="display: flex; flex-direction: column; border-radius: 20px; overflow: hidden; border: 1px solid #E6DCCB; background: #FFFDF9">
                    <div style="display: grid; grid-template-columns: 200px minmax(0, 1fr) minmax(0, 1fr); font-size: 17px; font-weight: 600">
                        <div style="padding: 16px 22px; color: #4E6166">المعيار</div>
                        <div style="padding: 16px 22px; display: flex; flex-direction: column; gap: 2px"><span>الموجود حاليًا</span><span dir="ltr" style="text-align: right; font-size: 13px; font-weight: 500; color: #4E6166">NephroLog · NephroGo · H2Overload</span></div>
                        <div style="padding: 16px 22px; background: #10262E; color: #7FD3C6; display: flex; align-items: center; font-family: 'El Messiri', serif; font-size: 24px">كليتي</div>
                    </div>
                    <div class="rise d4" style="display: grid; grid-template-columns: 200px minmax(0, 1fr) minmax(0, 1fr); border-top: 1px solid #E6DCCB; font-size: 16.5px">
                        <div style="padding: 16px 22px; font-weight: 600">من داخل النظام؟</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; color: #4E6166"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B04A34; flex-shrink: 0"><path d="M6 6l12 12M18 6L6 18"></path></svg>المريض وحده — لا طبيب، لا أسرة، لا مركز غسيل</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; background: #E5F2EE; font-weight: 500"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>يربط المريض + الطبيب + الأسرة + المركز</div>
                    </div>
                    <div class="rise d5" style="display: grid; grid-template-columns: 200px minmax(0, 1fr) minmax(0, 1fr); border-top: 1px solid #E6DCCB; font-size: 16.5px">
                        <div style="padding: 16px 22px; font-weight: 600">التعامل مع البيانات</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; color: #4E6166"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B04A34; flex-shrink: 0"><path d="M6 6l12 12M18 6L6 18"></path></svg>تتبّع من جانب المريض فقط</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; background: #E5F2EE; font-weight: 500"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>مساعد ذكي يترجم البيانات وينبّه، ولا يشخّص</div>
                    </div>
                    <div class="rise d6" style="display: grid; grid-template-columns: 200px minmax(0, 1fr) minmax(0, 1fr); border-top: 1px solid #E6DCCB; font-size: 16.5px">
                        <div style="padding: 16px 22px; font-weight: 600">المشاركة والخصوصية</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; color: #4E6166"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B04A34; flex-shrink: 0"><path d="M6 6l12 12M18 6L6 18"></path></svg>—</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; background: #E5F2EE; font-weight: 500"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>صلاحيات مشاركة يحدّدها المريض نفسه</div>
                    </div>
                    <div class="rise d7" style="display: grid; grid-template-columns: 200px minmax(0, 1fr) minmax(0, 1fr); border-top: 1px solid #E6DCCB; font-size: 16.5px">
                        <div style="padding: 16px 22px; font-weight: 600">اللغة والسياق</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; color: #4E6166"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B04A34; flex-shrink: 0"><path d="M6 6l12 12M18 6L6 18"></path></svg>بالإنجليزية، ومصمّمة لسياق غير عربي</div>
                        <div style="padding: 16px 22px; display: flex; gap: 10px; align-items: center; background: #E5F2EE; font-weight: 500"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>بالعربية، ومبني لسياق الرعاية العائلية العربية</div>
                    </div>
                </div>
            </div></div><div class="slide-panel" id="panel-9"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 24px; color: #15282E">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>نموذج العمل</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 46px; line-height: 1.2">كيف يحقّق <span style="color: #0E7C70">كليتي</span> الإيرادات؟</h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 22px">
                    <div class="rise d3" style="display: flex; flex-direction: column; gap: 14px; padding: 24px 28px; background: #FFFDF9; border: 1px solid #E6DCCB; border-top: 5px solid #B7791F; border-radius: 20px">
                        <div style="display: flex; align-items: center; gap: 14px"><div style="width: 48px; height: 48px; border-radius: 13px; background: #F6E6CC; color: #9A5F12; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M12 20s-7-4.5-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.5-7 10-7 10z"></path></svg></div><div><div style="font-size: 13px; font-weight: 600; color: #9A5F12">الانطلاق · غزة</div><div style="font-size: 21px; font-weight: 700">المنظمات غير الحكومية والمؤسسات الصحية</div></div></div>
                        <div style="font-size: 16px; color: #4E6166">تمويل استخدام المنصة ضمن المشاريع الصحية لضمان:</div>
                        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 17px">
                            <div style="display: flex; gap: 10px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B7791F; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>تقليل المتابعة اليدوية وتوفير وقت الموظفين.</div>
                            <div style="display: flex; gap: 10px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B7791F; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>تنظيم بيانات المرضى وتسهيل التقارير.</div>
                            <div style="display: flex; gap: 10px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #B7791F; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>متابعة الخدمات وقياس أثر التمويل.</div>
                        </div>
                    </div>
                    <div class="rise d4" style="display: flex; flex-direction: column; gap: 14px; padding: 24px 28px; background: #FFFDF9; border: 1px solid #E6DCCB; border-top: 5px solid #0E7C70; border-radius: 20px">
                        <div style="display: flex; align-items: center; gap: 14px"><div style="width: 48px; height: 48px; border-radius: 13px; background: #DCEEE9; color: #0E7C70; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><path d="M4 21V7l8-4 8 4v14"></path><path d="M12 9v6M9 12h6M9 21v-3h6v3"></path></svg></div><div><div style="font-size: 13px; font-weight: 600; color: #0E7C70">التوسع</div><div style="font-size: 21px; font-weight: 700">مراكز غسيل الكلى</div></div></div>
                        <div style="font-size: 16px; color: #4E6166">نموذج اشتراك شهري متكرر (Recurring Revenue):</div>
                        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 17px">
                            <div style="display: flex; gap: 10px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>اشتراك SaaS بناءً على عدد المرضى.</div>
                            <div style="display: flex; gap: 10px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>اشتراك سنوي أو شهري حسب حجم المركز.</div>
                            <div style="display: flex; gap: 10px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>نمو الإيرادات مع زيادة عدد المراكز والمرضى.</div>
                        </div>
                    </div>
                </div>
                <div class="rise d6" style="margin-top: auto; display: flex; align-items: center; justify-content: center; gap: 16px; padding: 16px 28px; background: #10262E; color: #F5EFE6; border-radius: 18px">
                    <span style="font-family: 'El Messiri', serif; font-size: 50px; line-height: 0.6; color: #7FD3C6">”</span>
                    <span style="font-family: 'El Messiri', serif; font-size: 24px; font-weight: 600">الجهة التي تستفيد من القيمة هي الجهة الدافعة.</span>
                </div>
            </div></div><div class="slide-panel" id="panel-10"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 24px; color: #15282E">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>العائد على الاستثمار</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 46px; line-height: 1.2">لا نقول فقط «نوفّر المال»… <span style="color: #0E7C70">بل نقيسه</span></h2>
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 22px">
                    <div class="rise d3" style="display: flex; flex-direction: column; gap: 12px; padding: 22px 26px; background: #FBEDE7; border: 1px solid #EDCFC3; border-radius: 20px">
                        <div style="font-size: 15px; font-weight: 600; color: #B04A34">بدون كليتي</div>
                        <div style="font-family: 'El Messiri', serif; font-size: 28px; font-weight: 700">تكلفة متابعة عالية</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; font-size: 15.5px"><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #EDCFC3">موظفون</span><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #EDCFC3">اتصالات</span><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #EDCFC3">إدخال بيانات ورقية</span><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #EDCFC3">تقارير يدوية بطيئة</span></div>
                    </div>
                    <div class="rise d4" style="display: flex; flex-direction: column; gap: 12px; padding: 22px 26px; background: #E5F2EE; border: 1px solid #BFDFD7; border-radius: 20px">
                        <div style="font-size: 15px; font-weight: 600; color: #0E7C70">مع كليتي</div>
                        <div style="font-family: 'El Messiri', serif; font-size: 28px; font-weight: 700">نظام رقمي مركزي</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; font-size: 15.5px"><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #BFDFD7">أتمتة كاملة</span><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #BFDFD7">تنظيم فوري</span><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #BFDFD7">تقارير جاهزة للاعتماد</span><span style="padding: 6px 14px; border-radius: 999px; background: #FFFDF9; border: 1px solid #BFDFD7">كفاءة تشغيلية</span></div>
                    </div>
                </div>
                <div class="rise d6" style="display: flex; flex-direction: column; align-items: center; gap: 12px; padding: 22px 28px; background: #10262E; color: #F5EFE6; border-radius: 20px">
                    <div style="font-size: 14px; font-weight: 600; color: #7FD3C6">معادلة العائد</div>
                    <div style="display: flex; align-items: center; gap: 18px; font-family: 'El Messiri', serif; font-size: 28px; font-weight: 700">
                        <span style="padding: 8px 20px; border-radius: 14px; background: #0E7C70">العائد (ROI)</span>
                        <span style="color: #7FD3C6">=</span>
                        <span style="padding: 8px 20px; border-radius: 14px; border: 1px solid rgba(127, 211, 198, 0.5)">الوفر التشغيلي</span>
                        <span style="color: #7FD3C6">−</span>
                        <span style="padding: 8px 20px; border-radius: 14px; border: 1px solid rgba(127, 211, 198, 0.5)">تكلفة كليتي</span>
                    </div>
                    <div style="font-size: 14.5px; color: #C9D6D3">ملاحظة: الأرقام النهائية ستُحدَّد بناءً على بيانات فعلية من المنظمات غير الحكومية والمراكز، وليست افتراضات.</div>
                </div>
            </div></div><div class="slide-panel" id="panel-11"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; gap: 22px; color: #15282E">
                <div style="display: flex; flex-direction: column; gap: 12px">
                    <div class="rise d1" style="display: flex; align-items: center; gap: 12px; font-size: 15px; font-weight: 600; color: #0E7C70"><span style="width: 32px; height: 2px; background: #0E7C70"></span><span>أين نحن الآن</span></div>
                    <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 44px; line-height: 1.2">من فكرة إلى منتج <span style="color: #0E7C70">قيد التطوير والاختبار</span></h2>
                </div>
                <div class="rise d3" style="display: flex; align-items: center; gap: 12px; font-size: 16px; font-weight: 600">
                    <span style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: #DCEEE9; color: #0A5C53"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12l5 5 9-10"></path></svg>الفكرة</span>
                    <span style="flex-grow: 1; height: 2px; background: #0E7C70"></span>
                    <span style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: #DCEEE9; color: #0A5C53"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M5 12l5 5 9-10"></path></svg>بناء الإصدار V1</span>
                    <span style="flex-grow: 1; height: 2px; background: #0E7C70"></span>
                    <span style="display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: #10262E; color: #7FD3C6"><svg class="pulse" viewBox="0 0 10 10" width="10" height="10" aria-hidden="true"><circle cx="5" cy="5" r="5" fill="#7FD3C6"></circle></svg>التحقق الميداني — الآن</span>
                </div>
                <div style="display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr); gap: 22px">
                    <div class="rise d4" style="display: flex; flex-direction: column; gap: 14px; padding: 22px 26px; background: #FFFDF9; border: 1px solid #E6DCCB; border-radius: 20px">
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 19px; font-weight: 700"><svg class="ic" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" style="color: #0E7C70"><path d="M9 8l-5 4 5 4M15 8l5 4-5 4"></path></svg>ما تم إنجازه تقنيًا (V1 Built)</div>
                        <div dir="ltr" style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px 18px; font-size: 15.5px; font-weight: 500">
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Laravel REST API</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Auth &amp; Roles (RBAC)</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Patient Medical Profile</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Medication Management</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Fluid Tracking &amp; Alerts</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Dialysis Tracking</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Symptoms &amp; Alerts</div>
                            <div style="display: flex; gap: 8px; align-items: center"><svg class="ic" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" style="color: #0E7C70; flex-shrink: 0"><path d="M5 12l5 5 9-10"></path></svg>Family Access &amp; FCM</div>
                        </div>
                    </div>
                    <div class="rise d5" style="display: flex; flex-direction: column; gap: 12px; padding: 22px 26px; background: #10262E; color: #F5EFE6; border-radius: 20px">
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 19px; font-weight: 700"><svg class="ic" viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" style="color: #7FD3C6"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="5"></circle><circle cx="12" cy="12" r="1.5"></circle></svg>الخطوة الحالية: <span dir="ltr">Field Validation</span></div>
                        <div style="font-size: 15px; line-height: 1.6; color: #C9D6D3">التواصل المباشر مع المرضى والأطباء ومراكز غسيل الكلى والمنظمات غير الحكومية بهدف:</div>
                        <div style="display: flex; flex-direction: column; gap: 8px; font-size: 16.5px">
                            <div style="display: flex; gap: 10px; align-items: center"><span style="width: 8px; height: 8px; border-radius: 50%; background: #7FD3C6; flex-shrink: 0"></span>التحقق الفعلي من الاحتياج.</div>
                            <div style="display: flex; gap: 10px; align-items: center"><span style="width: 8px; height: 8px; border-radius: 50%; background: #7FD3C6; flex-shrink: 0"></span>تحسين واجهات وتجربة المنتج.</div>
                            <div style="display: flex; gap: 10px; align-items: center"><span style="width: 8px; height: 8px; border-radius: 50%; background: #7FD3C6; flex-shrink: 0"></span>اختبار نموذج الدفع والاشتراك.</div>
                        </div>
                    </div>
                </div>
            </div></div><div class="slide-panel" id="panel-12"><div class="slide-in" style="position: absolute; inset: 0; box-sizing: border-box; padding: 56px 88px 104px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 26px; color: #F5EFE6; text-align: center">
                <div class="pop" style="width: 104px; height: 104px; border-radius: 50%; background: #0E7C70; border: 2px solid #7FD3C6; display: flex; align-items: center; justify-content: center">
                    <svg viewBox="0 0 64 64" width="64" height="64" aria-hidden="true" fill="none" stroke="#F5EFE6" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path transform="translate(-4 2)" d="M24 6C12 6 5 17 5 30s7 24 19 24c8 0 11-6 8-12-2-4-2-8 1-12 3-4 3-9 0-13-2-4-5-5-9-5z"></path><path transform="translate(64 2) scale(-1 1)" d="M24 6C12 6 5 17 5 30s7 24 19 24c8 0 11-6 8-12-2-4-2-8 1-12 3-4 3-9 0-13-2-4-5-5-9-5z"></path><circle cx="30" cy="16" r="3.5"></circle><path d="M30 22v22M23 26l7 6 7-6"></path></svg>
                </div>
                <h2 class="rise d2" style="margin: 0; font-family: 'El Messiri', serif; font-weight: 700; font-size: 52px; line-height: 1.3">رحلة مريض الكلى لا يجب أن تكون<br><span style="color: #7FD3C6">مجموعة معلومات متفرقة.</span></h2>
                <div class="rise d3" style="display: flex; align-items: center; gap: 12px; font-size: 18px; font-weight: 500; color: #C9D6D3">
                    <span>المريض</span><span aria-hidden="true" style="color: #7FD3C6">↔</span><span>الطبيب</span><span aria-hidden="true" style="color: #7FD3C6">↔</span><span>مركز الغسيل</span><span aria-hidden="true" style="color: #7FD3C6">↔</span><span>العائلة</span>
                </div>
                <div class="rise d4" style="padding: 14px 30px; border-radius: 16px; background: #173943; border: 1px solid rgba(127, 211, 198, 0.35); font-family: 'El Messiri', serif; font-size: 22px; font-weight: 600">من المعلومات المتفرقة… إلى رحلة علاجية مترابطة.</div>
                <div class="rise d5" style="display: flex; align-items: center; gap: 14px; font-family: 'El Messiri', serif; font-size: 30px; font-weight: 700; color: #7FD3C6"><span>كليتي</span><span style="width: 1px; height: 28px; background: rgba(127, 211, 198, 0.5)"></span><span dir="ltr">Keliti</span></div>
            </div></div>


        <div id="progressBar" style="position: absolute; right: 0; bottom: 0; height: 4px; width: 0%; background: #0E7C70; transition: width .7s cubic-bezier(.22,.8,.2,1)"></div>
        <div style="position: absolute; right: 88px; bottom: 34px; font-family: 'El Messiri', serif; font-size: 18px; font-weight: 700; color: #F5EFE6; transition: color .9s">كليتي</div>
        <div dir="ltr" style="position: absolute; left: 88px; bottom: 34px; font-size: 15px; font-weight: 600; letter-spacing: 0.08em; color: #F5EFE6; transition: color .9s; font-variant-numeric: tabular-nums"><span id="counterNum">1 / 12</span></div>
        <div style="position: absolute; left: 50%; bottom: 22px; transform: translateX(-50%); display: flex; align-items: center; gap: 6px; padding: 5px; border-radius: 999px; background: rgba(16, 38, 46, 0.92); color: #F5EFE6">
            <button class="nav-btn" type="button" aria-label="الشريحة السابقة" id="btnPrev" style="width: 40px; height: 40px; border: 0; border-radius: 50%; background: transparent; color: #F5EFE6; cursor: pointer; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M9 6l6 6-6 6"></path></svg></button>
            <div id="dotsHost" style="display: flex; align-items: center">

            </div>
            <button class="nav-btn" type="button" aria-label="الشريحة التالية" id="btnNext" style="width: 40px; height: 40px; border: 0; border-radius: 50%; background: #0E7C70; color: #F5EFE6; cursor: pointer; display: flex; align-items: center; justify-content: center"><svg class="ic" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M15 6l-6 6 6 6"></path></svg></button>
        </div>


    </div>
</div>

<script>
    const stage = document.getElementById('stage');
    const panels = Array.from({length:12}, (_,i)=>document.getElementById('panel-'+(i+1)));
    const progressBar = document.getElementById('progressBar');
    const counterNum = document.getElementById('counterNum');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    let dotsHost = document.getElementById('dotsHost');
    if(!dotsHost){
        dotsHost = document.createElement('div');
        dotsHost.style.display='flex'; dotsHost.style.alignItems='center';
        btnPrev.after(dotsHost);
    }
    const dotButtons = [];
    for(let n=1;n<=12;n++){
        const b = document.createElement('button');
        b.type='button'; b.className='dot'; b.setAttribute('aria-label','الانتقال إلى الشريحة '+n);
        b.style.cssText='height:28px;min-width:18px;padding:0 5px;border:0;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center';
        const fill = document.createElement('span');
        fill.className='dot-fill';
        b.appendChild(fill);
        b.addEventListener('click', ()=>show(n-1));
        dotsHost.appendChild(b);
        dotButtons.push(fill);
    }

    let i = 0;
    function paintDots(){
        dotButtons.forEach((f,idx)=>{
            if(idx===i){ f.style.width='26px'; f.style.background='#0E7C70'; }
            else{ f.style.width='8px'; f.style.background='rgba(245,239,230,0.35)'; }
        });
    }
    function show(n){
        n = Math.max(0, Math.min(11, n));
        panels[i].classList.remove('active');
        i = n;
        panels[i].classList.add('active');
        progressBar.style.width = ((i+1)/12*100)+'%';
        counterNum.textContent = (i+1)+' / 12';
        btnPrev.disabled = i===0;
        btnNext.disabled = i===11;
        paintDots();
    }
    btnPrev.addEventListener('click', ()=>show(i-1));
    btnNext.addEventListener('click', ()=>show(i+1));
    document.addEventListener('keydown', e=>{
        if(e.key==='ArrowLeft') show(i+1);
        if(e.key==='ArrowRight') show(i-1);
    });
    let touchX=null;
    stage.addEventListener('touchstart', e=>{ touchX=e.touches[0].clientX; });
    stage.addEventListener('touchend', e=>{
        if(touchX===null) return;
        const dx = e.changedTouches[0].clientX - touchX;
        if(Math.abs(dx)>50){ dx>0 ? show(i-1) : show(i+1); }
        touchX=null;
    });

    function fitStage(){
        const scale = Math.min(window.innerWidth/1280, window.innerHeight/720);
        stage.style.transform = 'scale('+scale+')';
    }
    window.addEventListener('resize', fitStage);
    fitStage();
    show(0);
</script>
</body>
</html>

