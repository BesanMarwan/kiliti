<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pages =
            [
                [
                    'title' => ['ar'=>'الشروط والأحكام','en'=>'Terms and Conditions'],
                    'text' => [
                        'ar' => '<p>يعد دخولك إلى الموقع او التطبيق&nbsp; أو استخدامه بمثابة إقرار منك بأنك قد قرأت هذه الأحكام والشروط ووافقت على الالتزام بها التزاما كاملا.</p><p>&nbsp;</p><p><span class="text-big"><strong>سياسة الاسترجاع</strong></span></p><p>حرصا على تقديم افضل الخدمات لعملائنا وارضاء عملائنا سيتم استرجاع المنتجات التالفة أو تعويضكم برصيد في المحفظة شامل الشحن، ولا يتم استرجاع المنتجات المستخدمة أو التي تم فتحها لسلامتكم.</p><p><strong>ماهي&nbsp; رسوم للاسترجاع ؟</strong></p><p>يتحمل المتجر رسوم تكلفة الشحن لعملية الاسترجاع ويتم معاينة المنتجات من قبل المتجر بعد الاسترجاع وتحديد المنتجات السليمة والتالفة والمستعملة وتقييم كل منتج في طلب الاسترجاع</p><p><strong>كيفية تحصيل المبلغ للطلب المسترجع ؟</strong></p><p>يتم تحويل جميع مبالغ المنتجات المسترجعة الي محفظتك في التطبيق</p><p><strong>المدة المسموحة لطلب الاسترجاع ؟</strong></p><p>يمكنك استرجاع الطلب خلال ١٤ يوم من تاريخ&nbsp; استلامك للطلب</p><p><strong>كم تستغرق عملية الاسترجاع&nbsp; للطلب ؟</strong></p><p>قد تستغرق مدة عملية الاسترجاع 10 أيام عمل.</p><p>&nbsp;</p><p><span class="text-big"><strong>سياسة الغاء الطلب</strong></span></p><p>یحق للعمیل إلغاء الطلب واسترداد كامل المبلغ&nbsp; (منقوصة رسوم التحويل البنكي ) في محفظته بالتطبيق&nbsp; خلال ٢٤ ساعة من ارسال الطلب&nbsp; وقبل اصدار بوليصة الشحن&nbsp; , وفي حال تم الغاء الطلب بعد ٢٤ ساعة من&nbsp; ارسال الطلب&nbsp; وقبل اصدار بوليصة الشحن يتم خصم ٢٠٪ من قيمة الطلب</p><p>في حال تم اصدار بوليصة الشحن لا يحق للعميل الغاء الطلب</p><p>&nbsp;</p><p><span class="text-big"><strong>&nbsp;استرداد المبلغ</strong></span></p><p>يحق للعميل ان يقوم باسترداد المبلغ من محفظته في التطبيق لحسابه البنكي من خلال التطبيق&nbsp; خلال ٥ ايام فقط</p><p>&nbsp;</p><p><span class="text-big"><strong>طرق الدفع:</strong></span></p><p>- الدفع عند الاستلام داخل السعودية.</p><p>- البطاقة الائتمانية (فيزا- مدى - ماستركارد).</p><p>- آبل باي.</p><p>&nbsp;</p><p><span class="text-big"><strong>رصيد المحفظة:</strong></span></p><p>- هو مبلغ مالي خاص بالعميل يمكنه الاستفادة منه كاملاً في عمليات الشراء القادمة.</p><p>- عند إتمام الطلب من قبل العميل يتم تخيير العميل ما بين خصم كامل المبلغ الموجود في المحفظة &nbsp; او ابقاء الرصيد في المحفظة واختيار طريقة دفع اخرى</p><p>- الرصيد الموجود في المحفظة غير مرتبط بفترة صلاحية ويمكنك استخدامه في أي وقت.</p><p>&nbsp;</p><p><span class="text-big"><strong>أحكام متفرقة:</strong></span></p><p>نحن نحتفظ بالحق في تعديل هذه الشروط والأحكام في أي وقت دون سابق إنذار لك، وتسري أي تعديلات على هذه الشروط والأحكام بمجرد نشرها على على التطبيق او الموقع الإلكتروني، ويعني استمرارك في استخدام&nbsp; التطبيق او الموقع الإلكتروني بعد إجراء تغيير من هذا القبيل موافقتك على الالتزام بالشروط والأحكام المعدلة. يُرجى قراءة الشروط والأحكام والاطلاع عليها مراراً وتكراراً، وفي حال لم تكن موافقاً على أي تغيير في الشروط والأحكام، يجب عليك التوقف فوراً عن استخدام التطبيق او الموقع الإلكتروني.</p>',
                        'en' => '<p>By accessing or using the website or application, you acknowledge that you have read these terms and conditions and agree to be fully bound by them.</p><p>&nbsp;</p><p><span class="text-big"><strong>Return policy </strong></span></p><p> In order to provide the best services to our customers and satisfy our customers, damaged products will be returned or compensated with a balance in the wallet, including shipping, and used or opened products will not be returned for your safety.</p><p> <strong>What are the refund fees? </strong></p><p> The store bears the shipping cost fees for the return process, and the products are inspected by the store after the return, and the intact, damaged, and used products are identified and each product is evaluated in the return request</p><p> <strong>How to collect the amount for the returned order?</strong></p><p> All refunded product amounts are transferred to your wallet in the application </p><p><strong>The period allowed for a refund request? </strong></p><p> You can return the application within 14 days from the date of receiving the application </p><p> <strong>How long does the return process take?</strong></p><p> The return process may take up to 10 working days.</p><p>&nbsp;</p><p><span class="text-big"><strong>Order cancellation policy </strong></span></p><p> The customer has the right to cancel the order and refund the full amount (minus the bank transfer fees) in his wallet in the application within 24 hours of sending the order and before issuing the bill of lading, 20% of the order value is deducted </p><p>In the event that a bill of lading has been issued, the customer has no right to cancel the order.</p><p>&nbsp;</p><p><span class="text-big"><strong>Refund amount </strong></span></p><p> The customer has the right to recover the amount from his wallet in the application to his bank account through the application within 5 days only.</p><p>&nbsp;</p><p><span class="text-big"><strong>Payment Methods: </strong></span></p><p> - Payment upon receipt inside Saudi Arabia.</p><p> - Credit Card (Visa - Mada - MasterCard).</p><p> - Apple Pay.</p><p>&nbsp;</p><p><span class="text-big"><strong>Wallet Balance: </strong></span></p><p> - It is a sum of money for the customer that he can fully benefit from in the upcoming purchases.</p><p>- Upon completion of the order by the customer, the customer is given the choice between deducting the entire amount in the wallet or keeping the balance in the wallet and choosing another payment method </p><p> - The balance in the wallet is not bound by a validity period and you can use it at any time.</p><p>&nbsp;</p><p><span class="text-big"><strong>Miscellaneous provisions:</strong></span></p><p> We reserve the right to amend these Terms and Conditions at any time without notice to you, and any amendments to these Terms and Conditions will be effective once they are posted on the application or website, and your continued use of the application or website after making such a change means your agreement to be bound by the terms and amended provisions. Please read and review the terms and conditions over and over again, and if you do not agree to any change in the terms and conditions, you must immediately stop using the application or website.</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>',
                    ],
                ],
                [
                    'title' => ['ar'=>'من نحن','en'=>'About App'],
                    'text' => [
                        'ar' => '',
                        'en' => ''
                    ],
                ],

            ];
        foreach ($pages as $page) {
            Page::query()->create($page);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
