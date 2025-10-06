<?php

namespace Database\Seeders;

use App\Models\UserGuide;
use App\Models\Recruiter;
use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create FAQ guides for recruiters
        UserGuide::create([
            'heading' => [
                'en' => 'How to Post a Job',
                'ar' => 'كيفية نشر وظيفة'
            ],
            'content' => [
                'en' => 'To post a job, go to the Jobs section and click "Create New Job". Fill in all required fields including job title, description, requirements, and location. Make sure to set the appropriate salary range and job type.',
                'ar' => 'لنشر وظيفة، اذهب إلى قسم الوظائف واضغط على "إنشاء وظيفة جديدة". املأ جميع الحقول المطلوبة بما في ذلك عنوان الوظيفة والوصف والمتطلبات والموقع. تأكد من تحديد نطاق الراتب المناسب ونوع الوظيفة.'
            ],
            'content_type' => 'faq',
            'target_audience' => 'recruiters',
            'is_active' => true,
        ]);

        UserGuide::create([
            'heading' => [
                'en' => 'How to Review Applications',
                'ar' => 'كيفية مراجعة الطلبات'
            ],
            'content' => [
                'en' => 'Navigate to the Applications section to view all submitted applications. You can filter by status, date, or candidate qualifications. Click on any application to view detailed candidate information and resume.',
                'ar' => 'انتقل إلى قسم الطلبات لعرض جميع الطلبات المقدمة. يمكنك التصفية حسب الحالة أو التاريخ أو مؤهلات المرشح. اضغط على أي طلب لعرض معلومات المرشح التفصيلية والسيرة الذاتية.'
            ],
            'content_type' => 'faq',
            'target_audience' => 'recruiters',
            'is_active' => true,
        ]);

        // Create FAQ guides for candidates
        UserGuide::create([
            'heading' => [
                'en' => 'How to Apply for Jobs',
                'ar' => 'كيفية التقدم للوظائف'
            ],
            'content' => [
                'en' => 'Browse available jobs in the Jobs section. Click on any job that interests you to view details. Click "Apply Now" and fill out the application form. Make sure your profile is complete with updated resume and contact information.',
                'ar' => 'تصفح الوظائف المتاحة في قسم الوظائف. اضغط على أي وظيفة تهمك لعرض التفاصيل. اضغط "تقدم الآن" واملأ نموذج الطلب. تأكد من اكتمال ملفك الشخصي مع السيرة الذاتية المحدثة ومعلومات الاتصال.'
            ],
            'content_type' => 'faq',
            'target_audience' => 'candidates',
            'is_active' => true,
        ]);

        UserGuide::create([
            'heading' => [
                'en' => 'How to Update Your Profile',
                'ar' => 'كيفية تحديث ملفك الشخصي'
            ],
            'content' => [
                'en' => 'Go to your Profile section and click "Edit Profile". Update your personal information, work experience, education, and skills. Don\'t forget to upload a recent resume and professional photo.',
                'ar' => 'اذهب إلى قسم ملفك الشخصي واضغط "تحرير الملف". حدث معلوماتك الشخصية وخبرة العمل والتعليم والمهارات. لا تنس تحميل سيرة ذاتية حديثة وصورة مهنية.'
            ],
            'content_type' => 'faq',
            'target_audience' => 'candidates',
            'is_active' => true,
        ]);

        // Create Terms and Privacy guides
        UserGuide::create([
            'heading' => [
                'en' => 'Terms of Service',
                'ar' => 'شروط الخدمة'
            ],
            'content' => [
                'en' => 'By using our recruitment platform, you agree to these terms of service. You must provide accurate information, respect other users, and comply with all applicable laws. We reserve the right to suspend accounts that violate these terms.',
                'ar' => 'باستخدام منصة التوظيف الخاصة بنا، فإنك توافق على شروط الخدمة هذه. يجب عليك تقديم معلومات دقيقة واحترام المستخدمين الآخرين والامتثال لجميع القوانين المعمول بها. نحتفظ بالحق في تعليق الحسابات التي تنتهك هذه الشروط.'
            ],
            'content_type' => 'terms_privacy',
            'target_audience' => 'recruiters',
            'is_active' => true,
        ]);

        UserGuide::create([
            'heading' => [
                'en' => 'Privacy Policy',
                'ar' => 'سياسة الخصوصية'
            ],
            'content' => [
                'en' => 'We are committed to protecting your privacy. We collect and use your personal information only for recruitment purposes. Your data is encrypted and stored securely. We do not share your information with third parties without your consent.',
                'ar' => 'نحن ملتزمون بحماية خصوصيتك. نحن نجمع ونستخدم معلوماتك الشخصية لأغراض التوظيف فقط. بياناتك مشفرة ومخزنة بأمان. نحن لا نشارك معلوماتك مع أطراف ثالثة دون موافقتك.'
            ],
            'content_type' => 'terms_privacy',
            'target_audience' => 'candidates',
            'is_active' => true,
        ]);

        // Create some additional random guides using factory
        UserGuide::factory()
            ->count(10)
            ->create();
    }
}
