<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth as AuthController;
use App\Http\Controllers as Homepage;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\Mentor as Mentor;
use App\Http\Controllers\User as User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route Autentikasi
Auth::routes(['verify' => true]);

// Route Autentikasi Google
Route::get('user-google', [AuthController\LoginController::class, 'google'])->name('user.google');
Route::get('auth/google/callback', [AuthController\LoginController::class, 'handleProviderCallback'])->name('user.google.callback');

// Route Yang Bisa Diakses Oleh Pengguna Yang Belum Login / Sudah Login

    // Beranda Homepage
    Route::get('/', [Homepage\HomepageController::class, 'index'])->name('homepage.index');
    
    // Tentang Kami
    Route::resource('aboutus', Homepage\AboutUsController::class);
    
    // Artikel
    Route::resource('article', Homepage\ArticleController::class);
    Route::get('article/{article}/category', [Homepage\ArticleController::class, 'category'])->name('article.category');
    Route::get('article/{article}/tag', [Homepage\ArticleController::class, 'tag'])->name('article.tag');
    
    // Hubungi Kami
    Route::resource('contact', Homepage\ContactController::class);
    
    // Kelas
    Route::resource('course/exam/answer', Homepage\CourseExamAnswerController::class);
    Route::resource('course', Homepage\CourseController::class);
    
    // Promo
    Route::resource('discount', Homepage\DiscountController::class);
    
    // Diskusi
    Route::resource('discussion', Homepage\DiscussionController::class);
    
    // Email Berlangganan
    Route::resource('email/subscription', Homepage\EmailSubscriptionController::class, ['as' => 'email']);
    
    // Event
    Route::resource('event', Homepage\EventController::class);
    
    // FAQ
    Route::resource('faq', Homepage\FAQController::class);
    
    // Mentor
    Route::resource('mentor/verification', Homepage\MentorVerificationController::class, ['as' => 'mentor']);
    
    // Kuesioner
    Route::resource('questionnaire', Homepage\QuestionnaireController::class);

// Route Yang Hanya Bisa Diakses Oleh Pengguna Yang Rolenya Administrator
Route::middleware(['auth','verified','isAdmin'])->group(function () {

    // Route List DataTables

        // Pengumuman
        Route::get('admin-announcement-list', [Admin\AnnouncementController::class, 'listAnnouncement']);
        
        // Artikel
        Route::get('admin-article-category-list', [Admin\ArticleCategoryController::class, 'listArticleCategory']);
        Route::get('admin-article-tag-list', [Admin\ArticleTagController::class, 'listArticleTag']);
        Route::get('admin-article-tagged-list', [Admin\ArticleTaggedController::class, 'listArticleTagged']);
        Route::get('admin-article-list', [Admin\ArticleController::class, 'listArticle']);
        
        // Transaksi
        Route::get('admin-checkout-list', [Admin\CheckoutController::class, 'listCheckout']);
        
        // Kelas
        Route::get('admin-course-exam-answer-list', [Admin\CourseExamAnswerController::class, 'listCourseExamAnswer']);
        Route::get('admin-course-exam-list', [Admin\CourseExamController::class, 'listCourseExam']);
        Route::get('admin-course-material-list', [Admin\CourseMaterialController::class, 'listCourseMaterial']);
        Route::get('admin-course-subtopic-list', [Admin\CourseSubTopicController::class, 'listCourseSubTopic']);
        Route::get('admin-course-category-list', [Admin\CourseCategoryController::class, 'listCourseCategory']);
        Route::get('admin-course-member-list', [Admin\CourseMemberController::class, 'listCourseMember']);
        Route::get('admin-course-certificate-list', [Admin\CourseCertificateController::class, 'listCourseCertificate']);
        Route::get('admin-course-list', [Admin\CourseController::class, 'listCourse']);
        
        // Promo
        Route::get('admin-discount-list', [Admin\DiscountController::class, 'listDiscount']);
        
        // Diskusi
        Route::get('admin-discussion-category-list', [Admin\DiscussionCategoryController::class, 'listDiscussionCategory']);
        Route::get('admin-discussion-list', [Admin\DiscussionController::class, 'listDiscussion']);
        
        // Email Berlangganan
        Route::get('admin-email-subscription-list', [Admin\EmailSubscriptionController::class, 'listEmailSubscription']);
        
        // Event
        Route::get('admin-event-category-list', [Admin\EventCategoryController::class, 'listEventCategory']);
        Route::get('admin-event-list', [Admin\EventController::class, 'listEvent']);
        
        // Verifikasi Mentor
        Route::get('admin-mentor-verification-list', [Admin\MentorVerificationController::class, 'listMentorVerification']);

        // Pesan
        Route::get('admin-message-list', [Admin\MessageController::class, 'listMessage']);
        Route::get('admin-message-sended-list', [Admin\MessageController::class, 'sendedMessage']);
        Route::get('admin-message-received-list', [Admin\MessageController::class, 'receivedMessage']);

        // Notifikasi
        Route::get('admin-notification-list', [Admin\NotificationController::class, 'listNotification']);
        
        // Kuesioner
        Route::get('admin-questionnaire-list', [Admin\QuestionnaireController::class, 'listQuestionnaire']);
        
        // Pengguna
        Route::get('admin-user-list', [Admin\UserController::class, 'listUser']);
    
    // Route Trash DataTables

        // Pengumuman
        Route::get('admin-announcement-trash', [Admin\AnnouncementController::class, 'trashAnnouncement']);
        
        // Artikel
        Route::get('admin-article-category-trash', [Admin\ArticleCategoryController::class, 'trashArticleCategory']);
        Route::get('admin-article-tag-trash', [Admin\ArticleTagController::class, 'trashArticleTag']);
        Route::get('admin-article-tagged-trash', [Admin\ArticleTaggedController::class, 'trashArticleTagged']);
        Route::get('admin-article-comment-trash', [Admin\ArticleCommentController::class, 'trashArticleComment']);
        Route::get('admin-article-trash', [Admin\ArticleController::class, 'trashArticle']);
        
        // Transaksi
        Route::get('admin-checkout-trash', [Admin\CheckoutController::class, 'trashCheckout']);
        
        // Kelas
        Route::get('admin-course-exam-answer-trash', [Admin\CourseExamAnswerController::class, 'trashCourseExamAnswer']);
        Route::get('admin-course-exam-trash', [Admin\CourseExamController::class, 'trashCourseExam']);
        Route::get('admin-course-material-trash', [Admin\CourseMaterialController::class, 'trashCourseMaterial']);
        Route::get('admin-course-subtopic-trash', [Admin\CourseSubTopicController::class, 'trashCourseSubTopic']);
        Route::get('admin-course-category-trash', [Admin\CourseCategoryController::class, 'trashCourseCategory']);
        Route::get('admin-course-member-trash', [Admin\CourseMemberController::class, 'trashCourseMember']);
        Route::get('admin-course-certificate-trash', [Admin\CourseCertificateController::class, 'trashCourseCertificate']);
        Route::get('admin-course-review-trash', [Admin\CourseReviewController::class, 'trashCourseReview']);
        Route::get('admin-course-trash', [Admin\CourseController::class, 'trashCourse']);
        
        // Promo
        Route::get('admin-discount-trash', [Admin\DiscountController::class, 'trashDiscount']);
        
        // Diskusi
        Route::get('admin-discussion-category-trash', [Admin\DiscussionCategoryController::class, 'trashDiscussionCategory']);
        Route::get('admin-discussion-answer-trash', [Admin\DiscussionAnswerController::class, 'trashDiscussionAnswer']);
        Route::get('admin-discussion-trash', [Admin\DiscussionController::class, 'trashDiscussion']);
        
        // Email Berlangganan
        Route::get('admin-email-subscription-trash', [Admin\EmailSubscriptionController::class, 'trashEmailSubscription']);
        
        // Event
        Route::get('admin-event-category-trash', [Admin\EventCategoryController::class, 'trashEventCategory']);
        Route::get('admin-event-trash', [Admin\EventController::class, 'trashEvent']);
        
        // Verifikasi Mentor
        Route::get('admin-mentor-verification-trash', [Admin\MentorVerificationController::class, 'trashMentorVerification']);
        
        // Pesan
        Route::get('admin-message-trash', [Admin\MessageController::class, 'trashMessage']);
        
        // Notifikasi
        Route::get('admin-notification-trash', [Admin\NotificationController::class, 'trashNotification']);
        
        // Kuesioner
        Route::get('admin-questionnaire-trash', [Admin\QuestionnaireController::class, 'trashQuestionnaire']);
        
        // Pengguna
        Route::get('admin-user-trash', [Admin\UserController::class, 'trashUser']);

    // Route Controller
    Route::prefix('admin')->name('admin.')->group(function () {

        // Pengumuman
        Route::get('announcement/trash', [Admin\AnnouncementController::class, 'trash'])->name('announcement.trash');
        Route::resource('announcement', Admin\AnnouncementController::class);
        Route::get('announcement/{announcement}/restore', [Admin\AnnouncementController::class, 'restore'])->name('announcement.restore');
        Route::delete('announcement/{announcement}/kill', [Admin\AnnouncementController::class, 'kill'])->name('announcement.kill');

        // Artikel
        Route::get('article/category/trash', [Admin\ArticleCategoryController::class, 'trash'])->name('article.category.trash');
        Route::resource('article/category', Admin\ArticleCategoryController::class, ['as' => 'article']);
        Route::get('article/category/{category}/restore', [Admin\ArticleCategoryController::class, 'restore'])->name('article.category.restore');
        Route::delete('article/category/{category}/kill', [Admin\ArticleCategoryController::class, 'kill'])->name('article.category.kill');

        Route::get('article/tag/trash', [Admin\ArticleTagController::class, 'trash'])->name('article.tag.trash');
        Route::resource('article/tag', Admin\ArticleTagController::class, ['as' => 'article']);
        Route::get('article/tag/{tag}/restore', [Admin\ArticleTagController::class, 'restore'])->name('article.tag.restore');
        Route::delete('article/tag/{tag}/kill', [Admin\ArticleTagController::class, 'kill'])->name('article.tag.kill');

        Route::get('article/tagged/trash', [Admin\ArticleTaggedController::class, 'trash'])->name('article.tagged.trash');
        Route::resource('article/tagged', Admin\ArticleTaggedController::class, ['as' => 'article']);
        Route::get('article/tagged/{tagged}/restore', [Admin\ArticleTaggedController::class, 'restore'])->name('article.tagged.restore');
        Route::delete('article/tagged/{tagged}/kill', [Admin\ArticleTaggedController::class, 'kill'])->name('article.tagged.kill');

        Route::get('article/comment/trash', [Admin\ArticleCommentController::class, 'trash'])->name('article.comment.trash');
        Route::resource('article/comment', Admin\ArticleCommentController::class, ['as' => 'article']);
        Route::get('article/comment/{comment}/restore', [Admin\ArticleCommentController::class, 'restore'])->name('article.comment.restore');
        Route::delete('article/comment/{comment}/kill', [Admin\ArticleCommentController::class, 'kill'])->name('article.comment.kill');

        Route::get('article/trash', [Admin\ArticleController::class, 'trash'])->name('article.trash');
        Route::resource('article', Admin\ArticleController::class);
        Route::put('article/{article}/review',[Admin\ArticleController::class, 'review'])->name('article.review');
        Route::get('article/{article}/feature', [Admin\ArticleController::class, 'feature'])->name('article.feature');
        Route::get('article/{article}/unfeature', [Admin\ArticleController::class, 'unfeature'])->name('article.unfeature');
        Route::get('article/{article}/restore', [Admin\ArticleController::class, 'restore'])->name('article.restore');
        Route::delete('article/{article}/kill', [Admin\ArticleController::class, 'kill'])->name('article.kill');

        // Transaksi
        Route::get('checkout/trash', [Admin\CheckoutController::class, 'trash'])->name('checkout.trash');
        Route::resource('checkout', Admin\CheckoutController::class);
        Route::get('checkout/{checkout}/restore', [Admin\CheckoutController::class, 'restore'])->name('checkout.restore');
        Route::delete('checkout/{checkout}/kill', [Admin\CheckoutController::class, 'kill'])->name('checkout.kill');

        // Kelas
        Route::get('course/exam/answer/trash', [Admin\CourseExamAnswerController::class, 'trash'])->name('course.exam.answer.trash');
        Route::resource('course/exam/answer', Admin\CourseExamAnswerController::class, ['as' => 'course.exam']);
        Route::get('course/exam/answer/{answer}/restore', [Admin\CourseExamAnswerController::class, 'restore'])->name('course.exam.answer.restore');
        Route::delete('course/exam/answer/{answer}/kill', [Admin\CourseExamAnswerController::class, 'kill'])->name('course.exam.answer.kill');

        Route::get('course/exam/trash', [Admin\CourseExamController::class, 'trash'])->name('course.exam.trash');
        Route::resource('course/exam', Admin\CourseExamController::class, ['as' => 'course']);
        Route::get('course/exam/{exam}/restore', [Admin\CourseExamController::class, 'restore'])->name('course.exam.restore');
        Route::delete('course/exam/{exam}/kill', [Admin\CourseExamController::class, 'kill'])->name('course.exam.kill');

        Route::get('course/material/trash', [Admin\CourseMaterialController::class, 'trash'])->name('course.material.trash');
        Route::resource('course/material', Admin\CourseMaterialController::class, ['as' => 'course']);
        Route::get('course/material/{material}/restore', [Admin\CourseMaterialController::class, 'restore'])->name('course.material.restore');
        Route::delete('course/material/{material}/kill', [Admin\CourseMaterialController::class, 'kill'])->name('course.material.kill');

        Route::get('course/subtopic/trash', [Admin\CourseSubTopicController::class, 'trash'])->name('course.subtopic.trash');
        Route::resource('course/subtopic', Admin\CourseSubTopicController::class, ['as' => 'course']);
        Route::get('course/subtopic/{subtopic}/restore', [Admin\CourseSubTopicController::class, 'restore'])->name('course.subtopic.restore');
        Route::delete('course/subtopic/{subtopic}/kill', [Admin\CourseSubTopicController::class, 'kill'])->name('course.subtopic.kill');

        Route::get('course/category/trash', [Admin\CourseCategoryController::class, 'trash'])->name('course.category.trash');
        Route::resource('course/category', Admin\CourseCategoryController::class, ['as' => 'course']);
        Route::get('course/category/{category}/restore', [Admin\CourseCategoryController::class, 'restore'])->name('course.category.restore');
        Route::delete('course/category/{category}/kill', [Admin\CourseCategoryController::class, 'kill'])->name('course.category.kill');

        Route::get('course/member/trash', [Admin\CourseMemberController::class, 'trash'])->name('course.member.trash');
        Route::resource('course/member', Admin\CourseMemberController::class, ['as' => 'course']);
        Route::get('course/member/{member}/restore', [Admin\CourseMemberController::class, 'restore'])->name('course.member.restore');
        Route::delete('course/member/{member}/kill', [Admin\CourseMemberController::class, 'kill'])->name('course.member.kill');

        Route::get('course/certificate/trash', [Admin\CourseCertificateController::class, 'trash'])->name('course.certificate.trash');
        Route::resource('course/certificate', Admin\CourseCertificateController::class, ['as' => 'course']);
        Route::get('course/certificate/{certificate}/restore', [Admin\CourseCertificateController::class, 'restore'])->name('course.certificate.restore');
        Route::delete('course/certificate/{certificate}/kill', [Admin\CourseCertificateController::class, 'kill'])->name('course.certificate.kill');

        Route::get('course/review/trash', [Admin\CourseReviewController::class, 'trash'])->name('course.review.trash');
        Route::resource('course/review', Admin\CourseReviewController::class, ['as' => 'course']);
        Route::get('course/review/{review}/restore', [Admin\CourseReviewController::class, 'restore'])->name('course.review.restore');
        Route::delete('course/review/{review}/kill', [Admin\CourseReviewController::class, 'kill'])->name('course.review.kill');

        Route::get('course/trash', [Admin\CourseController::class, 'trash'])->name('course.trash');
        Route::resource('course', Admin\CourseController::class);
        Route::get('course/{course}/restore', [Admin\CourseController::class, 'restore'])->name('course.restore');
        Route::delete('course/{course}/kill', [Admin\CourseController::class, 'kill'])->name('course.kill');

        // Promo
        Route::get('discount/trash', [Admin\DiscountController::class, 'trash'])->name('discount.trash');
        Route::resource('discount', Admin\DiscountController::class);
        Route::get('discount/{discount}/restore', [Admin\DiscountController::class, 'restore'])->name('discount.restore');
        Route::delete('discount/{discount}/kill', [Admin\DiscountController::class, 'kill'])->name('discount.kill');

        // Diskusi
        Route::get('discussion/category/trash', [Admin\DiscussionCategoryController::class, 'trash'])->name('discussion.category.trash');
        Route::resource('discussion/category', Admin\DiscussionCategoryController::class, ['as' => 'discussion']);
        Route::get('discussion/category/{category}/restore', [Admin\DiscussionCategoryController::class, 'restore'])->name('discussion.category.restore');
        Route::delete('discussion/category/{category}/kill', [Admin\DiscussionCategoryController::class, 'kill'])->name('discussion.category.kill');

        Route::get('discussion/answer/trash', [Admin\DiscussionAnswerController::class, 'trash'])->name('discussion.answer.trash');
        Route::resource('discussion/answer', Admin\DiscussionAnswerController::class, ['as' => 'discussion']);
        Route::get('discussion/answer/{answer}/restore', [Admin\DiscussionAnswerController::class, 'restore'])->name('discussion.answer.restore');
        Route::delete('discussion/answer/{answer}/kill', [Admin\DiscussionAnswerController::class, 'kill'])->name('discussion.answer.kill');

        Route::get('discussion/trash', [Admin\DiscussionController::class, 'trash'])->name('discussion.trash');
        Route::resource('discussion', Admin\DiscussionController::class);
        Route::get('discussion/{discussion}/restore', [Admin\DiscussionController::class, 'restore'])->name('discussion.restore');
        Route::delete('discussion/{discussion}/kill', [Admin\DiscussionController::class, 'kill'])->name('discussion.kill');

        // Buat Email
        Route::resource('email/broadcast', Admin\EmailBroadcastController::class, ['as' => 'email']);

        // Email Berlangganan
        Route::get('email/subscription/trash', [Admin\EmailSubscriptionController::class, 'trash'])->name('email.subscription.trash');
        Route::resource('email/subscription', Admin\EmailSubscriptionController::class, ['as' => 'email']);
        Route::get('email/subscription/{subscription}/restore', [Admin\EmailSubscriptionController::class, 'restore'])->name('email.subscription.restore');
        Route::delete('email/subscription/{subscription}/kill', [Admin\EmailSubscriptionController::class, 'kill'])->name('email.subscription.kill');

        // Event
        Route::get('event/category/trash', [Admin\EventCategoryController::class, 'trash'])->name('event.category.trash');
        Route::resource('event/category', Admin\EventCategoryController::class, ['as' => 'event']);
        Route::get('event/category/{category}/restore', [Admin\EventCategoryController::class, 'restore'])->name('event.category.restore');
        Route::delete('event/category/{category}/kill', [Admin\EventCategoryController::class, 'kill'])->name('event.category.kill');

        Route::get('event/trash', [Admin\EventController::class, 'trash'])->name('event.trash');
        Route::resource('event', Admin\EventController::class);
        Route::get('event/{event}/restore', [Admin\EventController::class, 'restore'])->name('event.restore');
        Route::delete('event/{event}/kill', [Admin\EventController::class, 'kill'])->name('event.kill');

        // Verifikasi Mentor
        Route::get('mentor/verification/trash', [Admin\MentorVerificationController::class, 'trash'])->name('mentor.verification.trash');
        Route::resource('mentor/verification', Admin\MentorVerificationController::class, ['as' => 'mentor']);
        Route::get('mentor/verification/{verification}/restore', [Admin\MentorVerificationController::class, 'restore'])->name('mentor.verification.restore');
        Route::delete('mentor/verification/{verification}/kill', [Admin\MentorVerificationController::class, 'kill'])->name('mentor.verification.kill');

        // Pesan
        Route::get('message/trash', [Admin\MessageController::class, 'trash'])->name('message.trash');
        Route::get('message/sended', [Admin\MessageController::class, 'sended'])->name('message.sended');
        Route::get('message/received', [Admin\MessageController::class, 'received'])->name('message.received');
        Route::resource('message', Admin\MessageController::class);
        Route::get('message/{message}/restore', [Admin\MessageController::class, 'restore'])->name('message.restore');
        Route::delete('message/{message}/kill', [Admin\MessageController::class, 'kill'])->name('message.kill');

        // Notifikasi
        Route::get('notification/trash', [Admin\NotificationController::class, 'trash'])->name('notification.trash');
        Route::resource('notification', Admin\NotificationController::class);
        Route::get('notification/{notification}/restore', [Admin\NotificationController::class, 'restore'])->name('notification.restore');
        Route::delete('notification/{notification}/kill', [Admin\NotificationController::class, 'kill'])->name('notification.kill');

        // Kuesioner
        Route::get('questionnaire/trash', [Admin\QuestionnaireController::class, 'trash'])->name('questionnaire.trash');
        Route::resource('questionnaire', Admin\QuestionnaireController::class);
        Route::get('questionnaire/{questionnaire}/restore', [Admin\QuestionnaireController::class, 'restore'])->name('questionnaire.restore');
        Route::delete('questionnaire/{questionnaire}/kill', [Admin\QuestionnaireController::class, 'kill'])->name('questionnaire.kill');

        // Pengguna
        Route::get('user/trash', [Admin\UserController::class, 'trash'])->name('user.trash');
        Route::resource('user', Admin\UserController::class);
        Route::get('user/{user}/role', [Admin\UserController::class, 'role'])->name('user.role');
        Route::get('user/{user}/restore', [Admin\UserController::class, 'restore'])->name('user.restore');
        Route::delete('user/{user}/kill', [Admin\UserController::class, 'kill'])->name('user.kill');

    });

    // Route Dashboard Admin
    Route::resource('admin', Admin\AdminController::class);

});

// Route Yang Hanya Bisa Diakses Oleh Pengguna Yang Rolenya Mentor
Route::middleware(['auth','verified','isMentor'])->group(function () {

    // Route List DataTables

        // Transaksi
        Route::get('mentor-checkout-list', [Mentor\CheckoutController::class, 'listCheckout']);
        
        // Kelas
        Route::get('mentor-course-exam-answer-list', [Mentor\CourseExamAnswerController::class, 'listCourseExamAnswer']);
        Route::get('mentor-course-exam-list', [Mentor\CourseExamController::class, 'listCourseExam']);
        Route::get('mentor-course-material-list', [Mentor\CourseMaterialController::class, 'listCourseMaterial']);
        Route::get('mentor-course-subtopic-list', [Mentor\CourseSubTopicController::class, 'listCourseSubTopic']);
        Route::get('mentor-course-member-list', [Mentor\CourseMemberController::class, 'listCourseMember']);
        Route::get('mentor-course-certificate-list', [Mentor\CourseCertificateController::class, 'listCourseCertificate']);
        Route::get('mentor-course-list', [Mentor\CourseController::class, 'listCourse']);
        
        // Event
        Route::get('mentor-event-list', [Mentor\EventController::class, 'listEvent']);

    // Route Controller
    Route::prefix('dashboard/mentor')->name('dashboard.mentor.')->group(function () {

        // Transaksi
        Route::resource('checkout', Mentor\CheckoutController::class);
        
        // Kelas
        Route::resource('course/exam/answer', Mentor\CourseExamAnswerController::class, ['as' => 'course.exam']);
        Route::resource('course/exam', Mentor\CourseExamController::class, ['as' => 'course']);
        Route::resource('course/material', Mentor\CourseMaterialController::class, ['as' => 'course']);
        Route::resource('course/subtopic', Mentor\CourseSubTopicController::class, ['as' => 'course']);
        Route::resource('course/member', Mentor\CourseMemberController::class, ['as' => 'course']);
        Route::resource('course/certificate', Mentor\CourseCertificateController::class, ['as' => 'course']);
        Route::resource('course', Mentor\CourseController::class);
        
        // Event
        Route::resource('event', Mentor\EventController::class);

    });

});

// Route Yang Hanya Bisa Diakses Oleh Pengguna Yang Rolenya User dan Mentor
Route::middleware(['auth','verified','isUser'])->group(function () {

    // Route Welcome
    Route::get('/welcome', function () {
        return view('auth.welcome');
    })->name('welcome');

    // Route List DataTables

        // Pengumuman
        Route::get('user-announcement-list', [User\AnnouncementController::class, 'listAnnouncement']);
        
        // Artikel
        Route::get('user-article-list', [User\ArticleController::class, 'listArticle']);
        
        // Transaksi
        Route::get('user-checkout-list', [User\CheckoutController::class, 'listCheckout']);
        
        // Kelas
        Route::get('user-course-exam-answer-list', [User\CourseExamAnswerController::class, 'listCourseExamAnswer']);
        Route::get('user-course-member-list', [User\CourseMemberController::class, 'listCourseMember']);
        Route::get('user-course-certificate-list', [User\CourseCertificateController::class, 'listCourseCertificate']);
        
        // Diskusi
        Route::get('user-discussion-list', [User\DiscussionController::class, 'listDiscussion']);
        
        // Verifikasi Mentor
        Route::get('user-mentor-verification-list', [User\MentorVerificationController::class, 'listMentorVerification']);

        // Pesan
        Route::get('user-message-sended-list', [User\MessageController::class, 'listMessageSended']);
        Route::get('user-message-received-list', [User\MessageController::class, 'listMessageReceived']);
        Route::get('user-message-list', [User\MessageController::class, 'listMessage']);

        // Notifikasi
        Route::get('user-notification-list', [User\NotificationController::class, 'listNotification']);

    // Route Controller
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // Pengumuman
        Route::resource('announcement', User\AnnouncementController::class);
        
        // Artikel
        Route::resource('article/comment', User\ArticleCommentController::class, ['as' => 'article']);
        Route::resource('article', User\ArticleController::class);
        
        // Transaksi
        Route::resource('checkout', User\CheckoutController::class);
        
        // Kelas
        Route::resource('course/exam/answer', User\CourseExamAnswerController::class, ['as' => 'course.exam']);
        Route::resource('course/member', User\CourseMemberController::class, ['as' => 'course']);
        Route::resource('course/certificate', User\CourseCertificateController::class, ['as' => 'course']);
        Route::resource('course/review', User\CourseReviewController::class, ['as' => 'course']);
        
        // Diskusi
        Route::resource('discussion/answer', User\DiscussionAnswerController::class, ['as' => 'discussion']);
        Route::resource('discussion', User\DiscussionController::class);
        
        // Verifikasi Mentor
        Route::resource('mentor/verification', User\MentorVerificationController::class, ['as' => 'mentor']);
        
        // Pesan
        Route::get('message/sended', [User\MessageController::class, 'sended'])->name('message.sended');
        Route::get('message/received', [User\MessageController::class, 'received'])->name('message.received');
        Route::resource('message', User\MessageController::class);

        // Notifikasi
        Route::resource('notification', User\NotificationController::class);
        
        // Pengguna
        Route::resource('user', User\UserController::class);

    });

    // Route Dashboard User
    Route::resource('dashboard', User\DashboardController::class);

});